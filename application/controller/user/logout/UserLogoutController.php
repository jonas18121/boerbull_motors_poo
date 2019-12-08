<?php
//controlleur mettre en relation le model et la vue 

//appel de le session user
require_once 'aSession/UserSession.php';


class UserLogoutController{

    private $userSession;

    public function __construct()
    {
        // instance de session 
        $this->userSession = new UserSession();
    }


    public function userLougout(){

        //on appel userDestroy() qui est dans UserSession.php
        $this->userSession->userDestroy();

        //puis on ce redire vers l'accueil
        redirect('index.php');
    }
}
