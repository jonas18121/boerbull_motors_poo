<?php
require_once 'model/admin/register/AdminUsersModel.php';
require_once 'library/Tools.php';


class AdminRegisterController{

    /** @var AdminUsersModel */
    private $adminUsersModel;

    public function __construct()
    {
        $this->adminUsersModel = new AdminUsersModel();
    }



    //en $_GET
    //formulaire d'inscription admin
    public function adminRegisterForm()
    {
        require_once 'www/templates/admin/register/AdminRegisterFormView.phtml';
    }




    //$_POST
    //inscription admin
    public function adminRegister()
    {
        if(!empty($_POST)){
            if(array_key_exists('name',$_POST) && isset($_POST['name']) && ctype_alpha($_POST['name'])){
                if(strlen($_POST['name']) >= 2 && strlen($_POST['name']) <= 25){
                    if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                        if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                            if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){
                                
                                $this->adminUsersModel->registerAdmin($_POST['name'], $_POST['mail'], $_POST['password']);
                                redirect('index.php?action=admin&action2=loginForm');
                            }  
                        }
                    }
                }
            }
        }
        redirect('index.php?action=admin&action2=registerForm');
    }
}