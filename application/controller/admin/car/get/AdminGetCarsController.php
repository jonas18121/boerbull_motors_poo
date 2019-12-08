<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/admin/car/get/AdminGetCarsModel.php';

//appel de la session
require_once 'aSession/AdminSession.php';

//appel d'un fichier dans la librairie
require_once 'library/Tools.php';

class AdminGetCarsController{

    private $adminSession;
    private $adminGetCarsModel;

    public function __construct()
    {
        // instance de session et de model
        $this->adminSession = new AdminSession();
        $this->adminGetCarsModel = new AdminGetCarsModel();
    }
    
    //en GET
    public function adminGetCars(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
    
        //appel de la fontion du model
        $adminGetCars = $this->adminGetCarsModel->GetCars();

        //appel de la vue
        require_once 'www/templates/admin/car/get/AdminGetCarsView.phtml';
    }
} 