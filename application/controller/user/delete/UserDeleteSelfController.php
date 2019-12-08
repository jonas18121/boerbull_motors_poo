<?php
//controlleur mettre en relation le model et la vue 

//appel du model
//require_once 'model/user/delete/UserDeleteSelfModel.php';
require_once 'model/user/UserModel.php';

//appel de la session
require_once 'aSession/UserSession.php';

//appel du fichier dans la librairie
require_once 'library/Tools.php';


class UserDeleteSelfController{

    private $userSession;
    private $userModel;

    public function __construct()
    {
        // instance de session et de model
        $this->userSession = new UserSession();
        //$this->userDeleteSelfModel = new  UserDeleteSelfModel();
        $this->userModel = new  UserModel();
    }

    //en $_GET
    //supprimer une voiture
    function userDeleteSelf(){


        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->userSession->isAuthenticatedUser()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $this->userModel->deleteSelfUser($_GET['id']);

        //on detruit la session de user
        $this->userSession->userDestroy();

        //on redirectionne vers l'accueil
        redirect("index.php");
    }
}