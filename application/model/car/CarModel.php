<?php

declare(strict_types=1);

require_once 'model/Model.php';
require_once 'library/Tools.php';
require_once 'Entity/Car.php';

class CarModel extends Model{

    /** selectionne une voiture 
     * 
     * @param int $one
     * @return array $oneCar
    */
    public function OneCar(int $one) : array
    {
        $sql = "SELECT * FROM car WHERE id = :id";

        $oneCar = $this->pdo->prepare($sql);
        $oneCar->execute(array('id' => $one));

        $oneCar = $oneCar->fetchAll();
    
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

        $cars_by_category = $this->pdo->prepare($sql);
        $cars_by_category->execute(array('id_category' => $id_category));
        $cars_by_category->setFetchMode(PDO::FETCH_CLASS, Car::class);
        $cars_by_category = $cars_by_category->fetchAll();

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