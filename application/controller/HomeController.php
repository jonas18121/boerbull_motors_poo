<?php
require_once 'model/HomeModel.php';

class HomeController{

    /** @var HomeModel */
    private $homeModel;

    public function __construct()
    {
        $this->homeModel = new HomeModel();
    }

    public function getHome()
    {
        $home = $this->homeModel->findHome();
        require_once 'www/templates/HomeView.phtml';
    }
}