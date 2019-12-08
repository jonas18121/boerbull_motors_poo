<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/admin/booking/get/AdminGetBookingModel.php';

//appel de la session
require_once 'aSession/AdminSession.php';

//appel d'un fichier dans la librairie
require_once 'library/Tools.php';

class AdminGetBookingController{

    private $adminSession;
    private $adminGetBookingModel;

    public function __construct()
    {
        // instance de session et de model
        $this->adminSession = new AdminSession();
        $this->adminGetBookinModel = new AdminGetBookingModel();
    }


    //en GET
    public function adminGetBooking(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
    
        //appel de la fontion du model
        $adminFindBooking = $this->adminGetBookinModel->findBooking();

        //appel de la vue
        require_once 'www/templates/admin/booking/get/AdminGetBookingView.phtml';
    }
} 