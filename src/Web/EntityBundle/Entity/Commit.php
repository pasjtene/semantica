<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Commit
 *
 * @ORM\Table(name="commit")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\CommitRepository")
 * @UniqueEntity(fields="identity", message="commit.code.UniqueEntity")
 */
class Commit extends BaseInterface
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
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Participator",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $participator;


    /**
     * @var string
     * @Assert\NotBlank(message="commit.code.NotBlank")
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
     * @return Commit
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
     * Set participator
     *
     * @param \Web\EntityBundle\Entity\Participator $participator
     *
     * @return Commit
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
