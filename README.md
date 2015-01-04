FoodSquare Webservice
========================

Web service utilisé pour l'application foodsquare : Application de notation et 
de recommandation de restaurants.

Web service basé sur Symphony2 (pattern MVC)
1) Documentation
-----------------

CommonBundle : Bundle contenant tous les éléments nécessaire au fonctionnement 
de l'application. (Controller, Entity, ...)

RateCommentController :  Classe permettant de noter et de commenter les 
restaurants

RestaurantController : Gère la récupération, la recherche et l'ajout de photos
pour des restaurants

UserController : Gère toutes fonctionnalités ayant traits aux utilisateurs 
(création, mise à jour, etc ...)