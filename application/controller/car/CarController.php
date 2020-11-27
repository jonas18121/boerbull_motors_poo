<?php
declare(strict_types=1);

require_once 'model/car/CarModel.php';

class CarController{

    /** @var CarModel */
    private CarModel $car_model;

    public function __construct()
    {
        $this->car_model = new CarModel();
    }

    /** 
     * afficher une voiture 
     * 
     * @return void
     */
    public function getOneCar() : void
    {
        $oneCar = $this->car_model->OneCar((int) $_GET['id']);
        require_once 'www/templates/oneCar/OneCarView.phtml';
    }

    /** 
     * selectionner des voitures par categorie
     * 
     * @return void  
     */ 
    public function getOneCategory() : void
    {
        $cars_by_category = $this->car_model->findCarByCategory((int) $_GET['id_category']);
        require_once 'www/templates/category/CategoryView.phtml';
    }
}
