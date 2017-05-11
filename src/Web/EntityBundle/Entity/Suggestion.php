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
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Visitor",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $visitor;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\User",cascade={"persist"})
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
     * Set visitor
     *
     * @param \Web\EntityBundle\Entity\visitor $visitor
     *
     * @return Suggestion
     */
    public function setVisitor(\Web\EntityBundle\Entity\visitor $visitor = null)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor
     *
     * @return \Web\EntityBundle\Entity\visitor
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * Set user
     *
     * @param \Web\EntityBundle\Entity\user $user
     *
     * @return Suggestion
     */
    public function setUser(\Web\EntityBundle\Entity\user $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Web\EntityBundle\Entity\user
     */
    public function getUser()
    {
        return $this->user;
    }
}
