<?php
//controlleur mettre en relation le model et la vue 

//appel du model
include_once 'model/panier/NewPanierModel.php';
require_once 'model/oneCar/OneCarModel.php';

//appel dans la librairie
include_once 'library/Tools.php';

//appel de la session
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
        // instance de session et de model
        $this->userSession = new UserSession();
        $this->panierModel = new PanierModel();
    }

    //A partir du routeur , il appelera notre function panierAdd()
    public function panierAdd(){

        if(!$this->userSession->isAuthenticatedUser()){
            redirect("index.php?action=user&action2=loginForm");
        }
    
        //appel des fontions du model
        $this->panierModel->addPanier($_GET['id']);

        //appel de la vue
        require_once 'www/templates/panier/PanierView.phtml';
    }



    //A partir du routeur , il appelera notre function panierOpen()
    public function panierOpen(){
    
         
        //appel des fontions du model
        //avec array_keys() on recupère les clefs des voitures qui sont dans le panier et le retourne en tableau
        $session = array_keys($_SESSION['panier']);

        //selectionne
        $panier = $this->panierModel->PanierView($session);
        $prix_total_ht = $this->panierModel->prixHorsTaxe($session);
        $prix_total_TTC = $this->panierModel->prixTTC($session);
        $TVA = $this->panierModel->TVA($session);
    
        //appel de la vue
        require_once 'www/templates/panier/PanierView.phtml';  
    }



    public function deleteOneArticle(){

        $this->panierModel->deleteOne($_GET['id']);

        $this->panierOpen();
    } 
}


        //avec array_keys() on recupère les clefs des voitures qui sont dans le panier et le retourne en tableau
        //$session = array_keys($_SESSION['panier']);

        //$panier = $this->panierModel->PanierView($session);
        //$prix_total_ht = $this->panierModel->prixHorsTaxe($session);
        //$prix_total_TTC = $this->panierModel->prixTTC($session);
        //$TVA = $this->panierModel->TVA($session);

        //redirect('index.php?action=panierView');