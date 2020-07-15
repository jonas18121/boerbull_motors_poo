<?php
require_once 'aSession/AdminSession.php';
require_once 'library/Tools.php';

class AdminLogoutController{

    /** @var AdminSession */
    private $adminSession;

    public function __construct()
    {
        $this->adminSession = new AdminSession();
    }

    public function  adminLogout()
    {
        $this->adminSession->Admindestroy();
        redirect('index.php?action=user&action2=loginForm');
    }
}