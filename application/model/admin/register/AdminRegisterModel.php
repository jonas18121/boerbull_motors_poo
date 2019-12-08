<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

class AdminRegisterModel extends Model{

    

    /** register  /INSCRIPTION 
     * 
     * @param string
     * 
     * @return void/array
    */
    public function registerAdmin($name, $email, $password){

        
        /* on teste si le mail existe et est valide , s'il est différent de false , on continue.
        //filter_var — Filtre une variable avec un filtre spécifique
         */
        if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
        
            //si le mail est dans la table user , on selectionne tous le contenue de cette table
            $sql = "SELECT * From boerbull_admin WHERE mail = :mail ";

            $adminExist = $this->pdo->prepare($sql);
            $adminExist->execute([
                ':mail' => $email
            ]);
            $adminExist = $adminExist->fetchAll();
        

        
            /* si ce mail existe déjà dans la bdd lors de l'inscription , on lance une erreur  */
            if($adminExist){
                throw new PDOException(("Un admin existe déjà avec cet email."));
            }


            /* si le mail n'existe pas déjà dans la bdd lors de l'inscription, c'est bon , on peut hashé le mot de passe */
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);


            // et on peut ajouter le nouvelle utilisateur dans la base de donnée
            $sql = "INSERT INTO boerbull_admin (name, mail, password) VALUE(:name, :mail, :password)";

            $admin = $this->pdo->prepare($sql);
            $admin = $admin->execute([
                ':name' => $name, 
                ':mail' => $email, 
                ':password' => $passwordHashed
            ]);

            return $adminExist; 
        }
    }
}