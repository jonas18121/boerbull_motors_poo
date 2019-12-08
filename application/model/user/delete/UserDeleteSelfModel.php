<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';


class UserDeleteSelfModel extends Model{


    /** user supprime son compte 
     * 
     * @param int
     * 
     * @return void
    */
    public function deleteSelfUser($id){

        $sql = "DELETE FROM user WHERE id = :id ";

        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }
    
}