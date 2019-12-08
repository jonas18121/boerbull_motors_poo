<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/admin/users/get/AdminGetUsersModel.php';

//appel de la session
require_once 'aSession/AdminSession.php';

//appel d'un fichier dans la librairie
require_once 'library/Tools.php';


class adminGetUsersController{

    private $adminSession;
    private $adminGetUsersModel;

    public function __construct()
    {
        // instance de session et de model
        $this->adminSession =       new AdminSession();
        $this->adminGetUsersModel = new AdminGetUsersModel();
    }

    //en GET
    public function adminGetUsers(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
    
        //appel de la fontion du model
        $adminGetUsers = $this->adminGetUsersModel->GetUsers();

        //appel de la vue
        require_once 'www/templates/admin/users/get/AdminGetUsersView.phtml';
    } 
}