<?php

namespace Foodsquare\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Foodsquare\CommonBundle\Entity\Repository\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    private $googleId;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="google_rate", type="float")
     */
    private $googleRate = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo = "restaurant.jpg";

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    
    /** 
     *
     * @ORM\OneToOne(targetEntity="Foodsquare\CommonBundle\Entity\RateThread", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $rate;
    
    /**
     *
     * @ORM\OneToOne(targetEntity="Foodsquare\CommonBundle\Entity\CommentThread", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $comments;
    
    /**
     * @ORM\ManyToMany(targetEntity="Foodsquare\CommonBundle\Entity\Photo", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $gallerie;
    
    function __construct() {
        $this->gallerie = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    /**
     * Creer les entités comment thread
     *
     * @return void 
     */
    public function createThread(){
        $this->comments = new \Foodsquare\CommonBundle\Entity\CommentThread("restaurant".$this->id);
        $this->rate = new \Foodsquare\CommonBundle\Entity\RateThread("restaurant".$this->id);
    
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
     * Set googleId
     *
     * @param string $googleId
     * @return Restaurant
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Restaurant
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Restaurant
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Restaurant
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set googleRate
     *
     * @param float $googleRate
     * @return Restaurant
     */
    public function setGoogleRate($googleRate)
    {
        $this->googleRate = $googleRate;

        return $this;
    }

    /**
     * Get googleRate
     *
     * @return float 
     */
    public function getGoogleRate()
    {
        return $this->googleRate;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Restaurant
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Restaurant
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
    
    /**
     * Add Photo
     *
     * @param \Foodsquare\CommonBundle\Entity\Photo $photo
     * @return Photo
     */
    public function addPhoto(\Foodsquare\CommonBundle\Entity\Photo $photo)
    {
        $this->gallerie[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \Foodsquare\CommonBundle\Entity\Photo $photo
     */
    public function removePhoto(\Foodsquare\CommonBundle\Entity\Photo $photo)
    {
        $this->gallerie->removeElement($photo);
    }

    /**
     * Set rate
     *
     * @param \Foodsquare\CommonBundle\Entity\RateThread $rate
     * @return Restaurant
     */
    public function setRate(\Foodsquare\CommonBundle\Entity\RateThread $rate = null)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return \Foodsquare\CommonBundle\Entity\RateThread 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set comments
     *
     * @param \Foodsquare\CommonBundle\Entity\CommentThread $comments
     * @return Restaurant
     */
    public function setComments(\Foodsquare\CommonBundle\Entity\CommentThread $comments = null)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return \Foodsquare\CommonBundle\Entity\CommentThread 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add gallerie
     *
     * @param \Foodsquare\CommonBundle\Entity\Photo $gallerie
     * @return Restaurant
     */
    public function addGallerie(\Foodsquare\CommonBundle\Entity\Photo $gallerie)
    {
        $this->gallerie[] = $gallerie;

        return $this;
    }

    /**
     * Remove gallerie
     *
     * @param \Foodsquare\CommonBundle\Entity\Photo $gallerie
     */
    public function removeGallerie(\Foodsquare\CommonBundle\Entity\Photo $gallerie)
    {
        $this->gallerie->removeElement($gallerie);
    }

    /**
     * Get gallerie
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGallerie()
    {
        return $this->gallerie;
    }
}
