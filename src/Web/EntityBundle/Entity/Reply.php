<?php

namespace Web\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Reply
 *
 * @ORM\Table(name="reply")
 * @ORM\Entity(repositoryClass="Web\EntityBundle\Repository\ReplyRepository")
 */
class Reply extends BaseInterface
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
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Comment",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Web\EntityBundle\Entity\Participator",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $participator;


    /**
     * Set comment
     *
     * @param \Web\EntityBundle\Entity\Comment $comment
     *
     * @return Reply
     */
    public function setComment(\Web\EntityBundle\Entity\Comment $comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return \Web\EntityBundle\Entity\Comment
     */
    public function getComment()
    {
        return $this->comment;
    }
}
