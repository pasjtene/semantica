<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Visitor
 * @ORM\Table(name="visitor")
 * @UniqueEntity(fields="email", message="person.email.UniqueEntity")
 * @UniqueEntity(fields="username", message="person.phone.UniqueEntity")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\VisitorRepository")
 */
 class Visitor
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
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var string
     * @Assert\NotBlank(message="person.email.NotBlank")
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;


    /**
     * @var string
     * @Assert\NotBlank(message="person.firstname.NotBlank")
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     * @var string
     * @Assert\NotBlank(message="person.phone.NotBlank")
     * @ORM\Column(name="phone", type="string", length=255, unique=true,)
     */
    protected $phone;

    /**
     * @var string
     * @Assert\NotBlank(message="person.pleasantries.NotBlank")
     * @ORM\Column(name="pleasantries", type="string", length=255, nullable=true)
     */
    protected $pleasantries;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    protected $country;



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
     * Set ip
     *
     * @param string $ip
     *
     * @return Visitor
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Visitor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

     /**
      * Set firstname
      *
      * @param string $firstname
      *
      * @return Personne
      */
     public function setFirstname($firstname)
     {
         $this->firstname = $firstname;

         return $this;
     }

     /**
      * Get firstname
      *
      * @return string
      */
     public function getFirstname()
     {
         return $this->firstname;
     }

     /**
      * Set lastname
      *
      * @param string $lastname
      *
      * @return Personne
      */
     public function setLastname($lastname)
     {
         $this->lastname = $lastname;

         return $this;
     }

     /**
      * Get lastname
      *
      * @return string
      */
     public function getLastname()
     {
         return $this->lastname;
     }

     /**
      * Set phone
      *
      * @param string $phone
      *
      * @return Personne
      */
     public function setPhone($phone)
     {
         $this->phone = $phone;

         return $this;
     }

     /**
      * Get phone
      *
      * @return string
      */
     public function getPhone()
     {
         return $this->phone;
     }

     /**
      * Set pleasantries
      *
      * @param string $pleasantries
      *
      * @return Personne
      */
     public function setPleasantries($pleasantries)
     {
         $this->pleasantries = $pleasantries;

         return $this;
     }

     /**
      * Get pleasantries
      *
      * @return string
      */
     public function getPleasantries()
     {
         return $this->pleasantries;
     }

     /**
      * Set city
      *
      * @param string $city
      *
      * @return Personne
      */
     public function setCity($city)
     {
         $this->city = $city;

         return $this;
     }

     /**
      * Get city
      *
      * @return string
      */
     public function getCity()
     {
         return $this->city;
     }

     /**
      * Set country
      *
      * @param string $country
      *
      * @return Personne
      */
     public function setCountry($country)
     {
         $this->country = $country;

         return $this;
     }

     /**
      * Get country
      *
      * @return string
      */
     public function getCountry()
     {
         return $this->country;
     }
}
