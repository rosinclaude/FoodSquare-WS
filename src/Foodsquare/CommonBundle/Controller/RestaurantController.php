<?php

namespace Foodsquare\CommonBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\RedirectView;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Foodsquare\CommonBundle\Entity\Photo;



use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class RestaurantController extends \FOS\RestBundle\Controller\FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Récuperer un restaurant par son identifiant",
     *  requirements={
     *      },
     * )
     */
    public function postRestaurantAction(Request $request){

        $em   = $this->getDoctrine()->getManager();

        $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByToken($request->get('token'));

        if(!is_object($user)){
          throw $this->createNotFoundException("Accès Interdit Mr le hacker");
        }
        
        $restaurant =   $em->getRepository('FoodsquareCommonBundle:Restaurant')->findOneById($request->get('id'));

        if(!is_object($restaurant)){
          throw $this->createNotFoundException();
        }

        $comments = $em->getRepository('FoodsquareCommonBundle:Comment')->findByThread("restaurant".$request->get('id'));
        $comments_array = array();
        foreach ($comments as $obj){
           $comments_array[] = array(
               "id"=>$obj->getId(),
               "commenter" => $obj->getCommenter(),
               "date" => "Le ".$obj->getDate()->format('d M Y à H:i'),
               "comment"=>$obj->getComment()
           ); 
        }
        $rate = $em->getRepository('FoodsquareCommonBundle:Rate')->findOneBy(array("thread"=>"restaurant".$request->get('id'),"rater"=>$user));


        return array(
              "restaurant"=>$restaurant,
              "comments"=>$comments_array,
              "is_rater"=>(is_object($rate)),
              "rate_user"=>(is_object($rate))?$rate->getRate():null
          );
    }
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Rechercher un restaurant",
     *  requirements={
     *  },
     * )
     */
    public function postRestaurantSearchAction(Request $request){

        $em   = $this->getDoctrine()->getManager();

        $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByToken($request->get('token'));

        if(!is_object($user)){
          throw $this->createNotFoundException("Accès Interdit Mr le hacker");
        }
        
        $restaurant =   $em->getRepository('FoodsquareCommonBundle:Restaurant')->searchRestaurant($request->get('name'));

        return $restaurant;
    }
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Poster la photo d'un restaurant",
     *  requirements={
     *  },
     * )
     */
    public function postRestaurantPhotoAction(Request $request){
        
        $em   = $this->getDoctrine()->getManager();

        $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByToken($request->get('token'));

        if(!is_object($user)){
          throw $this->createNotFoundException("Accès Interdit Mr le hacker");
        }
        
        $restaurant =   $em->getRepository('FoodsquareCommonBundle:Restaurant')->findOneById($request->get('restaurant'));

        if(!is_object($restaurant)){
          throw $this->createNotFoundException("Restaurant Non disponible");
        }
        
        $photo = new Photo();
        $url = Photo::downloadImage($request->get('photo'), true, true);
        $photo->setUrl($url)
              ->setMiniature("thumbs/thumbs-".$url)
              ->setTitre($restaurant->getNom())
              ->setOwner($user);
        $restaurant->addGallerie($photo);
        
        // On enregistre l'ensemble dans la database
        $em->persist($restaurant);
        $em->flush();
        
        return $restaurant;
    }
    


    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Recupération des restaurants à proximité",
     *  requirements={
     *  },
     * )
     */
    public function postRestaurantNearbyAction(Request $request){

        $em   = $this->getDoctrine()->getManager();

        $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByToken($request->get('token'));

        if(!is_object($user)){
          throw $this->createNotFoundException("Accès Interdit Mr le hacker");
        }
        
        $restaurant =   $em->getRepository('FoodsquareCommonBundle:Restaurant')->getNearbyRestaurant($request->get('latitude'),$request->get('longitude'),3);
        
        return $restaurant;
    }
    
    
    
    

}
