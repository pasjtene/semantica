<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Suggestion
 *
 * @ORM\Table(name="suggestion")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\SuggestionRepository")
 */
class Suggestion extends BaseInterface
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
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\visitor",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $visitor;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\user",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


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
     * Set status
     *
     * @param boolean $status
     *
     * @return Suggestion
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set person
     *
     * @param \Web\EntityBundle\Entity\Person $person
     *
     * @return Suggestion
     */
    public function setPerson(\Web\EntityBundle\Entity\Person $person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Web\EntityBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }
}
