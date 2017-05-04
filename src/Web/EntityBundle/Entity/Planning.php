<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Planning
 *
 * @ORM\Table(name="planning")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\PlanningRepository")
 */
class Planning
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
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Projet",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="datetime")
     */
    private $startdate;

    /**
     * @var string
     *
     * @ORM\Column(name="enddate", type="string", length=255)
     */
    private $enddate;


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
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return Planning
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param string $enddate
     *
     * @return Planning
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return string
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set project
     *
     * @param \Web\EntityBundle\Entity\Projet $project
     *
     * @return Planning
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
}
