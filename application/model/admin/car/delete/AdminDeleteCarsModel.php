<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

class AdminDeleteCarsModel extends Model{


    /** supprimer un car 
     * 
     * @param int
     * 
     * @return void
    */
    public function deleteCar($id){

        $sql = "DELETE FROM car WHERE id = :id ";

        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }
}