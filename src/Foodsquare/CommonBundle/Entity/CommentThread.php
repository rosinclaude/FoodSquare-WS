<?php

namespace Foodsquare\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentThread
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CommentThread
{
    /**
     * @var string $id
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="numComment", type="integer")
     */
    private $numComment = 0;


    function __construct($id) {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return integer
     *  
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numComment
     *
     * @param integer $numComment
     * @return CommentThread
     */
    public function setNumComment($numComment)
    {
        $this->numComment = $numComment;

        return $this;
    }

    /**
     * Get numComment
     *
     * @return integer 
     */
    public function getNumComment()
    {
        return $this->numComment;
    }
    
    /**
     * Increments the number of comments by the supplied
     * value.
     *
     * @param  integer $by Value to increment comments by
     * @return integer The new comment total
     */
    public function incrementNumComments($by = 1)
    {
        return $this->numComment += intval($by);
    }
    
    /**
     * Decrements the number of comments by the supplied
     * value.
     *
     * @param  integer $by Value to increment comments by
     * @return integer The new comment total
     */
    public function decrementNumComments($by = 1)
    {
        return $this->numComment -= intval($by);
    }
    

    /**
     * Set id
     *
     * @param integer $id
     * @return CommentThread
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
