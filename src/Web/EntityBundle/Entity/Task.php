<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Task
 * @UniqueEntity(fields="identity", message=" task.identity.UniqueEntity")
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\TaskRepository")
 */
class Task extends BaseInterface
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
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Planning",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $planning;

    /**
     * @var string
     * @Assert\NotBlank(message="task.identity.NotBlank")
     * @ORM\Column(name="identity", type="string", length=255, unique=true)
     */
    private $identity;

    /**
     * @var string
     * @Assert\NotBlank(message="task.libelle.NotBlank")
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     * @Assert\NotBlank(message="task.status.NotBlank")
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


    /**
     * @var string
     * @Assert\NotBlank(message="task.rate.NotBlank")
     * @ORM\Column(name="rate", type="string", length=255)
     */
    private $rate;


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
     * Set identity
     *
     * @param string $identity
     *
     * @return Task
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Task
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set planning
     *
     * @param \Web\EntityBundle\Entity\Planning $planning
     *
     * @return Task
     */
    public function setPlanning(\Web\EntityBundle\Entity\Planning $planning)
    {
        $this->planning = $planning;

        return $this;
    }

    /**
     * Get planning
     *
     * @return \Web\EntityBundle\Entity\Planning
     */
    public function getPlanning()
    {
        return $this->planning;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set rate
     *
     * @param string $rate
     *
     * @return Task
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }
}
