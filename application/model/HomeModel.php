<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';



class HomeModel extends Model{

    
    /** selectionner toute les voitures et afficher 5 maximum , 1 voiture pour chaque category qui existe
    * 
    * @return array $home
    */
    public function findHome() : array {

        $sql = "SELECT * FROM car INNER JOIN category ON category.id = car.id_category WHERE id_category LIMIT 5";

        $home = $this->pdo->query($sql);
        $home = $home->fetchAll();

        return  $home;
    }
}

