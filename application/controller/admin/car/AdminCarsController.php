<?php

declare(strict_types=1);

require_once 'model/admin/car/AdminCarsModel.php';

class AdminCarsController extends AdminController{

    /** @var AdminCarsModel */
    private AdminCarsModel $adminCarsModel;

    public function __construct()
    {
        parent::__construct();
        $this->adminCarsModel = new AdminCarsModel();
    }


            //// Afficher //// 
    /**
     * En GET, afficher une voiture
     *
     * @return void
     */
    public function adminGetCars() : void
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }
    
        $adminGetCars = $this->adminCarsModel->GetCars();
        require_once 'www/templates/admin/car/get/AdminGetCarsView.phtml';
    }


            //// Ajouter ////
    /**
     * En GET, affiche le formulaire d'ajout de voiture
     *
     * @return void
     */
    public function adminAddFormCars() : void
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // cette fonction permet de choisir une categorie pour les voitures qu'on va ajouter dans la base de donnée
        $category = $this->adminCarsModel->category();
        require_once 'www/templates/admin/car/add/AdminAddCarsView.phtml';
    } 

    /**
     * En POST, admin ajoute une voiture
     *
     * @return void
     */
    public function adminAddCars() : void
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

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
                                                                
                                                                $this->adminCarsModel->addCars($_POST['marque'], $_POST['modele'], (int) $_POST['annee'], (int) $_POST['conso'], $_POST['color'], (int) $_POST['prix_trois_jours'], (int) $_POST['puissance'], $_POST['moteur'], $_POST['carburant'], (int) $_POST['cent'], (int) $_POST['nombre_de_place'], (int) $_POST['id_category'], $_POST['image_url']);

                                                                redirect("index.php?action=admin&action2=car&action3=get");//on redirectionne l'admin vers la liste des users
                                                            }
                                                            redirect("index.php?action=admin&action2=car&action3=addForm");
                                                        }
                                                        redirect("index.php?action=admin&action2=car&action3=addForm");
                                                    }
                                                    redirect("index.php?action=admin&action2=car&action3=addForm");
                                                }
                                                redirect("index.php?action=admin&action2=car&action3=addForm");
                                            }
                                            redirect("index.php?action=admin&action2=car&action3=addForm");
                                        }
                                        redirect("index.php?action=admin&action2=car&action3=addForm");
                                    }
                                    redirect("index.php?action=admin&action2=car&action3=addForm");
                                }
                                redirect("index.php?action=admin&action2=car&action3=addForm");
                            }
                            redirect("index.php?action=admin&action2=car&action3=addForm");
                        }
                        redirect("index.php?action=admin&action2=car&action3=addForm");
                    }
                    redirect("index.php?action=admin&action2=car&action3=addForm");
                }
                redirect("index.php?action=admin&action2=car&action3=addForm");
            }
            redirect("index.php?action=admin&action2=car&action3=addForm");
        }
        redirect("index.php?action=admin&action2=car&action3=addForm");
    }

                //// Modifier ////  
    /**
     * En GET, affiche le formulaire de modification de car
     *
     * @return void
     */
    public function adminEditFormCars() : void
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $adminEditFormCars = $this->adminCarsModel->editFormCars((int) $_GET['id']);
        require_once 'www/templates/admin/car/edit/AdminEditCarsView.phtml';
    } 


    /**
     * En POST, admin modifie une voiture
     *
     * @return void
     */
    public function adminEditCars() : void
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        if(!empty($_POST)){
            if(array_key_exists('id',$_POST) && isset($_POST['id']) && ctype_digit($_POST['id'])){ 
                if(array_key_exists('marque',$_POST) && isset($_POST['marque']) && strlen($_POST['marque']) >= 2 && strlen($_POST['marque']) <= 25){ //var_dump($_POST);die;
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
                                                        
                                                                $this->adminCarsModel->editCars($_POST['marque'], $_POST['modele'], (int) $_POST['annee'], (int) $_POST['conso'], $_POST['color'], (int) $_POST['prix_trois_jours'], (int) $_POST['puissance'], $_POST['moteur'], $_POST['carburant'], (int)$_POST['cent'], (int)$_POST['nombre_de_place'], (int)$_POST['id_category'], (int) $_POST['id']);

                                                                //on redirectionne l'admin vers la liste des users
                                                                redirect("index.php?action=admin&action2=car&action3=get");
                                                            }
                                                            redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                                                        }
                                                        redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                                                    }
                                                    redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                                                }
                                                redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                                            }
                                            redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                                        }
                                        redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                                    }
                                    redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                                }
                                redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                            }
                            redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                        }
                        redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                    }
                    redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
                }
                redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
            }
            redirect('index.php?action=admin&action2=car&action3=editForm&id=' . $_POST['id']);
        }
        //on redirectionne l'admin vers la liste des users
        redirect("index.php?action=admin&action2=car&action3=get");
    }  


                //// Supprimer ////
    /**
     * En $_GET, supprimer une voiture
     *
     * @return void
     */
    public function adminDeleteCars() : void
    {
        if(!$this->adminSession->isAuthenticatedAdmin()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $this->adminCarsModel->deleteCar((int) $_GET['id']);

        redirect("index.php?action=admin&action2=car&action3=get");
    }
}