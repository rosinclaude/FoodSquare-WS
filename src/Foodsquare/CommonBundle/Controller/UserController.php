<?php

namespace Foodsquare\CommonBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\RedirectView;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

use Foodsquare\CommonBundle\Entity\Users;
use Foodsquare\CommonBundle\Form\UsersInscriptionFBType;
use Foodsquare\CommonBundle\Form\UsersInscriptionType;
use Foodsquare\CommonBundle\Form\UsersType;
use Foodsquare\CommonBundle\Form\VoitureType;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UserController extends \FOS\RestBundle\Controller\FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Récuperer un user par son identifiant",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Identifiant de l'utilisateur"
     *      }
     *  },
     * )
     */
    public function getUserAction($id){

      $em   = $this->getDoctrine()->getManager();

      $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneById($id);

      if(!is_object($user)){
        throw $this->createNotFoundException();
      }
      
      

      return array("me"=>$user,"token"=>$user->getToken());
    }
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Récuperer le profil user par son identifiant",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Identifiant de l'utilisateur"
     *      }
     *  },
     * )
     */
    public function getUserProfilAction($id){

      $em   = $this->getDoctrine()->getManager();

      $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneById($id);

      if(!is_object($user)){
        throw $this->createNotFoundException();
      }
      
      $rates =   $em->getRepository('FoodsquareCommonBundle:Rate')->findByRater($user);
      $rates_array = array();
      foreach ($rates as $obj){
         $rates_array[] = array(
             "id"=>$obj->getId(),
             "thread" => $obj->getThread(),
             "rate"=>$obj->getRate()
         ); 
      }
      
      $comments =   $em->getRepository('FoodsquareCommonBundle:Comment')->findByCommenter($user);
      $comments_array = array();
      foreach ($comments as $obj){
         $comments_array[] = array(
             "id"=>$obj->getId(),
             "thread" => $obj->getThread(),
             "comment"=>$obj->getComment()
         ); 
      }
      
      
      
      return array(
            "user"=>$user,
            "rates"=>$rates_array,
            "comments"=>$comments_array
        );
    }
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Inscription d'un utilisateur par facebook",
     *  input="Foodsquare\CommonBundle\Form\UsersInscriptionFBType",
     *  output="Foodsquare\CommonBundle\Entity\Users",
     * )
     */
    public function postUserFacebookAction(Request $request)
    {
        $entity = new Users();

        $token = $this->generateToken();
        $entity->setToken($token);

        $form = $this->createForm(new UsersInscriptionFBType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByFacebookId($entity->getFacebookId());

            if(is_object($user)){
                return $user;
            }else{

                $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByEmail($entity->getEmail());

                if(is_object($user)){
                   return $user; 
                }else{
                    $em->persist($entity);
                    $em->flush();

                    return $this->redirectView(
                        $this->generateUrl(
                            'api_get_user',
                            array('id' => $entity->getId())
                            ),
                        Codes::HTTP_FOUND
                        );
                }
            }
        }
        return array(
            'form' => $form,
        );
    }
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Inscription d'un utilisateur",
     *  input="Foodsquare\CommonBundle\Form\UsersInscriptionType",
     *  output="Foodsquare\CommonBundle\Entity\Users",
     * )
     */
    public function postUserInscriptionAction(Request $request)
    {
        $entity = new Users();

        $token = $this->generateToken();
        $entity->setToken($token);

        $form = $this->createForm(new UsersInscriptionType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByEmail($entity->getEmail());

            if(is_object($user)){
                throw $this->createNotFoundException("Ce mail est déjà utilisé!");
            }else{
                
                $entity->setSalt(md5(time()));
                $encoder = new MessageDigestPasswordEncoder('sha1');
                $password = $encoder->encodePassword($form->get('password')->getData(), $entity->getSalt());
                
                $entity->setPassword($password);
                
                $em->persist($entity);
                $em->flush();

                return $this->redirectView(
                    $this->generateUrl(
                        'api_get_user',
                        array('id' => $entity->getId())
                        ),
                    Codes::HTTP_FOUND
                    );
            }
        }
        return array(
            'form' => $form,
        );
    }
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Connexion d'un utilisateur",
     *  input="Foodsquare\CommonBundle\Form\UsersInscriptionType",
     *  output="Foodsquare\CommonBundle\Entity\Users",
     * )
     */
    public function postUserConnexionAction(Request $request)
    {
        $entity = new Users();

        

        $form = $this->createForm(new UsersInscriptionType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByEmail($entity->getEmail());

            $encoder = new MessageDigestPasswordEncoder('sha1');
            $password = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());
                
            if(is_object($user) && $password==$user->getPassword()){
                
                // On genere le token
                $token = $this->generateToken();
                $user->setToken($token);
                // On enregistre le token
                $em->persist($user);
                $em->flush();
                // On renvoi l'objet User
                return  array(
                    "id"=> $user->getId(),
                    "nom"=> $user->getNom(),
                    "prenom"=> $user->getPrenom(),
                    "email"=> $user->getEmail(),
                    "facebookId"=> $user->getFacebookId(),
                    "role"=> $user->getRole(),
                    "locked"=> $user->getLocked(),
                    "date_inscription"=> $user->getDateInscription(),
                    "photo"=> $user->getPhoto(),
                    "token"=>$user->getToken()
                );
            }else{
                throw $this->createNotFoundException("Désolé la tentative de connexion a échoué");
            }
        }
        return array(
            'form' => $form,
        );
    }
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Mise a jour d'un utilisateur",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Identifiant de l'utilisateur"
     *      }
     *  },
     *  input="Foodsquare\CommonBundle\Form\UsersType",
     *  output="Foodsquare\CommonBundle\Entity\Users",
     * )
     */
    public function putUserAction(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FoodsquareCommonBundle:Users')->findOneById($id);
        

        
        if(!is_object($entity) || $entity->getToken()!==$request->get('token')){
            throw $this->createNotFoundException("Accès Interdit Mr le hacker");
        }else{
            $form = $this->createForm(new UsersType(), $entity);
            //$form->bind($request);
            $form->bind(array(
                "nom" => $request->get('nom'),
                "prenom" => $request->get('prenom'),
                "email" => $request->get('email'),
                "photo" => $request->get('photo'),
                "facebookId" => $request->get('facebookId'),
                "pin" => $request->get('pin'))
            );
            

            if ($form->isValid()) {

                $em->persist($entity);
                $em->flush();

                return  array(
                    "id"=> $entity->getId(),
                    "nom"=> $entity->getNom(),
                    "prenom"=> $entity->getPrenom(),
                    "email"=> $entity->getEmail(),
                    "facebookId"=> $entity->getFacebookId(),
                    "role"=> $entity->getRole(),
                    "locked"=> $entity->getLocked(),
                    "date_inscription"=> $entity->getDateInscription(),
                    "photo"=> $entity->getPhoto(),
                    "token"=>$entity->getToken()
                );
            }

            return array(
                'form' => $form,
            );
        }
    }
    
    
    public function generateToken() {
//        $csrf = $this->get('form.csrf_provider'); 
//        $token = $csrf->generateCsrfToken('unknow');
        $token = md5(uniqid(mt_rand(), true));
        return $token;
    }
}
