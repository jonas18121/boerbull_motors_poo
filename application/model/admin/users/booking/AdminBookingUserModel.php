<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

//appel dans la librairie
include_once 'library/Tools.php';


class AdminBookingUsersModel extends Model{



    //en GET 
    /** Afficher un seul user 
     * 
     * @param int
     * 
     * @return array
    */
    public function GetUser($id){

        $sql = "SELECT * FROM user WHERE id = :id";

        $getUser = $this->pdo->prepare($sql);
        $getUser->execute([':id' => $id]);
        $getUser = $getUser->fetch();

        if(empty($getUser)){
            redirect("index.php");
        }

        return $getUser;
    }



    //en POST
    /** admin ajoute un RDV pour un user 
     * 
     * @param int/string/dateTime
     * 
     * @return void
    */
    public function adminAddBooking($user_id, $booking_date_debut, $booking_time_debut, $booking_date_fin, $booking_time_fin, $number_of_seats){

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