<?php
require_once 'model/tarif/TarifModel.php';

class TarifController{

    /** @var TarifModel */
    private TarifModel $tarif;

    public function __construct()
    {
        $this->tarif = new TarifModel();
    }

    /** Afficher les tarifs */
    public function getTarif() : void
    {
        $tarifView = $this->tarif->getTarifs();
        require_once 'www/templates/tarif/TarifView.phtml';
    }
}