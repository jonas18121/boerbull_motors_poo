<?php
require_once 'model/Model.php';

class TarifModel extends Model{

    /** afficher les tarifs
     * 
     * @return array $tarifView
     */
    public function getTarifs() : array 
    {

        $sql = "SELECT marque, modele, prix_trois_jours, puissance, name FROM car INNER JOIN category ON category.id = car.id_category";

        $tarifView = $this->pdo->query($sql);
        $tarifView = $tarifView->fetchAll();

        return $tarifView;
    }
}