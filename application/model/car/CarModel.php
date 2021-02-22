<?php

declare(strict_types=1);

require_once 'model/Model.php';
require_once 'library/Tools.php';
require_once 'Entity/Car.php';

class CarModel extends Model{

    /** selectionne une voiture 
     * 
     * @param int $one
     * @return Car $oneCar
    */
    public function OneCar(int $one) : Car
    {
        $sql = "SELECT * FROM car WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id' => $one));
        $stmt->setFetchMode(PDO::FETCH_CLASS, Car::class);
        $oneCar = $stmt->fetch();
    
        if(empty($oneCar)){
            redirect("index.php");
        }
        return $oneCar;
    }

    /** selectionne une voiture pour l'afficher à la reservation
     * 
     * @param array $session
     * @return array $oneCar
    */
    public function OneCarBooking(array $session) : array 
    {
        $sql = 'SELECT * FROM car WHERE id IN ('.implode(',',$session).')';

        $oneCar = $this->pdo->prepare($sql);
        $oneCar->execute(array('id' => implode(',' , $session)));

        $oneCar = $oneCar->fetchAll();

        if(empty($oneCar)){
            redirect("index.php");
        }

        return $oneCar;
    }

    /** selectionner des voitures par categorie 
     * 
     * @param int $id_category - récupère l'id de la catégorie qui a été selectionner
     * @return array $cars_by_category - retourne un tableau (de l'object car ) de toute les voitures qui sont dans une catégorie précise 
    */
    public function findCarByCategory(int $id_category) : array 
    {
        $sql = "SELECT car.id, car.image_url, car.modele, car.marque, category.name 
            FROM car 
            INNER JOIN category ON category.id = car.id_category 
            WHERE category.id = :id_category"
        ;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id_category' => $id_category));
        $stmt->setFetchMode(PDO::FETCH_CLASS, Car::class);
        $cars_by_category = $stmt->fetchAll();

        if(empty($cars_by_category)){
            redirect("index.php");
        }
        return $cars_by_category;
    } 

    /** selectionner toutes les voitures 
     *
    * @return array $categories
    */ 
    public function findAllo() : array
    { 
        $sql = "SELECT * FROM car ";
        $categories = $this->pdo->query($sql);
        $categories = $categories->fetchAll();
        return  $categories;
    }
}