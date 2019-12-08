<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/oneCar/OneCarModel.php';

class OneCarController{

    private $oneCarModel;


    public function __construct()
    {
        $this->oneCarModel = new OneCarModel();
    }

    
    //A partir du routeur , getOneCar() appelera notre function OneCar()
    public function getOneCar(){

        //appel de la fontion du model
        $oneCar = $this->oneCarModel->OneCar($_GET['id']);

        //appel de la vue
        require_once 'www/templates/oneCar/OneCarView.phtml';
    }
}