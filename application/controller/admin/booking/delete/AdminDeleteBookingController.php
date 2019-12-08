<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/admin/booking/delete/AdminDeleteBookingModel.php';

//appel de la session
require_once 'aSession/AdminSession.php';

//appel du fichier dans la librairie
require_once 'library/Tools.php';


class AdminDeleteBookingController{


    private $adminSession;
    private $adminDeleteBookingModel;

    public function __construct()
    {
        // instance de session et de model
        $this->adminSession = new AdminSession();
        $this->adminDeleteBookingModel = new AdminDeleteBookingModel();
    }

    //en $_GET
    //supprimer une voiture
    public function adminDeleteBooking(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $this->adminDeleteBookingModel->deleteBookingAdmin($_GET['id']);

        //on redirectionne l'admin vers la liste des voitures
        redirect("index.php?action=admin&action2=booking&action3=get");
    }
}