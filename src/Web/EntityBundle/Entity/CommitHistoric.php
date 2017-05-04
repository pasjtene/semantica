<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * CommitHistoric
 *
 * @ORM\Table(name="commit_historic")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\CommitHistoricRepository")
 */
class CommitHistoric
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Commit",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commit;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Projet",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Task",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set commit
     *
     * @param \Web\EntityBundle\Entity\Commit $commit
     *
     * @return CommitHistoric
     */
    public function setCommit(\Web\EntityBundle\Entity\Commit $commit)
    {
        $this->commit = $commit;

        return $this;
    }

    /**
     * Get commit
     *
     * @return \Web\EntityBundle\Entity\Commit
     */
    public function getCommit()
    {
        return $this->commit;
    }

    /**
     * Set project
     *
     * @param \Web\EntityBundle\Entity\Projet $project
     *
     * @return CommitHistoric
     */
    public function setProject(\Web\EntityBundle\Entity\Projet $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Web\EntityBundle\Entity\Projet
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set task
     *
     * @param \Web\EntityBundle\Entity\Task $task
     *
     * @return CommitHistoric
     */
    public function setTask(\Web\EntityBundle\Entity\Task $task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \Web\EntityBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }
}
