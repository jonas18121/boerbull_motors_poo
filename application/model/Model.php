<?php
//inclure la bdd
require_once 'config/DataBase.php';

abstract class Model{

    protected $pdo;

    public function __construct(){
        //connexion à la bdd
        $db = new Database;
        $this->pdo = $db->dbConnect(); 
    }
}