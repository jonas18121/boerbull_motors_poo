<?php
require_once 'model/admin/AdminModel.php';
require_once 'library/Tools.php';

class AdminController{

    /** @var AdminSession */
    protected $adminSession;

    /** @var AdminModel */
    private $adminModel;

    public function __construct()
    {
        $this->adminSession = new AdminSession();
        $this->adminModel   = new AdminModel();
    }


    /////////// register ////////////
    //en $_GET
    // formulaire d'inscription admin
    public function adminRegisterForm()
    {
        require_once 'www/templates/admin/register/AdminRegisterFormView.phtml';
    }




    //$_POST
    // inscription admin
    public function adminRegister()
    {
        if(!empty($_POST)){
            if(array_key_exists('name',$_POST) && isset($_POST['name']) && ctype_alpha($_POST['name'])){
                if(strlen($_POST['name']) >= 2 && strlen($_POST['name']) <= 25){
                    if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                        if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                            if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){
                                
                                $this->adminModel->registerAdmin($_POST['name'], $_POST['mail'], $_POST['password']);
                                redirect('index.php?action=admin&action2=loginForm');
                            }  
                        }
                    }
                }
            }
        }
        redirect('index.php?action=admin&action2=registerForm');
    }





    /////////// login ////////////
    // en $_GET
    // formulaire de connexion admin
    public function adminLoginForm()
    {
        require_once 'www/templates/admin/login/AdminLoginFormView.phtml';
    }



    // en $_POST
    // connexion admin
    public function adminLogin()
    {
        if(!empty($_POST)){
            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                        $login = $this->adminModel->loginAdmin($_POST['mail'], $_POST['password']);
                        $this->adminSession->adminCreate($login['id'], $login['name'], $login['mail']);
                        redirect('index.php');
                    }
                }
            }
        }
        redirect('index.php?action=admin&action2=loginForm'); 
    }






    /////////// logout ////////////
    //en $_GET
    // admin déconnexion
    public function  adminLogout()
    {
        $this->adminSession->Admindestroy();
        redirect('index.php');
    }




    /////////// delete ////////////
    //en $_GET
    //supprimer une voiture
    public function adminDeleteSelf()
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
        $this->adminModel->deleteSelfAdmin($_GET['id']);
        $this->adminSession->AdminDestroy();
        redirect("index.php");
    }
}