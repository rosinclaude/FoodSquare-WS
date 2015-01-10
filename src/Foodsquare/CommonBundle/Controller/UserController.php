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
     *  description="Récuperer le profil user par son identifiant",
     *  requirements={
     *     },
     * )
     */
    public function postUserProfilAction(Request $request){

      $em   = $this->getDoctrine()->getManager();

      $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneByToken($request->get('token'));

      if(!is_object($user)){
        throw $this->createNotFoundException("Attention Mr le hacker");
      }
      
      $rates =   $em->getRepository('FoodsquareCommonBundle:Rate')->findByRater($user);
      
      $comments =   $em->getRepository('FoodsquareCommonBundle:Comment')->findByCommenter($user);
      
      
      
      
      return array(
            "user"=>$user,
            "rates"=>  count($rates),
            "comments"=>count($comments),
            "last_connection"=>$user->getLastConnection()->format('d M Y à H:i')
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

                return array("me"=>$entity,"token"=>$entity->getToken());
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
                
                // On recupere les comments et notes
                $rates =   $em->getRepository('FoodsquareCommonBundle:Rate')->findByRater($user);
                $comments =   $em->getRepository('FoodsquareCommonBundle:Comment')->findByCommenter($user);

                // On renvoi l'objet User
                return array(
                      "user"=>array(
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
                            ),
                      "rates"=>  count($rates),
                      "comments"=>count($comments),
                      "last_connection"=>$user->getLastConnection()->format('d M Y à H:i')
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
        $user = $em->getRepository('FoodsquareCommonBundle:Users')->findOneById($id);
        

        
        if(!is_object($user) || $user->getToken()!==$request->get('token')){
            throw $this->createNotFoundException("Accès Interdit Mr le hacker");
        }else{
            $form = $this->createForm(new UsersType(), $user);
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

                $em->persist($user);
                $em->flush();

                // On recupere les comments et notes
                $rates =   $em->getRepository('FoodsquareCommonBundle:Rate')->findByRater($user);
                $comments =   $em->getRepository('FoodsquareCommonBundle:Comment')->findByCommenter($user);

                // On renvoi l'objet User
                return array(
                      "user"=>array(
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
                            ),
                      "rates"=>  count($rates),
                      "comments"=>count($comments),
                      "last_connection"=>$user->getLastConnection()->format('d M Y à H:i')
                  );
                
                
            }

            return array(
                'form' => $form,
            );
        }
    }
    
    
    public function generateToken() {
        $token = md5(uniqid(mt_rand(), true));
        return $token;
    }
}
