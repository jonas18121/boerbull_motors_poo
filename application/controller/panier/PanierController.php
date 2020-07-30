<?php

require_once 'model/panier/PanierModel.php';
require_once 'model/car/CarModel.php';
require_once 'library/Tools.php';
require_once 'aSession/AdminSession.php';
require_once 'aSession/UserSession.php';



class PanierController{

    /**
     * @var object UserSession
     */
    private UserSession $userSession;

    /**
     * @var object PanierModel
     */
    private PanierModel $panierModel;

    
    public function __construct()
    {
        $this->userSession = new UserSession();
        $this->panierModel = new PanierModel();
    }

    /** ajouter un element au panier */
    public function panierAdd() : void
    {
        if(!$this->userSession->isAuthenticatedUser()){
            redirect("index.php?action=user&action2=loginForm");
        }
    
        $this->panierModel->addPanier((int) $_GET['id']);
        require_once 'www/templates/panier/PanierView.phtml';
    }

    /** afficher resultat sur le tableau */
    public function panierOpen() : void
    {
        $session        = array_keys($_SESSION['panier']);
        $panier         = $this->panierModel->PanierView($session);
        $prix_total_ht  = $this->panierModel->prixHorsTaxe($session);
        $prix_total_TTC = $this->panierModel->prixTTC($session);
        $TVA            = $this->panierModel->TVA($session);
    
        require_once 'www/templates/panier/PanierView.phtml';  
    }

    /** effacer un article */
    public function deleteOneArticle() : void
    {
        $this->panierModel->deleteOne((int) $_GET['id']);
        $this->panierOpen();
    } 
}