<?php
require_once 'model/admin/users/get/AdminUsersModel.php';
require_once 'aSession/AdminSession.php';
require_once 'library/Tools.php';


class adminGetUsersController{

    /** @var AdminSession */
    private $adminSession;

    /** @var AdminUsersModel */
    private $adminUsersModel;

    public function __construct()
    {
        $this->adminSession     = new AdminSession();
        $this->adminUsersModel  = new AdminUsersModel();
    }

    //en GET
    // afficher les users
    public function adminGetUsers()
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
        $adminGetUsers = $this->adminUsersModel->GetUsers();
        require_once 'www/templates/admin/users/get/AdminGetUsersView.phtml';
    } 
}