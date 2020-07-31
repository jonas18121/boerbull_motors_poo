<?php
declare(strict_types=1);

require_once 'model/car/CarModel.php';

class CarController{

    /** @var CarModel */
    private CarModel $carModel;

    public function __construct()
    {
        $this->carModel = new CarModel();
    }

    /** 
     * afficher une voiture 
     * 
     * @return void
     */
    public function getOneCar() : void
    {
        $oneCar = $this->carModel->OneCar((int) $_GET['id']);
        require_once 'www/templates/oneCar/OneCarView.phtml';
    }

    /** 
     * selectionner des voitures par categorie
     * 
     * @return void  
     */ 
    public function getOneCategory() : void
    {
        $categories = $this->carModel->findCategory((int) $_GET['id_category']);
        require_once 'www/templates/category/CategoryView.phtml';
    }
}
