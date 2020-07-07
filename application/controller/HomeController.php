<?php
require_once 'model/HomeModel.php';

class HomeController{

    /** @var HomeModel */
    private HomeModel $homeModel;

    public function __construct()
    {
        $this->homeModel = new HomeModel();
    }

    public function getHome() : void
    {
        $home = $this->homeModel->findHome();
        require_once 'www/templates/HomeView.phtml';
    }
}