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
class Projet extends BaseInterface
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
     * @Assert\NotBlank(message="project.status.NotBlank")
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     * @Assert\NotBlank(message="project.code.NotBlank")
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;


    /**
     * @var boolean
     * @Assert\NotBlank(message="project.state.NotBlank")
     * @ORM\Column(name="state", type="boolean")
     */
    private $state;

    /**
     * @var string
     * @Assert\NotBlank(message="project.title.NotBlank")
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


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
     * Set status
     *
     * @param string $status
     *
     * @return Projet
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Projet
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
     * Set state
     *
     * @param boolean $state
     *
     * @return Projet
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return boolean
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Projet
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
