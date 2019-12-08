<?php

//appel du model
require_once 'model/admin/booking/AdminBookingModel.php';
require_once 'model/admin/users/AdminUsersModel.php';

class AdminBookingController extends AdminController{

    private $adminBookingModel;

    public function __construct()
    {
        // instance de session et de model
        parent::__construct();
        $this->adminBookingModel = new AdminBookingModel();
        $this->adminUsersModel = new AdminUsersModel();
    }

    //en GET
    // afficher tous les rendez-vous
    public function adminGetBooking(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
    
        //appel de la fontion du model
        $adminFindBooking = $this->adminBookingModel->findBooking();

        //appel de la vue
        require_once 'www/templates/admin/booking/get/AdminGetBookingView.phtml';
    }


    //en $_GET
    //supprimer un rendez-vous
    public function adminDeleteBooking(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $this->adminBookingModel->deleteBookingAdmin($_GET['id']);

        //on redirectionne l'admin vers la liste des voitures
        redirect("index.php?action=admin&action2=booking&action3=get");
    }





                    //// ajouter un RDV ////  
    //en $_GET
    //affiche le formulaire booking
    public function adminBookingFormUser(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        $user = $this->adminUsersModel->GetUser($_GET['id']);

        //appel de la vue
        require_once 'www/templates/admin/users/booking/AdminBookingUserView.php';
    }



    //en $_POST
    //ajoute un RDV pour un user
    public function adminAddBookingUser(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        if(!empty($_POST)){
            if(array_key_exists('user_i',$_POST) && isset($_POST['user_i']) && ctype_digit($_POST['user_i'])){
                if(array_key_exists('booking_date_debut',$_POST) && isset($_POST['booking_date_debut'])){  
                    if(array_key_exists('booking_time_debut',$_POST) && isset($_POST['booking_time_debut'])){ 
                        if(array_key_exists('booking_date_fin',$_POST) && isset($_POST['booking_date_fin'])){  
                            if(array_key_exists('booking_time_fin',$_POST) && isset($_POST['booking_time_fin'])){ 
                                if(array_key_exists('number_of_seats',$_POST) && isset($_POST['number_of_seats']) && ctype_digit($_POST['number_of_seats'])){ 
                
                                    $this->adminBookingModel->adminAddBooking($_POST['user_i'], $_POST['booking_date_debut'], $_POST['booking_time_debut'], $_POST['booking_date_fin'], $_POST['booking_time_fin'], $_POST['number_of_seats']);

                                    redirect("index.php?action=admin&action2=booking&action3=get");
                                }
                            }
                        }
                    }
                }
            }
        }
        redirect("index.php");
    }
}