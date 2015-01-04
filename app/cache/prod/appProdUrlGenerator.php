<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Psr\Log\LoggerInterface;

/**
 * appProdUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    private static $declaredRoutes = array(
        'api_get_user' => array (  0 =>   array (    0 => 'id',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::getUserAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'id',    ),    2 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_get_user_profil' => array (  0 =>   array (    0 => 'id',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::getUserProfilAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/profil',    ),    2 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'id',    ),    3 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_user_facebook' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::postUserFacebookAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/users/facebooks',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_user_inscription' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::postUserInscriptionAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/users/inscriptions',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_user_connexion' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::postUserConnexionAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/users/connexions',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_put_user' => array (  0 =>   array (    0 => 'id',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\UserController::putUserAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'PUT',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'id',    ),    2 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_comment' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RateCommentController::postCommentAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/comments',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_rate' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RateCommentController::postRateAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/rates',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_restaurant' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RestaurantController::postRestaurantAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/restaurants',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_restaurant_search' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RestaurantController::postRestaurantSearchAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/restaurants/searches',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_restaurant_photo' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RestaurantController::postRestaurantPhotoAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/restaurants/photos',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_post_restaurant_nearby' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Foodsquare\\CommonBundle\\Controller\\RestaurantController::postRestaurantNearbyAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/restaurants/nearbies',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'nelmio_api_doc_index' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Nelmio\\ApiDocBundle\\Controller\\ApiDocController::indexAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/doc/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
    );

    /**
     * Constructor.
     */
    public function __construct(RequestContext $context, LoggerInterface $logger = null)
    {
        $this->context = $context;
        $this->logger = $logger;
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if (!isset(self::$declaredRoutes[$name])) {
            throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
        }

        list($variables, $defaults, $requirements, $tokens, $hostTokens, $requiredSchemes) = self::$declaredRoutes[$name];

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);
    }
}
