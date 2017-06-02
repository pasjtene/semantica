<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * FileProjet
 *
 * @ORM\Table(name="file_projet")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\FileProjetRepository")
 */
class FileProjet
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
     * Symfony\Component\Validator\Constraints\valid()
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="files")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="hashname", type="string", length=255)
     */
    private $hashname;

    /**
     * @var string
     *
     * @ORM\Column(name="extfile", type="string", length=255)
     */
    private $extfile;


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
     * @return FileProjet
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
     * Set hashname
     *
     * @param string $hashname
     *
     * @return FileProjet
     */
    public function setHashname($hashname)
    {
        $this->hashname = $hashname;

        return $this;
    }

    /**
     * Get hashname
     *
     * @return string
     */
    public function getHashname()
    {
        return $this->hashname;
    }

    /**
     * Set extfile
     *
     * @param string $extfile
     *
     * @return FileProjet
     */
    public function setExtfile($extfile)
    {
        $this->extfile = $extfile;

        return $this;
    }

    /**
     * Get extfile
     *
     * @return string
     */
    public function getExtfile()
    {
        return $this->extfile;
    }

    protected $file;

    public function setFile(UploadedFile $file)
    {
        $this->file= $file;
        if(  $this->file!=null){
            $this->setHashname(uniqid().$this->getFile()->getClientOriginalName());
        }

        return $this;
    }

    public function getFile()
    {
        return  $this->file;
    }
    public function path(){
        $file = new Files();
        return $this->hashname==null? null: $file->initialpath."projet/".$this->hashname;
    }


    /**
     * Set project
     *
     * @param \Web\EntityBundle\Entity\Projet $project
     *
     * @return FileProjet
     */
    public function setProject(\Web\EntityBundle\Entity\Projet $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Web\EntityBundle\Entity\Projet
     */
    public function getProject()
    {
        return $this->project;
    }
}
