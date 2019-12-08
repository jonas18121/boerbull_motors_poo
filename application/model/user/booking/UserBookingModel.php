<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';


class UserBookingModel extends Model{


    /** afficher les RDV 
     * 
     * @param int
     * 
     * @return array
    */
    public function getBooking($user_i){

        $sql = "SELECT * FROM booking WHERE user_i = :user_i";

        $getBooking = $this->pdo->prepare($sql);
        $getBooking->execute(["user_i" => $user_i]);

        $getBooking = $getBooking->fetchAll();

        return $getBooking;
    }



    /** effacer un RDV 
     * 
     * @param int
     * 
     * @return void
    */
    public function deleteBooking($id){

        $sql = "DELETE FROM booking WHERE id = :id";

        $deleteOneBooking = $this->pdo->prepare($sql);
        $deleteOneBooking->execute(array(
            ':id' => $id
        ));
    }
}