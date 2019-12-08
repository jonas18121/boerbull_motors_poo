<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

class AdminGetBookingModel extends Model{


    /** Afficher tous les rendez-vous
     * 
     * @return array    
    */
    public function findBooking(){

        $sql = "SELECT booking.id, booking_date_debut, booking_time_debut, booking_date_fin, booking_time_fin, number_of_seats, user_i, last_name, first_name, mail 
            FROM booking 
            INNER JOIN user ON user.id = booking.user_i ";
        $adminGetBooking = $this->pdo->query($sql);
        $adminGetBooking = $adminGetBooking->fetchAll();

        return $adminGetBooking;
    }
}