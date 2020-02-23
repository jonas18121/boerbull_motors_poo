<?php
require_once 'model/admin/users/delete/AdminUsersModel.php';
require_once 'aSession/AdminSession.php';
require_once 'library/Tools.php';


class AdminDeleteUserController{

    /** @var AdminSession */
    private $adminSession;

    /** @var AdminUsersModel */
    private $adminDeleteUsersModel;

    public function __construct()
    {
        $this->adminSession             = new AdminSession();
        $this->adminDeleteUsersModel    = new AdminUsersModel();
    }

    //en $_GET
    //supprimer un user
    public function adminDeleteUsers()
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        } 
        $this->adminDeleteUsersModel->deleteUser($_GET['id']);
        redirect("index.php?action=admin&action2=users&action3=get");
    }
}