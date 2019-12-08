<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/admin/delete/AdminDeleteSelfModel.php';

//appel de la session
require_once 'aSession/AdminSession.php';

//appel du fichier dans la librairie
require_once 'library/Tools.php';

class AdminDeleteSelfController{

    private $adminSession;
    private $adminDeleteSelfModel;

    public function __construct()
    {
        $this->adminSession = new AdminSession();
        $this->adminDeleteSelfModel = new AdminDeleteSelfModel();
    }

    //en $_GET
    //supprimer une voiture
    public function adminDeleteSelf(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $this->adminDeleteSelfModel->deleteSelfAdmin($_GET['id']);

        //on detruit la session de admin
        $this->adminSession->AdminDestroy();

        //on redirectionne vers l'accueil
        redirect("index.php");
    }
}