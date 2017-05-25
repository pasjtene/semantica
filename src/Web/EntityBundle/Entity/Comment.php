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
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Participator",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $participator;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Projet",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $projet;

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


    /**
     * Set projet
     *
     * @param \Web\EntityBundle\Entity\Projet $projet
     *
     * @return Comment
     */
    public function setProjet(\Web\EntityBundle\Entity\Projet $projet)
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get projet
     *
     * @return \Web\EntityBundle\Entity\Projet
     */
    public function getProjet()
    {
        return $this->projet;
    }
}
