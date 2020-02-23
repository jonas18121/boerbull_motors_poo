<?php
require_once 'model/admin/users/booking/AdminUserModel.php';
require_once 'aSession/AdminSession.php';
require_once 'library/Tools.php';



class AdminBookingUsersController{

    /** @var AdminSession */
    private $adminSession;

    /** @var AdminUsersModel */
    private $adminBookingUserModel;

    public function __construct()
    {
        $this->adminSession          = new AdminSession();
        $this->adminBookingUserModel = new AdminUsersModel();
    }

    //en $_GET
    //affiche le formulaire booking
    public function adminBookingFormUser()
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
        $user = $this->adminBookingUserModel->GetUser($_GET['id']);
        require_once 'www/templates/admin/users/booking/AdminBookingUserView.php';
    }



    //en $_POST
    //ajoute un RDV pour un user
    public function adminAddBookingUser()
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
                
                                    $this->adminBookingUserModel->adminAddBooking($_POST['user_i'], $_POST['booking_date_debut'], $_POST['booking_time_debut'], $_POST['booking_date_fin'], $_POST['booking_time_fin'], $_POST['number_of_seats']);
                                    redirect("index.php?action=admin&action2=users&action3=get");
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