<?php

namespace Foodsquare\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="miniature", type="string", length=255, nullable=true)
     */
    private $miniature;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @var Users
     * 
     * @ORM\ManyToOne(targetEntity="Foodsquare\CommonBundle\Entity\Users")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $owner;
    
    function __construct() {
        $this->date = new \DateTime();
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
     * Set url
     *
     * @param string $url
     * @return Photo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set miniature
     *
     * @param string $miniature
     * @return Photo
     */
    public function setMiniature($miniature)
    {
        $this->miniature = $miniature;

        return $this;
    }

    /**
     * Get miniature
     *
     * @return string 
     */
    public function getMiniature()
    {
        return $this->miniature;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Photo
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Photo
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
    
   /**
    * Fonction permettant de telecharger une image dans le dossier du site
    * @param $url url de l'image
    * @access public
    * @return l'url de l'image dans les dossiers
    */
   public static function downloadImage($url, $base64 = false) {	
       
        $dir=__DIR__."/../Resources/public/images/restaurants/";
        $mini=__DIR__."/../Resources/public/images/restaurants/thumbs/";
        
        if(!$base64){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $a = curl_exec($ch);
            if(preg_match('#Location: (.*)#', $a, $r))
                $imgUrl = trim($r[1]);
            else
                $imgUrl=$url; 

            $imgName = strtotime(date('Y-m-d H:i:s')).basename($imgUrl);
            $image_dest = $dir.$imgName;
            copy($imgUrl, $image_dest);
        }else{
            $data = explode(',', $url);
            $entry = base64_decode(isset($data[1])?$data[1]:$url);
            $imgUrl = imagecreatefromstring($entry);
            $imgName = strtotime(date('Y-m-d H:i:s')).rand(100, 100000).".jpg";
            $image_dest = $dir.$imgName;
            imagejpeg($imgUrl, $image_dest);
            imagedestroy ( $imgUrl );
        }
        
        $thumbs = $mini."thumbs-".$imgName;
        Photo::recupMiniature($image_dest, $thumbs, 300, FALSE, TRUE);

        return $imgName;

   }
    
   /*
    * Permet de créer une miniature carrée d'une image de forme quelconque.     
    * $src     désigne le nom de l'image source                
    * $dest     désigne le nom de l'image d'origine                
    * $largeur     désigne la largeur du carré de la miniature            
    * $pos     peut prendre les valeurs suivante :                 
    *             "left", "right" (si la photo est horizontale)
    *             "bottom","top" (si la photo est verticale) 
    *            ou n'importe quelle autre valeur pour le milieu.
    */  
   public static function recupMiniature( $image_src , $image_dest = NULL , $max_size = 100, $expand = FALSE, $square = FALSE)
   {


               if( !file_exists($image_src) ) 
               {
                   return FALSE;

               }

               // Récupère les infos de l'image
               $fileinfo = getimagesize($image_src);
               if( !$fileinfo ) return FALSE;

               $width     = $fileinfo[0];
               $height    = $fileinfo[1];
               $type_mime = $fileinfo['mime'];
               $type      = str_replace('image/', '', $type_mime);

               if( !$expand && max($width, $height)<=$max_size && (!$square || ($square && $width==$height) ) )
               {
                       // L'image est plus petite que max_size
                       if($image_dest)
                       {
                               return copy($image_src, $image_dest);
                       }
                       else
                       {
                               header('Content-Type: '. $type_mime);
                               return (boolean) readfile($image_src);
                       }
               }

               // Calcule les nouvelles dimensions
               $ratio = $width / $height;

               if( $square )
               {
                       $new_width = $new_height = $max_size;

                       if( $ratio > 1 )
                       {
                               // Paysage
                               $src_y = 0;
                               $src_x = round( ($width - $height) / 2 );

                               $src_w = $src_h = $height;
                       }
                       else
                       {
                               // Portrait
                               $src_x = 0;
                               $src_y = round( ($height - $width) / 2 );

                               $src_w = $src_h = $width;
                       }
               }
               else
               {
                       $src_x = $src_y = 0;
                       $src_w = $width;
                       $src_h = $height;

                       if ( $ratio > 1 )
                       {
                               // Paysage
                               $new_width  = $max_size;
                               $new_height = round( $max_size / $ratio );
                       }
                       else
                       {
                               // Portrait
                               $new_height = $max_size;
                               $new_width  = round( $max_size * $ratio );
                       }
               }

               // Ouvre l'image originale
               $func = 'imagecreatefrom' . $type;
               if( !function_exists($func))
               {

                   return FALSE;
               }

               $image_src = $func($image_src);
               $new_image = imagecreatetruecolor($new_width,$new_height);

               // Gestion de la transparence pour les png
               if( $type=='png' )
               {
                       imagealphablending($new_image,false);
                       if( function_exists('imagesavealpha') )
                               imagesavealpha($new_image,true);
               }

               // Gestion de la transparence pour les gif
               elseif( $type=='gif' && imagecolortransparent($image_src)>=0 )
               {
                       $transparent_index = imagecolortransparent($image_src);
                       $transparent_color = imagecolorsforindex($image_src, $transparent_index);
                       $transparent_index = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                       imagefill($new_image, 0, 0, $transparent_index);
                       imagecolortransparent($new_image, $transparent_index);
               }

               // Redimensionnement de l'image
               imagecopyresampled(
                       $new_image, $image_src,
                       0, 0, $src_x, $src_y,
                       $new_width, $new_height, $src_w, $src_h
               );

               // Enregistrement de l'image
               $func = 'image'. $type;
               if($image_dest)
               {

                       $func($new_image, $image_dest);
               }
               else
               {
                       header('Content-Type: '. $type_mime);
                       $func($new_image);
               }

               // Libération de la mémoire
               imagedestroy($new_image); 

               return TRUE;
       }

    /**
     * Set owner
     *
     * @param \Foodsquare\CommonBundle\Entity\Users $owner
     * @return Photo
     */
    public function setOwner(\Foodsquare\CommonBundle\Entity\Users $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Foodsquare\CommonBundle\Entity\Users 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
