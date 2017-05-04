<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 * @ORM\Table(name="fos_user")
 * @UniqueEntity(fields="identity", message="user.email.UniqueEntity")
 * @UniqueEntity(fields="identity", message="user.username.UniqueEntity")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\UserRepository")
 */
  class User extends BaseUser implements Person
{

    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

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
