<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 * @ORM\Table(name="fos_user")
 * @UniqueEntity(fields="email", message="user.email.UniqueEntity")
 * @UniqueEntity(fields="username", message="user.username.UniqueEntity")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\UserRepository")
 */
class User extends BaseUser
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
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
    */
    protected $picture;

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
       * @return User
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
       * @return User
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
       * Set pleasantries
       *
       * @param string $pleasantries
       *
       * @return User
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
       * @return User
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
       * @return User
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

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }
}
