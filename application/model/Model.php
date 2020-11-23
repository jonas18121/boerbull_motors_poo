<?php
require_once 'config/DataBase.php';

abstract class Model{

    protected $pdo;

    public function __construct()
    {
        $db = new Database;
        $this->pdo = $db->dbConnect(); 
    }
}