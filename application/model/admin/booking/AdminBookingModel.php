<?php

//inclure la classe Model
require_once 'model/admin/AdminModel.php';

class AdminBookingModel extends AdminModel{

    /** Afficher tous les rendez-vous
     * 
     * @return array $adminGetBooking    
    */
    public function findBooking() : array {

        $sql = "SELECT booking.id, booking_date_debut, booking_time_debut, booking_date_fin, booking_time_fin, number_of_seats, user_i, last_name, first_name, mail 
            FROM booking 
            INNER JOIN user ON user.id = booking.user_i ";
        $adminGetBooking = $this->pdo->query($sql);
        $adminGetBooking = $adminGetBooking->fetchAll();

        return $adminGetBooking;
    }


    /** supprimer un rendez-vous
     * 
     * @param int $id
     * 
     * @return void
    */
    public function deleteBookingAdmin(int $id) : void {

        $sql = "DELETE FROM booking WHERE id = :id ";

        $deleteBooking = $this->pdo->prepare($sql);
        $deleteBooking->execute([':id' => $id]);
    }




                    //// ajouter un RDV pour un user ////      
    //en POST
    /** admin ajoute un RDV pour un user 
     * 
     * @param int $user_id
     * @param string $booking_date_debut
     * @param string $booking_time_debut
     * @param string $booking_date_fin
     * @param string $booking_time_fin
     * @param int $number_of_seats
     * 
     * @return void
    */
    public function adminAddBooking(int $user_id, string $booking_date_debut, string $booking_time_debut, string $booking_date_fin, string $booking_time_fin, int $number_of_seats) : void {

        $sql = "INSERT INTO booking (user_i, booking_date_debut, booking_time_debut, booking_date_fin, booking_time_fin, number_of_seats, created_at ) 
            VALUES(:user_i, :booking_date_debut, :booking_time_debut, :booking_date_fin, :booking_time_fin, :number_of_seats, NOW())";

        $adminAddBooking = $this->pdo->prepare($sql);
        $adminAddBooking->execute([
            ':user_i' => $user_id, 
            ':booking_date_debut' => $booking_date_debut, 
            ':booking_time_debut' => $booking_time_debut,
            ':booking_date_fin' => $booking_date_fin, 
            ':booking_time_fin' => $booking_time_fin,
            ':number_of_seats' => $number_of_seats
        ]);
    }
}