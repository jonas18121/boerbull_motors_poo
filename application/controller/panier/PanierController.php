<?php
require_once 'model/panier/NewPanierModel.php';
require_once 'model/oneCar/OneCarModel.php';
require_once 'library/Tools.php';
require_once 'aSession/AdminSession.php';



class PanierController{

    /**
     * @var object UserSession
     */
    private $userSession;

    /**
     * @var object PanierModel
     */
    private $panierModel;

    
    public function __construct()
    {
        $this->userSession = new UserSession();
        $this->panierModel = new PanierModel();
    }

    /** ajouter un element au panier */
    public function panierAdd()
    {
        if(!$this->userSession->isAuthenticatedUser()){
            redirect("index.php?action=user&action2=loginForm");
        }
    
        $this->panierModel->addPanier($_GET['id']);
        require_once 'www/templates/panier/PanierView.phtml';
    }

    /** afficher resultat sur le tableau */
    public function panierOpen()
    {
        $session        = array_keys($_SESSION['panier']);
        $panier         = $this->panierModel->PanierView($session);
        $prix_total_ht  = $this->panierModel->prixHorsTaxe($session);
        $prix_total_TTC = $this->panierModel->prixTTC($session);
        $TVA            = $this->panierModel->TVA($session);
    
        require_once 'www/templates/panier/PanierView.phtml';  
    }

    /** effacer un article */
    public function deleteOneArticle()
    {
        $this->panierModel->deleteOne($_GET['id']);
        $this->panierOpen();
    } 
}