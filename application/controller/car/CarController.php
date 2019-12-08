<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/car/CarModel.php';

class CarController{

    private $carModel;

    public function __construct()
    {
        $this->carModel = new CarModel();
    }

    //afficher une voiture
    //A partir du routeur , getOneCar() appelera notre function OneCar()
    public function getOneCar(){

        //appel de la fontion du model
        $oneCar = $this->carModel->OneCar($_GET['id']);

        //appel de la vue
        require_once 'www/templates/oneCar/OneCarView.phtml';
    }



    // selectionner des voitures par categorie 
    //A partir du routeur , getOneCategory() appelera notre function findCategory
    public function getOneCategory(){

        //appel de la fontion du model
        $categories = $this->carModel->findCategory($_GET['id_category']);

        //appel de la vue
        require_once 'www/templates/category/CategoryView.phtml';
    }
}
