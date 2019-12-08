<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

class AdminModel extends Model{
    


     /** register  /INSCRIPTION 
     * 
     * @param string $name
     * @param string $email
     * @param string $password
     * 
     * @return void
    */
    public function registerAdmin(string $name, string $email, string $password) : void {

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

            //return $adminExist; 
        }
    }




    /** login  /CONNEXION 
     * 
     * @param string $email
     * @param string $password
     * 
     * @return array $adminExist
    */
    public function loginAdmin(string $email, string $password) : array {

        //si le mail est dans la table boerbull_admin , on selectionne tous le contenue de cette table
        $sql = "SELECT * From boerbull_admin WHERE mail = :mail ";

        $adminExist = $this->pdo->prepare($sql);
        $adminExist->execute([':mail' => $email]);
        $adminExist = $adminExist->fetch();

        //on teste si le mail exist dans la table user
        if(empty($adminExist)){
            throw new PDOException(('admin inconnu - cet email n\' existe pas'));
        }

        //on teste si le mot de passe correspond a celui qui est dans la bdd
        if(!password_verify($password, $adminExist['password'])){
            throw new PDOException('Le mot de passe est incorrect');
        } 

        return $adminExist;
    }            




    /** on récupère tous les admins 
     * 
     * @return array $adminAll
    */
    public function adminAll() : array {

        $sql = 'SELECT * FROM boerbull_admin';
        $adminAll = $this->pdo->query($sql);
        $adminAll = $adminAll->fetchAll();

        return $adminAll;
    }




    /** admin supprime son compte 
     * 
     * @param int $id
     * 
     * @return void
    */
    public function deleteSelfAdmin(int $id) : void {

        $sql = "DELETE FROM boerbull_admin WHERE id = :id ";

        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }
}