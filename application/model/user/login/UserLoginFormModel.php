<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';



class UserLoginModel extends Model{



    /** login  /CONNEXION 
    * 
    * @param string
    * 
    *  @return array
    */
    public function loginUser($email, $password){

        //si le mail est dans la table user , on selectionne tous le contenue de cette table
        $sql = "SELECT * From user WHERE mail = :mail ";

        $userExist = $this->pdo->prepare($sql);
        $userExist->execute([':mail' => $email]);
        $userExist = $userExist->fetch();

        //on teste si le mail exist dans la table user
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
    *  @return array
    */
    public function userAll(){
        $sql = 'SELECT * FROM user';
        $userAll = $this->pdo->query($sql);
        $userAll = $userAll->fetchAll();

        return $userAll;
    }
}
