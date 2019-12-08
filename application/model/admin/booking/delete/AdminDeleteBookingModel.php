<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

class AdminDeleteBookingModel extends Model{

    /** supprimer un user 
     * 
     * @param int
     * 
     * @return void
    */
    public function deleteBookingAdmin($id){

        $sql = "DELETE FROM booking WHERE id = :id ";

        $deleteBooking = $this->pdo->prepare($sql);
        $deleteBooking->execute([':id' => $id]);
    }
}