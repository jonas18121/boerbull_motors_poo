<?php

declare(strict_types=1);

require_once 'library/Tools.php';
require_once 'model/Model.php';
require_once 'Entity/Car.php';


class HomeModel extends Model
{    
    /** selectionner toute les voitures et afficher 5 maximum , 1 voiture pour chaque category qui existe
    * 
    * @return array $home
    */
    public function findHome() : array 
    {
        $sql = "SELECT * 
            FROM car 
            INNER JOIN category ON category.id = car.id_category 
            WHERE id_category 
            LIMIT 5"
        ;

        $home = $this->pdo->query($sql);
        $home->setFetchMode(PDO::FETCH_CLASS, Car::class);
        $home = $home->fetchAll();
        //pre_var_dump($home, null, true);

        return  $home;
    }
}

