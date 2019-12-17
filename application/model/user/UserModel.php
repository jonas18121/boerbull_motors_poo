<?php

require_once 'model/Model.php';

class UserModel extends Model{



    /** register  /INSCRIPTION 
    * 
    * @param string $first_name
    * @param string $last_name
    * @param string $email
    * @param string $password
    *
    * @return void
    */
    public function registerUser(string $first_name, string $last_name, string $email, string $password) : void{
      

        /* on teste si le mail existe et est valide , s'il est différent de false , on continue.*/
        if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
        
            $sql = "SELECT * From user WHERE mail = :mail ";

            $userExist = $this->pdo->prepare($sql);
            $userExist->execute([
                ':mail' => $email
            ]);
            $userExist = $userExist->fetchAll();
        
            /* si ce mail existe déjà dans la bdd lors de l'inscription , on lance une erreur  */
            if($userExist){
                throw new PDOException(("Un utilisateur existe déjà avec cet email."));
            }


            /* si le mail n'existe pas dans la bdd lors de l'inscription, c'est bon , on peut hashé le mot de passe */
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);


            // et on peut ajouter le nouvelle utilisateur dans la base de donnée
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





    /** login  /CONNEXION 
    * 
    * @param string $email
    * @param string $password
    * 
    * @return array $userExist
    */
    public function loginUser(string $email, string $password) : array {

        $sql = "SELECT * From user WHERE mail = :mail ";

        $userExist = $this->pdo->prepare($sql);
        $userExist->execute([':mail' => $email]);
        $userExist = $userExist->fetch();

        if(!$userExist){
            throw new PDOException(('User inconnu - cet email n\' existe pas'));
        }

        //on teste si le mot de passe correspond a celui qui est dans la bdd
        if(!password_verify($password, $userExist['password'])){
            throw new PDOException('Le mot de passe est incorrect');
        } 

        return $userExist;
    }            




    /** on récupère tous les users 
    * 
    *  @return array $userAll
    */
    public function userAll() : array {
        $sql = 'SELECT * FROM user';
        $userAll = $this->pdo->query($sql);
        $userAll = $userAll->fetchAll();

        return $userAll;
    }



    /** user supprime son compte 
     * 
     * @param int $id
     * @return void
    */
    public function deleteSelfUser(int $id) : void {

        $sql = "DELETE FROM user WHERE id = :id ";

        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }



    /** user affiche ses RDV 
     * @param int $user_i
     * @return array $getBooking
    */
    public function getBooking(int $user_i) : array {

        $sql = "SELECT * FROM booking WHERE user_i = :user_i";

        $getBooking = $this->pdo->prepare($sql);
        $getBooking->execute(["user_i" => $user_i]);

        $getBooking = $getBooking->fetchAll();

        return $getBooking;
    }



    /** user efface un RDV
     * @param int $id
     * @return void
    */
    public function deleteBooking(int $id) : void {

        $sql = "DELETE FROM booking WHERE id = :id";

        $deleteOneBooking = $this->pdo->prepare($sql);
        $deleteOneBooking->execute(array(
            ':id' => $id
        ));
    }



    /** pour la reservation , user ajoute une reservation
     * 
     * @param int $user_id
     * @param string $booking_date_debut
     * @param string $booking_time_debut
     * @param string $booking_date_fin
     * @param string $booking_time_fin
     * @param int $number_of_seats
     * @param int car_id
     * 
     * @return void
    */
    public function addBooking(int $user_id, string $booking_date_debut, string $booking_time_debut, string $booking_date_fin, string $booking_time_fin, int $number_of_seats, int $car_id) : void {
        

        $sql = "INSERT INTO booking (user_i, booking_date_debut, booking_time_debut, booking_date_fin, booking_time_fin, number_of_seats, car_id, created_at )
                    VALUES(:user_i, :booking_date_debut, :booking_time_debut, :booking_date_fin, :booking_time_fin, :number_of_seats, :car_id, NOW())";

        //Insertion de la réservation dans la base de données.
        $addBooking = $this->pdo->prepare($sql);
        $addBooking->execute([
            ':user_i' => $user_id, 
            ':booking_date_debut' => $booking_date_debut, 
            ':booking_time_debut' => $booking_time_debut,
            ':booking_date_fin' => $booking_date_fin, 
            ':booking_time_fin' => $booking_time_fin,
            ':number_of_seats' => $number_of_seats,
            ':car_id' => $car_id
        ]);
    }
}