<?php
declare(strict_types=1);

require_once 'model/admin/AdminModel.php';
require_once 'library/Tools.php';

class AdminController{

    /** @var AdminSession */
    protected AdminSession $adminSession;

    /** @var AdminModel */
    private AdminModel $adminModel;

    public function __construct()
    {
        $this->adminSession = new AdminSession();
        $this->adminModel   = new AdminModel();
    }


    /////////// register ////////////

    /**
     * en $_GET, formulaire d'inscription admin
     *
     * @return void
     */
    public function adminRegisterForm() : void
    {
        require_once 'www/templates/admin/register/AdminRegisterFormView.phtml';
    }




    /**
     * En $_POST, inscription admin
     *
     * @return void
     */
    public function adminRegister() : void
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
                            redirect('index.php?action=admin&action2=registerForm');
                        }
                        redirect('index.php?action=admin&action2=registerForm');
                    }
                    redirect('index.php?action=admin&action2=registerForm');
                }
                redirect('index.php?action=admin&action2=registerForm');
            }
            redirect('index.php?action=admin&action2=registerForm');
        }
        redirect('index.php?action=admin&action2=registerForm');
    }





    /////////// login ////////////

    /**
     * En $_GET, formulaire de connexion admin
     *
     * @return void
     */
    public function adminLoginForm() : void
    {
        require_once 'www/templates/admin/login/AdminLoginFormView.phtml';
    }



    /**
     * En $_POST, connexion admin
     *
     * @return void
     */
    public function adminLogin() : void
    {
        if(!empty($_POST)){
            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                        $login = $this->adminModel->loginAdmin($_POST['mail'], $_POST['password']);
                        $this->adminSession->adminCreate((int) $login['id'], $login['name'], $login['mail']);
                        redirect('index.php');
                    }
                    redirect('index.php?action=admin&action2=loginForm');
                }
                redirect('index.php?action=admin&action2=loginForm');
            }
            redirect('index.php?action=admin&action2=loginForm');
        }
        redirect('index.php?action=admin&action2=loginForm'); 
    }






    /////////// logout ////////////

    /**
     * En $_GET, déconnexion admin
     *
     * @return void
     */
    public function  adminLogout() : void
    {
        $this->adminSession->Admindestroy();
        redirect('index.php?action=user&action2=loginForm');
    }




    /////////// delete ////////////

    /**
     * En $_GET, admin supprime son compte 
     *
     * @return void
     */
    public function adminDeleteSelf() : void
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        $this->adminModel->deleteSelfAdmin((int) $_GET['id']);
        $this->adminSession->AdminDestroy();

        redirect("index.php?action=user&action2=loginForm");
    }
}