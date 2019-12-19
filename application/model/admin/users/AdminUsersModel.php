<?php
require_once 'model/admin/AdminModel.php';
include_once 'library/Tools.php';

class AdminUsersModel extends AdminModel{


            //// Afficher ////    
    /** Afficher tous les users 
     * 
     * @return array $adminGetUsers
    */
    public function GetUsers() : array
    {
        $sql = "SELECT * FROM user";
        $adminGetUsers = $this->pdo->query($sql);
        $adminGetUsers = $adminGetUsers->fetchAll();

        return $adminGetUsers;
    }

            //// Ajouter ////    
    /** admin ajoute un user 
     * 
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     * 
     * @return void
    */
    public function addUsers(string $first_name, string $last_name, string $email, string $password) : void 
    {
        if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
            
            $sql = "SELECT * From user WHERE mail = :mail ";
            $userExist = $this->pdo->prepare($sql); 
            $userExist->execute([':mail' => $email]);
            $userExist = $userExist->fetchAll();

            if($userExist){
                throw new PDOException(("Un utilisateur existe déjà avec cet email."));
            }

            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (first_name, last_name, mail, password) VALUE(:first_name, :last_name, :mail, :password)";

            $user = $this->pdo->prepare($sql);
            $user = $user->execute([

                ':first_name' => $first_name, 
                ':last_name' => $last_name, 
                ':mail' => $email, 
                ':password' => $passwordHashed
            ]);
        }
    }

                //// Modifier ////    
    //en $_GET
    /** admin affiche le user a modifier 
     * 
     * @param int $id
     * @return array $editFormUsers
    */
    public function editFormUsers(int $id) : array 
    {
        $sql = "SELECT * FROM user WHERE id = :id";

        $editFormUsers = $this->pdo->prepare($sql);
        $editFormUsers->execute([':id' => $id]);
        $editFormUsers = $editFormUsers->fetchAll();

        if(empty($editFormUsers)){
            redirect("index.php");
        }
    
        return $editFormUsers;
    }

    //en $_POST
    /** admin insert le contenu modifier du user 
     * 
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     * @param int $id
     * 
     * @return void
    */
    public function editUsers(string $first_name, string $last_name, string $email, string $password, int $id) : void 
    {
        $sql = "UPDATE user SET first_name = :first_name, last_name = :last_name, mail = :mail, password = :password WHERE id = :id";

        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        $editUsers = $this->pdo->prepare($sql);
        $editUsers = $editUsers->execute([

            ':id' => $id,
            ':first_name' => $first_name, 
            ':last_name' => $last_name, 
            ':mail' => $email,
            ':password' => $passwordHashed
        ]);
    }

                //// Supprimer ////    
    /** supprimer un user 
     * 
     * @param int $id
     * @return void
    */
    public function deleteUser(int $id) : void 
    {
        $sql = "DELETE FROM user WHERE id = :id ";
        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }

                //// afficher pour ajouter un RDV pour un user ////      
    //en GET 
    /** Afficher un seul user 
     * 
     * @param int $id
     * @return array
    */
    public function GetUser(int $id) : array 
    {
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
     * @param int $user_id
     * @param string $booking_date_debut
     * @param string $booking_time_debut
     * @param string $booking_date_fin
     * @param string $booking_time_fin
     * @param int $number_of_seats
     * @return void
    */
    public function adminAddBooking(int $user_id, string $booking_date_debut, string $booking_time_debut, string $booking_date_fin, string $booking_time_fin, int $number_of_seats) : void
    {
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

    /** Afficher tous les rendez-vous
     * 
     * @return array $adminGetBooking    
    */
    public function findBooking() : array 
    {
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
     * @return void
    */
    public function deleteBookingAdmin(int $id) : void 
    {
        $sql = "DELETE FROM booking WHERE id = :id ";

        $deleteBooking = $this->pdo->prepare($sql);
        $deleteBooking->execute([':id' => $id]);
    }
}