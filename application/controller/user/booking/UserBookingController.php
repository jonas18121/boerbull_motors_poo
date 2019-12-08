<?php
//controlleur mettre en relation le model et la vue 

//appel du model
//require_once 'model/user/booking/UserBookingModel.php';
require_once 'model/user/UserModel.php';
require_once 'model/panier/NewPanierModel.php';

//appel de la session
require_once 'aSession/UserSession.php';

//appel d'un fichier dans la librairie
require_once 'library/Tools.php';


class UserBookingController{


    private $userSession;
    private $UserModel;

    public function __construct()
    {
        // instance de session et de model
        $this->userSession = new UserSession();
        //$this->UserBookingModel = new UserBookingModel();
        $this->UserModel = new UserModel();
    }

    //afficher les RDV
    public function getRDV(){

        // On ne peut pas afficher les réservations sans être connecté !
        // sinon l'utilisateur sera renvoyer vers la page de connexion
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }

        //pour éviter que la session de l'utilisateur en cours, ait accès au RDV des autres utilisateurs   
        if(isset($_GET['user_i']) && $_GET['user_i'] ===  $_SESSION['user']['id'] ){
    
            $getBooking = $this->UserModel->getBooking($_GET['user_i']);

            //appel de la vue
            require_once 'www/templates/user/booking/BookingView.phtml';
        }

        // si $_GET['user_i'] est différent , 
        //on remet $_SESSION['user']['id'] dans $_GET['user_i'] pour afficher le bon resultat
        $_GET['user_i'] = $_SESSION['user']['id'];
        $getBooking = $this->UserModel->getBooking($_GET['user_i']);


        //appel de la vue
        require_once 'www/templates/user/booking/BookingView.phtml';
    }




    //effacer un RDV
    public function deleteRDV(){
        // On ne peut pas effacer les réservations sans être connecté !
        // sinon l'utilisateur sera renvoyer vers la page de connexion
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }
    
        $this->UserModel->deleteBooking($_GET['id']);

        redirect('index.php?action=user&action2=userRDV&user_i='. $this->userSession->getUserId());
    }
}

