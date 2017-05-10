<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Person
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\PersonRepository")
 */
interface  Person
{


    /**
     * Get id
     *
     * @return int
     */
    public function getId();


    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Personne
     */
    public function setFirstname($firstname);


    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname();

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Personne
     */
    public function setLastname($lastname);

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname();
    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Personne
     */
    public function setPhone($phone);

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set pleasantries
     *
     * @param string $pleasantries
     *
     * @return Personne
     */
    public function setPleasantries($pleasantries);

    /**
     * Get pleasantries
     *
     * @return string
     */
    public function getPleasantries();
    /**
     * Set city
     *
     * @param string $city
     *
     * @return Personne
     */
    public function setCity($city);

    /**
     * Get city
     *
     * @return string
     */
    public function getCity();

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Personne
     */
    public function setCountry($country);

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry();
}

