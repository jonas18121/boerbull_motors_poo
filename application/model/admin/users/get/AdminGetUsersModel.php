<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

class AdminGetUsersModel extends Model{


    /** Afficher tous les users 
     * 
     * @return array
    */
    public function GetUsers(){

        $sql = "SELECT * FROM user";
        $adminGetUsers = $this->pdo->query($sql);
        $adminGetUsers = $adminGetUsers->fetchAll();

        return $adminGetUsers;
    }
}