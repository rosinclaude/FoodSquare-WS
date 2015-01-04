<?php

namespace Foodsquare\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Comment")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="Foodsquare\CommonBundle\Entity\CommentThread")
     */
    protected $thread;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Foodsquare\CommonBundle\Entity\Users")
     * @var Users
     */
    protected $commenter;
    
    /**
     * @var text
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    
    /**
     * Constructor
     */
    function __construct(){
        $this->date = new \DateTime();
    }
    
    
    /**
     * @ORM\prePersist
     */
    public function increase()
    {
        $this->thread->incrementNumComments();
    }

    /**
     * @ORM\preRemove
     */
    public function decrease()
    {
      $this->thread->decrementNumComments();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set thread
     *
     * @param \Foodsquare\CommonBundle\Entity\CommentThread $thread
     * @return Comment
     */
    public function setThread(\Foodsquare\CommonBundle\Entity\CommentThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Foodsquare\CommonBundle\Entity\CommentThread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set commenter
     *
     * @param \Foodsquare\CommonBundle\Entity\Users $commenter
     * @return Commenter
     */
    public function setCommenter(\Foodsquare\CommonBundle\Entity\Users $commenter = null)
    {
        $this->commenter = $commenter;

        return $this;
    }

    /**
     * Get commenter
     *
     * @return \Foodsquare\CommonBundle\Entity\Users 
     */
    public function getCommenter()
    {
        return $this->commenter;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comment
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

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
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
