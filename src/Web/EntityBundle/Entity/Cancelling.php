<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Cancelling
 * @UniqueEntity(fields="identity", message="cancelling.addcode.UniqueEntity")
 * @ORM\Table(name="cancelling")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\CancellingRepository")
 */
class Cancelling
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
     * @var string
     * @Assert\NotBlank(message="cancelling.addcode.NotBlank")
     * @ORM\Column(name="addcode", type="string", length=255,unique=true)
     */
    private $addcode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="adddate", type="datetime", unique=true)
     */
    private $adddate;

    /**
     * @var string
     * @Assert\NotBlank(message="cancelling.adddescription.NotBlank")
     * @ORM\Column(name="adddescription", type="text")
     */
    private $adddescription;


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
     * Set addcode
     *
     * @param string $addcode
     *
     * @return Cancelling
     */
    public function setAddcode($addcode)
    {
        $this->addcode = $addcode;

        return $this;
    }

    /**
     * Get addcode
     *
     * @return string
     */
    public function getAddcode()
    {
        return $this->addcode;
    }

    /**
     * Set adddate
     *
     * @param \DateTime $adddate
     *
     * @return Cancelling
     */
    public function setAdddate($adddate)
    {
        $this->adddate = $adddate;

        return $this;
    }

    /**
     * Get adddate
     *
     * @return \DateTime
     */
    public function getAdddate()
    {
        return $this->adddate;
    }

    /**
     * Set adddescription
     *
     * @param string $adddescription
     *
     * @return Cancelling
     */
    public function setAdddescription($adddescription)
    {
        $this->adddescription = $adddescription;

        return $this;
    }

    /**
     * Get adddescription
     *
     * @return string
     */
    public function getAdddescription()
    {
        return $this->adddescription;
    }
}
