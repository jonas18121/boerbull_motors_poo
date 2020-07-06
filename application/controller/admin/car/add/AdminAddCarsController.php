<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/admin/car/add/AdminCarsModel.php';

//appel de la session
require_once 'aSession/AdminSession.php';

//appel d'un fichier dans la librairie
require_once 'library/Tools.php';


class AdminAddCarsController{


    private $adminSession;
    private $adminAddCarsModel;

    public function __construct()
    {
        // instance de session et de model
        $this->adminSession = new AdminSession();
        $this->adminAddCarsModel = new AdminCarsModel();
    }

    //en GET
    //affiche le formulaire d'ajout de voiture
    public function adminAddFormCars(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // cette fonction permet de choisir une categorie pour les voitures qu'on va ajouter dans la base de donnée
        $category = $this->adminAddCarsModel->category();

        //appel de la vue
        require_once 'www/templates/admin/car/add/AdminAddCarsView.phtml';
    } 


    //en POST
    //admin ajoute une voiture
    public function adminAddCars(){

        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        
        //controle de formulaire en php
        if(!empty($_POST)){ 
            if(array_key_exists('marque',$_POST) && isset($_POST['marque']) && strlen($_POST['marque']) >= 2 && strlen($_POST['marque']) <= 25){ 

                if(array_key_exists('modele',$_POST) && isset($_POST['modele']) && strlen($_POST['modele']) >= 2 && strlen($_POST['modele']) <= 35){

                    if(array_key_exists('annee',$_POST) && isset($_POST['annee']) && ctype_digit($_POST['annee']) && strlen($_POST['annee']) === 4){

                        if(array_key_exists('conso',$_POST) && isset($_POST['conso']) && ctype_digit($_POST['conso']) && strlen($_POST['conso']) < 4){

                            if(array_key_exists('color',$_POST) && isset($_POST['color']) && ctype_alpha($_POST['color'])){

                                if(array_key_exists('prix_trois_jours',$_POST) && isset($_POST['prix_trois_jours']) && ctype_digit($_POST['prix_trois_jours']) && strlen($_POST['prix_trois_jours']) < 5){

                                    if(array_key_exists('puissance',$_POST) && isset($_POST['puissance']) && ctype_digit($_POST['puissance']) && strlen($_POST['puissance']) < 5){

                                        if(array_key_exists('moteur',$_POST) && isset($_POST['moteur'])){

                                            if(array_key_exists('carburant',$_POST) && isset($_POST['carburant']) && ctype_alpha($_POST['carburant'])){

                                                if(array_key_exists('cent',$_POST) && isset($_POST['cent']) && ctype_digit($_POST['cent'])){

                                                    if(array_key_exists('nombre_de_place',$_POST) && isset($_POST['nombre_de_place']) && ctype_digit($_POST['nombre_de_place']) && strlen($_POST['nombre_de_place']) === 1){

                                                        if(array_key_exists('id_category',$_POST) && isset($_POST['id_category']) && ctype_digit($_POST['id_category']) && strlen($_POST['id_category']) === 1){

                                                            if(array_key_exists('image_url',$_POST) && isset($_POST['image_url'])){

                                                                $this->adminAddCarsModel->addCars($_POST['marque'], $_POST['modele'], $_POST['annee'], $_POST['conso'], $_POST['color'], $_POST['prix_trois_jours'], $_POST['puissance'], $_POST['moteur'], $_POST['carburant'], $_POST['cent'], $_POST['nombre_de_place'], $_POST['id_category'], $_POST['image_url']);

                                                                //on redirectionne l'admin vers la liste des users
                                                                redirect("index.php?action=admin&action2=car&action3=get");
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        redirect("index.php?action=admin&action2=car&action3=addForm");
    }
}