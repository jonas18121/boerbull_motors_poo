<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';



class UserRegisterModel extends Model{



    /** register  /INSCRIPTION 
    * 
    * @param string
    * 
    * @return void/array
    */
    public function registerUser($first_name, $last_name, $email, $password){
      

        /* on teste si le mail existe et est valide , s'il est différent de false , on continue.
        //filter_var — Filtre une variable avec un filtre spécifique
        */
        if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
        
            //si le mail est dans la table user , on selectionne tous le contenue de cette table
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

            return $userExist; 
        }
    }
}