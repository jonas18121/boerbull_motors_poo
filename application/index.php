<?php
//renvois les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('PATH_INDEX', '/projetFinalPOO/application/index.php');
/* 

faire le rewrite url

faire une classe apropos

apporter les hinting de php7

faire le panier en javascript
faire un slider en js


 * appliquer la bonne pratice S.O.L.I.D
 * 
 * faudra faire une copie du projet pour mettre le panier en js dedans
*/



require_once 'Router.php';
$router = new Router();
$router->run();
//$router->starter();