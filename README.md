
<img src="https://s-media-cache-ak0.pinimg.com/originals/c2/e1/54/c2e154c9bad81674be411bc67d3bf081.jpg" alt="Logo Foodsquare" width="300px"/><img src="http://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2014/12/1418948033symfony-logo.png" alt="Logo Foodsquare" width="100px"/>
FoodSquare Webservice
========================

Web service utilisé pour l'application foodsquare : Application de notation et 
de recommandation de restaurants.

Web service basé sur le framework PHP [Symphony2](http://symfony.com/)

## Présentation

* [Google Présentation](https://docs.google.com/presentation/d/12rFdgN0MJj2qub8wANnTufOxT141CV3ejXnqRMVhoJg/edit?usp=sharing)

## License

* [Apache Version 2.0](http://www.apache.org/licenses/LICENSE-2.0.html)


## Documentation

CommonBundle : Bundle contenant tous les éléments nécessaire au fonctionnement 
de l'application. (Controller, Entity, ...)

RateCommentController :  Controller permettant de noter et de commenter les 
restaurants

RestaurantController : Controller gérant la récupération, la recherche et l'ajout de photos
pour des restaurants

UserController : Controller gérant toutes fonctionnalités ayant traits aux utilisateurs 
(création, mise à jour, etc ...)

Plus d'infos : Consultés la Doc de l'API [https://foodsquare.herokuapp.com/api/doc/](https://foodsquare.herokuapp.com/api/doc/)

## Bundles Utilisés

* FosRestBundle [https://github.com/FriendsOfSymfony/FOSRest](https://github.com/FriendsOfSymfony/FOSRest)
* JMS Serializer [https://github.com/schmittjoh/JMSSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle)
* Nelmio API Doc [https://github.com/nelmio/NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle)
* Amazone WebServices [https://github.com/aws/aws-sdk-php](https://github.com/aws/aws-sdk-php)

