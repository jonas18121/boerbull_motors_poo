<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/tarif/TarifModel.php';

class TarifController{

    private $tarif;

    public function __construct()
    {
        $this->tarif = new TarifModel();
    }

    //A partir du routeur , getTarif() appelera notre function getTarifs()
    public function getTarif(){

        $tarifView = $this->tarif->getTarifs();

        require_once 'www/templates/tarif/TarifView.phtml';
    }
}