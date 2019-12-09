<?php
error_reporting(E_ALL);//renvois les erreurs
ini_set('display_errors', 1);

define('PATH_INDEX', '/projetFinalPOO/application/index.php');

require_once 'Routers.php';
$router = new Routers ();
$router->run();