<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/admin/users/add/AdminAddUsersModel.php';

//appel de la session
require_once 'aSession/AdminSession.php';

//appel d'un fichier dans la librairie
require_once 'library/Tools.php';


class AdminAddUsersController{


    private $adminSession;
    private $adminAddUsersModel;

    public function __construct()
    {
        // instance de session et de model
        $this->adminSession = new AdminSession();
        $this->adminAddUsersModel = new AdminAddUsersModel();
    }
    //en GET
    //affiche le formulaire d'ajout de user
    public function adminAddFormUsers(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        //appel de la vue
        require_once 'www/templates/admin/users/add/AdminAddFormUsersView.phtml';
    } 


    //en POST
    //admin ajoute un user
    public function adminAddUsers(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        //controle de formulaire en php
        if(!empty($_POST)){
            if(array_key_exists('first_name',$_POST) && isset($_POST['first_name']) && ctype_alpha($_POST['first_name'])){
                if( strlen($_POST['first_name']) >= 2 && strlen($_POST['first_name']) <= 25){
                    if(array_key_exists('last_name',$_POST) && isset($_POST['last_name']) && ctype_alpha($_POST['last_name'])){
                        if(strlen($_POST['last_name']) >= 2 && strlen($_POST['last_name']) <= 25){
                            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                                        $adminAddUsers =  $this->adminAddUsersModel->addUsers($_POST['first_name'], $_POST['last_name'], $_POST['mail'], $_POST['password']);

                                        //on redirectionne l'admin vers la liste des users
                                        redirect("index.php?action=admin&action2=users&action3=get");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //on redirectionne l'admin vers la liste des users
        redirect("index.php?action=admin&action2=users&action3=addForm");
    }
}