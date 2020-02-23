<?php
require_once 'model/admin/delete/AdminUsersModel.php';
require_once 'aSession/AdminSession.php';
require_once 'library/Tools.php';

class AdminDeleteSelfController{

    /** @var AdminSession */
    private $adminSession;

    /** @var AdminUsersModel */
    private $adminUsersModel;

    public function __construct()
    {
        $this->adminSession     = new AdminSession();
        $this->adminUsersModel  = new AdminUsersModel();
    }

    //en $_GET
    //supprimer une voiture
    public function adminDeleteSelf()
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
        $this->adminUsersModel->deleteSelfAdmin($_GET['id']);
        $this->adminSession->AdminDestroy();
        redirect("index.php");
    }
}