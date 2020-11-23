<?php

declare(strict_types=1);

require_once 'library/Tools.php';
require_once 'model/Model.php';
require_once 'Entity/Car.php';


class HomeModel extends Model
{    
    /** 
    * selectionner toute les voitures et afficher 1 voiture pour chaque category qui existe
    * 
    * @return array $home - retourne un tableau qui contient des objects Car de la classe Car 
    */
    public function findHome() : array 
    {
        $sql = "SELECT car.modele, car.id_category, car.image_url, category.id, category.name
            FROM car 
            INNER JOIN category ON category.id = car.id_category 
            WHERE id_category 
            GROUP BY category.id "
        ;

        $home = $this->pdo->prepare($sql);
        $home->setFetchMode(PDO::FETCH_CLASS, Car::class);
        $home->execute();
        $home = $home->fetchAll();
        
        return  $home;
    }
}

