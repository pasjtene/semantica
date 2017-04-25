<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Projet
 *
 * @ORM\Table(name="projet")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\ProjetRepository")
 */
class Projet
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
     * @Assert\NotBlank(message="project.name.NotBlank")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="project.email.NotBlank")
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     * @Assert\NotBlank(message="project.objet.NotBlank")
     * @ORM\Column(name="objet", type="string", length=255, nullable=true)
     */
    private $objet;

    /**
     * @var string
     * @Assert\NotBlank(message="project.description.NotBlank")
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="files", type="text", nullable=true)
     */
    private $files;

    /**
     * @var string
     * @ORM\Column(name="hashfiles", type="text", nullable=true)
     */
    private $hashfiles;

    /**
     * @var string
     * @ORM\Column(name="extfiles", type="text", nullable=true)
     */
    private $extfiles;

    /**
     * @var string
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=true)
     */
    private $time;

    public function truncate($string, $length){
        $value =null;
        $tab = str_split($string);
        for($i=0;$i<strlen($string);$i++)
        {
            $value .=$tab[$i];
            if($i==($length-1))
            {
                $value .="[...]";
                return $value;
            }
        }
        return $value;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Projet
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Projet
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
     * Set phone
     *
     * @param string $phone
     *
     * @return Projet
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
     * Set objet
     *
     * @param string $objet
     *
     * @return Projet
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Projet
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set files
     *
     * @param string $files
     *
     * @return Projet
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get files
     *
     * @return string
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Projet
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Projet
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
     * Set city
     *
     * @param string $city
     *
     * @return Projet
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
     * Set type
     *
     * @param string $type
     *
     * @return Projet
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Projet
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }



    protected $file;

    public function setFile(UploadedFile $file)
    {
        $this->file= $file;
        if(  $this->file!=null){
            $this->setFiles(uniqid().$this->getFile()->getClientOriginalName());
        }

        return $this;
    }

    public function getFile()
    {
        return  $this->file;
    }
    public function path(){
        $file = new Files();
        return $this->hashfiles==null? null: $file->initialpath."projet/".$this->hashfiles;
    }

    /**
     * Set hashfiles
     *
     * @param string $hashfiles
     *
     * @return Projet
     */
    public function setHashfiles($hashfiles)
    {
        $this->hashfiles = $hashfiles;

        return $this;
    }

    /**
     * Get hashfiles
     *
     * @return string
     */
    public function getHashfiles()
    {
        return $this->hashfiles;
    }

    /**
     * Set extfiles
     *
     * @param string $extfiles
     *
     * @return Projet
     */
    public function setExtfiles($extfiles)
    {
        $this->extfiles = $extfiles;

        return $this;
    }

    /**
     * Get extfiles
     *
     * @return string
     */
    public function getExtfiles()
    {
        return $this->extfiles;
    }
}
