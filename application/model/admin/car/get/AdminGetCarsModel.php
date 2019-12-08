<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';


class AdminGetCarsModel extends Model{

    /** Afficher tous les cars 
     * 
     * @return array
    */
    public function GetCars(){

        $sql = "SELECT * FROM car";
        $adminGetCars = $this->pdo->query($sql);
        $adminGetCars = $adminGetCars->fetchAll();

        return $adminGetCars;
    }
}