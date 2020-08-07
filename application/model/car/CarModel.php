<?php

declare(strict_types=1);

require_once 'model/Model.php';
require_once 'library/Tools.php';

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
     * @param int $category
     * @return array $categories
    */
    public function findCategory(int $category) : array 
    {
        $sql = "SELECT car.id, image_url, modele, marque, name FROM car INNER JOIN category ON category.id = car.id_category WHERE category.id = :id_category";

        $categories = $this->pdo->prepare($sql);
        $categories->execute(array('id_category' => $category));

        $categories = $categories->fetchAll();

        if(empty($categories)){
            redirect("index.php");
        }
        return $categories;
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