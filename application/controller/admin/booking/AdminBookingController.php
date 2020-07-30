<?php
declare(strict_types=1);

require_once 'model/admin/booking/AdminBookingModel.php';
require_once 'model/admin/users/AdminUsersModel.php';

class AdminBookingController extends AdminController{

    /** @var AdminBookingModel */
    private AdminBookingModel $adminBookingModel;

    /** @var AdminUsersModel */
    private AdminUsersModel $adminUsersModel;

    public function __construct()
    {
        parent::__construct();
        //$this->adminBookingModel = new AdminBookingModel();
        $this->adminUsersModel = new AdminUsersModel();
    }

    /**
     * En GET, afficher tous les rendez-vous
     *
     * @return void
     */
    public function adminGetBooking() : void
    {
        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
        $adminFindBooking = $this->adminUsersModel->findBooking();
        require_once 'www/templates/admin/booking/get/AdminGetBookingView.phtml';
    }

    /**
     * En $_GET, supprimer un rendez-vous
     *
     * @return void
     */
    public function adminDeleteBooking() : void
    {
        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $this->adminUsersModel->deleteBookingAdmin((int) $_GET['id']);

        redirect("index.php?action=admin&action2=booking&action3=get");
    }

                    //// ajouter un RDV //// 
    /**
     * En $_GET, affiche le formulaire booking
     *
     * @return void
     */
    public function adminBookingFormUser() : void
    {
        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        $user = $this->adminUsersModel->GetUser((int) $_GET['id']);
        require_once 'www/templates/admin/users/booking/AdminBookingUserView.php';
    }

    /**
     * En $_POST, ajoute un RDV pour un user
     *
     * @return void
     */
    public function adminAddBookingUser() : void
    {
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
                
                                    $this->adminUsersModel->adminAddBooking((int) $_POST['user_i'], $_POST['booking_date_debut'], $_POST['booking_time_debut'], $_POST['booking_date_fin'], $_POST['booking_time_fin'], (int) $_POST['number_of_seats']);

                                    redirect("index.php?action=admin&action2=booking&action3=get");
                                }
                                redirect("index.php");
                            }
                            redirect("index.php");
                        }
                        redirect("index.php");
                    }
                    redirect("index.php");
                }
                redirect("index.php");
            }
            redirect("index.php");
        }
        redirect("index.php");
    }
}