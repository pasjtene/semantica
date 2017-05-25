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
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="Web\EntityBundle\Entity\FileProjet", mappedBy="project",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $files;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Visitor",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $visitor;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;



    /**
     * @var string
     * @Assert\NotBlank(message="project.status.NotBlank")
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     * @ORM\Column(name="comment", type="text",  nullable=true)
     */
    private $comment;

    /**
     * @var string
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company;

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
     * Set company
     *
     * @param string $company
     *
     * @return Projet
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }




    /**
     * Set visitor
     *
     * @param \Web\EntityBundle\Entity\visitor $visitor
     *
     * @return Projet
     */
    public function setVisitor(\Web\EntityBundle\Entity\visitor $visitor = null)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor
     *
     * @return \Web\EntityBundle\Entity\visitor
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * Set user
     *
     * @param \Web\EntityBundle\Entity\user $user
     *
     * @return Projet
     */
    public function setUser(\Web\EntityBundle\Entity\user $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Web\EntityBundle\Entity\user
     */
    public function getUser()
    {
        return $this->user;
    }

    public  function CurrentStatus($value,$langage)
    {
        $val=null;
        if($langage=='fr')
        {
            switch($value)
            {
                case '0':
                case 'En cours':
                   $val = "Non validé";
                    break;
                case '1':
                    $val = "Accepté";
                    break;
                case '2':
                    $val = "En cours";
                    break;
                case '3':
                    $val = "Terminé";
                    break;
                case '4':
                    $val = "En pause";
                    break;
                case '5':
                    $val = "Budget épuisé";
                    break;
            }
        }
        else
        {
            switch($value)
            {
                case '0':
                case 'En cours':
                    $val = "Not valid";
                    break;
                case '1':
                    $val = "Accepted";
                    break;
                case '2':
                    $val = "In progress";
                    break;
                case '3':
                    $val = "Finish";
                    break;
                case '4':
                    $val = "On break";
                    break;
                case '5':
                    $val = "Budget run-down";
                    break;
            }
        }
        return $val;

    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add file
     *
     * @param \Web\EntityBundle\Entity\FileProjet $file
     *
     * @return Projet
     */
    public function addFile(\Web\EntityBundle\Entity\FileProjet $file)
    {
        $file->setProject($this);
        $this->files[] = $file;
        return $this;
    }

    public function setFiles(\Doctrine\Common\Collections\ArrayCollection $files){
        $this->files = $files;
        /** @var FileProjet $file */
        foreach ($files as $file){
            $file->setProject($this);
        }
    }

    /**
     * Remove file
     *
     * @param \Web\EntityBundle\Entity\FileProjet $file
     */
    public function removeFile(\Web\EntityBundle\Entity\FileProjet $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }


    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Projet
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
