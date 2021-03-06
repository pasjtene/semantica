<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * BaseInterface
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"Projet" = "Projet", "Commit" = "Commit","Comment" = "Comment" , "Suggestion" = "Suggestion", "Task" = "Task"})
 * @ORM\Table(name="base_interface")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\BaseInterfaceRepository")
 */
abstract class BaseInterface
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
     * @Assert\NotBlank(message="base.description.NotBlank")
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    public function getValue($string, $length){
        $value =null;
        $tab = str_split($string);
        for($i=0;$i<strlen($string);$i++)
        {
            $value .=$tab[$i];
            if($i==$length-1)
            {
                $value .="[...]";
                return $value;
            }
        }
        return $value;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;


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
     * Set description
     *
     * @param string $description
     *
     * @return BaseInterface
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return BaseInterface
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
