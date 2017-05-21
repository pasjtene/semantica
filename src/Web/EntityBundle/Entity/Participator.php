<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Participator
 * @UniqueEntity(fields="identity", message="participator.code.UniqueEntity")
 * @ORM\Table(name="participator")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\ParticipatorRepository")
 */
class Participator
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
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var string
     * @Assert\NotBlank(message="participator.code.NotBlank")
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     */
    private $code;


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
     * Set code
     *
     * @param string $code
     *
     * @return Participator
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set user
     *
     * @param \Web\EntityBundle\Entity\User $user
     *
     * @return Participator
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
     * Generate random code for user
     *
     * @return Participator
     */
    public function generateCode()
    {
        return $this->setCode(md5(uniqid()));
    }
}
