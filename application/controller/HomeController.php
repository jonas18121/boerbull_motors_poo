<?php
//controlleur, mettre en relation le model et la vue 

//appel du model
require_once 'model/HomeModel.php';


class HomeController{


    private $homeModel;

    public function __construct()
    {
        $this->homeModel = new HomeModel();
    }



    //A partir du routeur , getHome() appelera notre function findHome()
    public function getHome(){

        //appel de la fontion du model
        $home = $this->homeModel->findHome();

        //appel de la vue
        require_once 'www/templates/HomeView.phtml';
    }
}


