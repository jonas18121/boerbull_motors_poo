<?php
require_once 'model/oneCar/OneCarModel.php';

class OneCarController{

    /** @var OneCarModel */
    private OneCarModel $oneCarModel;

    public function __construct()
    {
        $this->oneCarModel = new OneCarModel();
    }

    /** Afficher une voiture */
    public function getOneCar() : void
    {
        $oneCar = $this->oneCarModel->OneCar($_GET['id']);
        require_once 'www/templates/oneCar/OneCarView.phtml';
    }
}