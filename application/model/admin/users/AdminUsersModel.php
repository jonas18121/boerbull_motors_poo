<?php

//inclure la classe Model
require_once 'model/admin/AdminModel.php';

//appel dans la librairie
include_once 'library/Tools.php';

class AdminUsersModel extends AdminModel{


            //// Afficher ////    
    /** Afficher tous les users 
     * 
     * @return array $adminGetUsers
    */
    public function GetUsers() : array{

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
    public function addUsers(string $first_name, string $last_name, string $email, string $password) : void {

        /* on teste si le mail existe et est valide , s'il est différent de false , on continue.
        //filter_var — Filtre une variable avec un filtre spécifique
         */
        if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
            
            //si le mail est dans la table user , on selectionne tous le contenue de cette table
            $sql = "SELECT * From user WHERE mail = :mail ";
            $userExist = $this->pdo->prepare($sql); 
            $userExist->execute([':mail' => $email]);
            $userExist = $userExist->fetchAll();


            /* si ce mail existe déjà dans la bdd lors de l'inscription , on lance une erreur  */
            if($userExist){
                throw new PDOException(("Un utilisateur existe déjà avec cet email."));
            }


            /* si le mail n'existe pas déjà dans la bdd lors de l'inscription, c'est bon , on peut hashé le mot de passe */
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

            //return $userExist; 
        }
    }






                //// Modifier ////    
    //en $_GET
    /** admin affiche le user a modifier 
     * 
     * @param int $id
     * 
     * @return array $editFormUsers
    */
    public function editFormUsers(int $id) : array {

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
    public function editUsers(string $first_name, string $last_name, string $email, string $password, int $id) : void {

        // requète pour modifier un user précis
        $sql = "UPDATE user SET first_name = :first_name, last_name = :last_name, mail = :mail, password = :password WHERE id = :id";

        /* on hashe le nouveau mot de passe */
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
     * 
     * @return void
    */
    public function deleteUser(int $id) : void {

        $sql = "DELETE FROM user WHERE id = :id ";
        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }






                //// afficher pour ajouter un RDV pour un user ////      
    //en GET 
    /** Afficher un seul user 
     * 
     * @param int $id
     * 
     * @return array
    */
    public function GetUser(int $id) : array {

        $sql = "SELECT * FROM user WHERE id = :id";

        $getUser = $this->pdo->prepare($sql);
        $getUser->execute([':id' => $id]);
        $getUser = $getUser->fetch();

        if(empty($getUser)){
            redirect("index.php");
        }

        return $getUser;
    }
}