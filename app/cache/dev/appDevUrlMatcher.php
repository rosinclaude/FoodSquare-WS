<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
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

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

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
