<?php
require_once 'model/admin/users/edit/AdminUsersModel.php';
require_once 'aSession/AdminSession.php';
require_once 'library/Tools.php';


class AdminEditUsersController{

    /** @var AdminSession */
    private $adminSession;

    /** @var AdminUsersModel */
    private $adminUsersModel;

    public function __construct()
    {
        $this->adminSession     = new AdminSession();
        $this->adminxUsersModel = new AdminUsersModel();
    }

    //en GET$
    //affiche le formulaire de modification de user
    public function adminEditFormUsers()
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
        $adminEditFormUsers = $this->adminUsersModel->editFormUsers($_GET['id']);
        require_once 'www/templates/admin/users/edit/AdminEditFormUsersView.phtml';
    } 


    //en POST
    //admin modifie un user
    public function adminEditUsers()
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        if(!empty($_POST)){
            if(array_key_exists('id',$_POST) && isset($_POST['id']) && ctype_digit($_POST['id'])){
                if(array_key_exists('first_name',$_POST) && isset($_POST['first_name']) && ctype_alpha($_POST['first_name'])){
                    if( strlen($_POST['first_name']) >= 2 && strlen($_POST['first_name']) <= 25){
                        if(array_key_exists('last_name',$_POST) && isset($_POST['last_name']) && ctype_alpha($_POST['last_name'])){
                            if(strlen($_POST['last_name']) >= 2 && strlen($_POST['last_name']) <= 25){
                                if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                                    if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                                        if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                                            $this->adminEditUsersModel->editUsers($_POST['first_name'], $_POST['last_name'], $_POST['mail'], $_POST['password'], $_POST['id']);
                                            redirect("index.php?action=admin&action2=users&action3=get");
                                        }
                                        redirect('index.php?action=admin&action2=users&action3=editForm&id=' . $_POST['id']);
                                    }
                                    redirect('index.php?action=admin&action2=users&action3=editForm&id=' . $_POST['id']);
                                }
                                redirect('index.php?action=admin&action2=users&action3=editForm&id=' . $_POST['id']);
                            }
                            redirect('index.php?action=admin&action2=users&action3=editForm&id=' . $_POST['id']);
                        }
                        redirect('index.php?action=admin&action2=users&action3=editForm&id=' . $_POST['id']);
                    }
                    redirect('index.php?action=admin&action2=users&action3=editForm&id=' . $_POST['id']);
                }
                redirect('index.php?action=admin&action2=users&action3=editForm&id=' . $_POST['id']);
            }
        }
        redirect("index.php?action=admin&action2=users&action3=get");
    }
}