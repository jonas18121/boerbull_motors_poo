<?php
require_once 'model/Model.php';

class AdminModel extends Model{
    
     /** register  /INSCRIPTION 
     * 
     * @param string $name
     * @param string $email
     * @param string $password
     * @return void
    */
    public function registerAdmin(string $name, string $email, string $password) : void 
    {
        if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
        
            $sql = "SELECT * From boerbull_admin WHERE mail = :mail ";

            $adminExist = $this->pdo->prepare($sql);
            $adminExist->execute([
                ':mail' => $email
            ]);
            $adminExist = $adminExist->fetchAll();
        
            if($adminExist){
                throw new PDOException(("Un admin existe déjà avec cet email."));
            }

            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO boerbull_admin (name, mail, password) VALUE(:name, :mail, :password)";

            $admin = $this->pdo->prepare($sql);
            $admin = $admin->execute([
                ':name' => $name, 
                ':mail' => $email, 
                ':password' => $passwordHashed
            ]); 
        }
    }

    /** login  /CONNEXION 
     * 
     * @param string $email
     * @param string $password
     * @return array $adminExist
    */
    public function loginAdmin(string $email, string $password) : array 
    {
        $sql = "SELECT * From boerbull_admin WHERE mail = :mail ";

        $adminExist = $this->pdo->prepare($sql);
        $adminExist->execute([':mail' => $email]);
        $adminExist = $adminExist->fetch();

        if(empty($adminExist)){
            throw new PDOException(('admin inconnu - cet email n\' existe pas'));
        }

        if(!password_verify($password, $adminExist['password'])){
            throw new PDOException('Le mot de passe est incorrect');
        } 

        return $adminExist;
    }            

    /** on récupère tous les admins 
     * 
     * @return array $adminAll
    */
    public function adminAll() : array 
    {
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
    public function deleteSelfAdmin(int $id) : void 
    {
        $sql = "DELETE FROM boerbull_admin WHERE id = :id ";

        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }
}