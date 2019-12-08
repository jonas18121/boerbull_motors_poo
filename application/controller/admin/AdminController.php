<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/admin/AdminModel.php';

//appel d'un fichier dans la librairie
require_once 'library/Tools.php';

class AdminController{

    protected $adminSession;
    private $adminModel;

    public function __construct()
    {
        // instance de session et de model
        $this->adminSession = new AdminSession();
        $this->adminModel = new AdminModel();
    }


    /////////// register ////////////
    //en $_GET
    public function adminRegisterForm(){
        //appel de la vue
        require_once 'www/templates/admin/register/AdminRegisterFormView.phtml';
    }




    //$_POST
    //A partir du routeur , adminRegister() appelera notre function  registerAdmin()
    public function adminRegister(){
        
        //controle de formulaire en php
        if(!empty($_POST)){
            if(array_key_exists('name',$_POST) && isset($_POST['name']) && ctype_alpha($_POST['name'])){
                if(strlen($_POST['name']) >= 2 && strlen($_POST['name']) <= 25){
                    if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                        if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                            if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){
                                //inscription admin
                                $this->adminModel->registerAdmin($_POST['name'], $_POST['mail'], $_POST['password']);
                                //redirection à la page de connexion pour admin
                                redirect('index.php?action=admin&action2=loginForm');
                            }  
                        }
                    }
                }
            }
        }
        // s'il y a un controle qui n'est pas bon, on redirectionne à la page d' inscription pour admin
        redirect('index.php?action=admin&action2=registerForm');
    }





    /////////// login ////////////
    // en $_GET
    public function adminLoginForm(){
        //appel de la vue
        require_once 'www/templates/admin/login/AdminLoginFormView.phtml';
    }



    // en $_POST
    //A partir du routeur , il appelera notre function adminLogin()
    public function adminLogin(){

        //controle de formulaire en php
        if(!empty($_POST)){
            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                        //connection admin
                        $login = $this->adminModel->loginAdmin($_POST['mail'], $_POST['password']);
                        //on crée la session
                    
                        $this->adminSession->adminCreate($login['id'], $login['name'], $login['mail']);
                        //redirection à la page d'accueil
                        redirect('index.php');
                    }
                }
            }
        }
        //si un controle n'est pas bon, redirection à la page de connexion
        redirect('index.php?action=admin&action2=loginForm'); 
    }






    /////////// logout ////////////
    public function  adminLogout(){

        //on appel destroy() qui est dans AdminSession.php
        $this->adminSession->Admindestroy();

        //puis on ce redire vers l'accueil
        redirect('index.php');
    }




    /////////// delete ////////////
    //en $_GET
    //supprimer une voiture
    public function adminDeleteSelf(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $this->adminModel->deleteSelfAdmin($_GET['id']);

        //on detruit la session de admin
        $this->adminSession->AdminDestroy();

        //on redirectionne vers l'accueil
        redirect("index.php");
    }
}