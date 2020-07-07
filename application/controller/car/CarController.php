<?php
require_once 'model/car/CarModel.php';

class CarController{

    /** @var CarModel */
    private CarModel $carModel;

    public function __construct()
    {
        $this->carModel = new CarModel();
    }

    /** afficher une voiture */
    public function getOneCar() : void
    {
        $oneCar = $this->carModel->OneCar($_GET['id']);
        require_once 'www/templates/oneCar/OneCarView.phtml';
    }

    /** selectionner des voitures par categorie  */ 
    public function getOneCategory() : void
    {
        $categories = $this->carModel->findCategory($_GET['id_category']);
        require_once 'www/templates/category/CategoryView.phtml';
    }
}
