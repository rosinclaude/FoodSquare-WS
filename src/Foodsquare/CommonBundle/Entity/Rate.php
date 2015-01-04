<?php

namespace Foodsquare\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Rates")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Rate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Thread of this rate
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="Foodsquare\CommonBundle\Entity\RateThread")
     */
    protected $thread;
    
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Foodsquare\CommonBundle\Entity\Users")
     * @var Users
     */
    protected $rater;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;
    
    
    /**
     * Constructor
     */
    function __construct() {
        
    }
    
    
    /**
     * @ORM\prePersist
     */
    public function increase()
    {
        $this->thread->incrementNumRates();
        $this->thread->calculateAverage($this->rate);
    }

    /**
     * @ORM\preRemove
     */
    public function decrease()
    {
      $this->thread->decrementNumRates();
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
     * @param \Foodsquare\CommonBundle\Entity\RateThread $thread
     * @return Rate
     */
    public function setThread(\Foodsquare\CommonBundle\Entity\RateThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Foodsquare\CommonBundle\Entity\RateThread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set rater
     *
     * @param \Foodsquare\CommonBundle\Entity\Users $rater
     * @return Rater
     */
    public function setRater(\Foodsquare\CommonBundle\Entity\Users $rater = null)
    {
        $this->rater = $rater;

        return $this;
    }

    /**
     * Get rater
     *
     * @return \Foodsquare\CommonBundle\Entity\Users 
     */
    public function getRater()
    {
        return $this->rater;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     * @return Rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }
}
