<?php

namespace Foodsquare\CommonBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\RedirectView;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Foodsquare\CommonBundle\Entity\Comment;
use Foodsquare\CommonBundle\Form\CommentType;
use Foodsquare\CommonBundle\Entity\Rate;
use Foodsquare\CommonBundle\Form\RateType;



use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class RateCommentController extends \FOS\RestBundle\Controller\FOSRestController
{
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Commenter un restaurant",
     *  input="Foodsquare\CommonBundle\Form\CommentType",
     *  output="Foodsquare\CommonBundle\Entity\Comment",
     * )
     */
    public function postCommentAction(Request $request)
    {
        $entity = new Comment();
        $em   = $this->getDoctrine()->getManager();
        
        $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneById($request->get('commenter'));

        if(!is_object($user) || $user->getToken()!==$request->get('token')){
          throw $this->createAccessDeniedException("Accès Interdit Mr le hacker");
        }else{
            $form = $this->createForm(new CommentType(), $entity, array("em"=>$em));
            $form->bind(array(
                    "comment" => $request->get('comment'),
                    "thread" => $request->get('thread'),
                    "commenter" => $request->get('commenter')
                ));

            if ($form->isValid()) {

                $em->persist($entity);
                $em->flush();

                return $entity;
            }
            return array(
                'form' => $form,
            );
        }
    }
    
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Noter un restaurant",
     *  input="Foodsquare\CommonBundle\Form\RateType",
     *  output="Foodsquare\CommonBundle\Entity\Rate",
     * )
     */
    public function postRateAction(Request $request)
    {
        $entity = new Rate();
        $em   = $this->getDoctrine()->getManager();
        
        $rate =   $em->getRepository('FoodsquareCommonBundle:Rate')->findOneBy(array("thread"=>$request->get('thread'),"rater"=>$request->get('rater')));

        if(is_object($rate)){
            throw $this->createAccessDeniedException("Vous avez déja noté ce restaurant");
        }else{
            $user =   $em->getRepository('FoodsquareCommonBundle:Users')->findOneById($request->get('rater'));

            if(!is_object($user) || $user->getToken()!==$request->get('token')){
              throw $this->createNotFoundException("Accès Interdit Mr le hacker");
            }else{

                $form = $this->createForm(new RateType(), $entity, array("em"=>$em));
                $form->bind(array(
                        "rate" => $request->get('rate'),
                        "thread" => $request->get('thread'),
                        "rater" => $request->get('rater')
                    ));

                if ($form->isValid()) {

                    $em->persist($entity);
                    $em->flush();

                    return $entity;
                }
                return array(
                    'form' => $form,
                );
            } 
        }   
    }
    
    
    

}
