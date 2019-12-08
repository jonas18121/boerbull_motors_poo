<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';


class AdminDeleteUsersModel extends Model{



    /** supprimer un user 
     * 
     * @param int
     * 
     * @return void
    */
    public function deleteUser($id){

        $sql = "DELETE FROM user WHERE id = :id ";

        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }
}