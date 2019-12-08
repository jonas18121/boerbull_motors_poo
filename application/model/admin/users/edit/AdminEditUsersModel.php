<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

//appel dans la librairie
include_once 'library/Tools.php';


class AdminEditUsersModel extends Model{



    //en $_GET
    /** admin affiche le user a modifier 
     * 
     * @param int
     * 
     * @return array
    */
    public function editFormUsers($id){

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
     * @param string/int
     * 
     * @return void
    */
    public function editUsers($first_name, $last_name, $email, $password, $id){

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
}
