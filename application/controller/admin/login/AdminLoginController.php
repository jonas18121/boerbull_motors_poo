<?php
require_once 'model/admin/login/AdminUsersModel.php';
require_once 'aSession/AdminSession.php';


class AdminLoginController{

    /** @var AdminSession */
    private $adminSession;

    /** @var AdminUsersModel */
    private $adminUsersModel;

    public function __construct()
    {
        $this->adminSession     = new AdminSession();
        $this->adminUsersModel  = new AdminUsersModel();
    }

    // en $_GET
    //formulaire de connexion
    public function adminLoginForm()
    {
        require_once 'www/templates/admin/login/AdminLoginFormView.phtml';
    }



    // en $_POST
    //connexion admin
    public function adminLogin()
    {
        if(!empty($_POST)){
            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                        $login = $this->adminUsersModel->loginAdmin($_POST['mail'], $_POST['password']);
                        $this->adminSession->adminCreate($login['id'], $login['name'], $login['mail']);
                        redirect('index.php');
                    }
                }
            }
        }
        redirect('index.php?action=admin&action2=loginForm'); 
    }
}