<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/users')) {
                // api_get_user
                if (preg_match('#^/api/users/(?P<id>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_get_user;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_get_user')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::getUserAction',  '_format' => 'json',));
                }
                not_api_get_user:

                // api_get_user_profil
                if (preg_match('#^/api/users/(?P<id>[^/]++)/profil(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_get_user_profil;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_get_user_profil')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::getUserProfilAction',  '_format' => 'json',));
                }
                not_api_get_user_profil:

                // api_post_user_facebook
                if (0 === strpos($pathinfo, '/api/users/facebooks') && preg_match('#^/api/users/facebooks(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_user_facebook;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_user_facebook')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::postUserFacebookAction',  '_format' => 'json',));
                }
                not_api_post_user_facebook:

                // api_post_user_inscription
                if (0 === strpos($pathinfo, '/api/users/inscriptions') && preg_match('#^/api/users/inscriptions(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_user_inscription;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_user_inscription')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::postUserInscriptionAction',  '_format' => 'json',));
                }
                not_api_post_user_inscription:

                // api_post_user_connexion
                if (0 === strpos($pathinfo, '/api/users/connexions') && preg_match('#^/api/users/connexions(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_user_connexion;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_user_connexion')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::postUserConnexionAction',  '_format' => 'json',));
                }
                not_api_post_user_connexion:

                // api_put_user
                if (preg_match('#^/api/users/(?P<id>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_api_put_user;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_put_user')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::putUserAction',  '_format' => 'json',));
                }
                not_api_put_user:

            }

            // api_post_comment
            if (0 === strpos($pathinfo, '/api/comments') && preg_match('#^/api/comments(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_api_post_comment;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_comment')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RateCommentController::postCommentAction',  '_format' => 'json',));
            }
            not_api_post_comment:

            if (0 === strpos($pathinfo, '/api/r')) {
                // api_post_rate
                if (0 === strpos($pathinfo, '/api/rates') && preg_match('#^/api/rates(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_rate;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_rate')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RateCommentController::postRateAction',  '_format' => 'json',));
                }
                not_api_post_rate:

                if (0 === strpos($pathinfo, '/api/restaurants')) {
                    // api_post_restaurant
                    if (preg_match('#^/api/restaurants(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_post_restaurant;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_restaurant')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RestaurantController::postRestaurantAction',  '_format' => 'json',));
                    }
                    not_api_post_restaurant:

                    // api_post_restaurant_search
                    if (0 === strpos($pathinfo, '/api/restaurants/searches') && preg_match('#^/api/restaurants/searches(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_post_restaurant_search;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_restaurant_search')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RestaurantController::postRestaurantSearchAction',  '_format' => 'json',));
                    }
                    not_api_post_restaurant_search:

                    // api_post_restaurant_photo
                    if (0 === strpos($pathinfo, '/api/restaurants/photos') && preg_match('#^/api/restaurants/photos(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_post_restaurant_photo;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_restaurant_photo')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RestaurantController::postRestaurantPhotoAction',  '_format' => 'json',));
                    }
                    not_api_post_restaurant_photo:

                    // api_post_restaurant_nearby
                    if (0 === strpos($pathinfo, '/api/restaurants/nearbies') && preg_match('#^/api/restaurants/nearbies(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_post_restaurant_nearby;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_post_restaurant_nearby')), array (  '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RestaurantController::postRestaurantNearbyAction',  '_format' => 'json',));
                    }
                    not_api_post_restaurant_nearby:

                }

            }

            // nelmio_api_doc_index
            if (rtrim($pathinfo, '/') === '/api/doc') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_nelmio_api_doc_index;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'nelmio_api_doc_index');
                }

                return array (  '_controller' => 'Nelmio\\ApiDocBundle\\Controller\\ApiDocController::indexAction',  '_route' => 'nelmio_api_doc_index',);
            }
            not_nelmio_api_doc_index:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
