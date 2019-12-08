<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

class AdminDeleteSelfModel extends Model{


    /** admin supprime son compte 
     * 
     * @param int
     * 
     * @return void
    */
    public function deleteSelfAdmin($id){

        $sql = "DELETE FROM boerbull_admin WHERE id = :id ";

        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }
}