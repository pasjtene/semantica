<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\CustomerRepository")
 */
class Customer
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
     *
     * @ORM\Column(name="emailadress", type="string", length=255, unique=true)
     */
    private $emailadress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


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
     * Set emailadress
     *
     * @param string $emailadress
     *
     * @return Customer
     */
    public function setEmailadress($emailadress)
    {
        $this->emailadress = $emailadress;

        return $this;
    }

    /**
     * Get emailadress
     *
     * @return string
     */
    public function getEmailadress()
    {
        return $this->emailadress;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Customer
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
