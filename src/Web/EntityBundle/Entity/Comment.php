<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\CommentRepository")
 */
class Comment extends BaseInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Participator",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $participator;

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
     * Set project
     *
     * @param \Web\EntityBundle\Entity\Projet $project
     *
     * @return Comment
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
     * @return Comment
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

    /**
     * Set user
     *
     * @param \Web\EntityBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\Web\EntityBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Web\EntityBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set participator
     *
     * @param \Web\EntityBundle\Entity\Participator $participator
     *
     * @return Comment
     */
    public function setParticipator(\Web\EntityBundle\Entity\Participator $participator)
    {
        $this->participator = $participator;

        return $this;
    }

    /**
     * Get participator
     *
     * @return \Web\EntityBundle\Entity\Participator
     */
    public function getParticipator()
    {
        return $this->participator;
    }
}
