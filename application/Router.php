<?php
// le routeur
///////// inclure les controlleurs ///////////
require_once 'controller/HomeController.php';                           //HOME//
require_once 'controller/car/CarController.php';                        //CAR//
require_once 'controller/panier/PanierController.php';                  //PANIER//
require_once 'controller/tarif/TarifController.php';                    //TARIF//
require_once 'controller/aPropos/AProposController.php';                //A PROPOS//
require_once 'controller/user/UserController.php';                      /////USER/////
require_once 'controller/admin/AdminController.php';                    /////ADMIN/////
require_once 'controller/admin/users/AdminUsersController.php';         //Admin > User //
require_once 'controller/admin/car/AdminCarsController.php';            //Admin > Car //
require_once 'controller/admin/booking/AdminBookingController.php';     //Admin > Booking //

class Router{

    private $HomeController;
    private $PanierController;
    private $carController;
    private $tarifController;
    private $userController;
    private $adminController;
    private $adminUsersController;
    private $adminCarsController;
    private $adminBookingController;

    public function __construct()
    {
        $this->HomeController =         new HomeController();
        $this->PanierController =       new PanierController();
        $this->carController =          new CarController();
        $this->tarifController =        new TarifController();
        $this->userController =         new UserController();
        $this->adminController =        new AdminController();
        $this->adminUsersController =   new AdminUsersController();
        $this->adminCarsController =    new AdminCarsController();
        $this->adminBookingController = new AdminBookingController();
    }

    public function starter()
    {
        /*
        récupéré la methode 
        */
        
    }


    public function run(){
        try{// le bloc try catch sevira pour renvoyer les erreurs, s'il y en a 
            if($_GET){
                if(isset($_GET['action']) && !empty($_GET['action'])){
                    if(array_key_exists('action', $_GET) && ctype_alpha($_GET['action'])){
                        //afficher l'acceuil
                        if($_GET['action'] === 'home'){
                            //si tous les controles sont réussi , on appel getHome() qui est dans HomeController.php
                            $this->HomeController->getHome();
                        }
                        //afficher les categories de voiture
                        elseif($_GET['action'] === 'category'){
                            if(array_key_exists('id_category', $_GET)){
                                if(isset($_GET['id_category']) && !empty($_GET['id_category'])){
                                    if(ctype_digit($_GET['id_category'])&& $_GET['id_category'] > 0){
                                        //si tous les controles sont réussi , on appel getOneCategory() qui est dans CategoryController.php
                                        $this->carController->getOneCategory();
                                    }else{
                                        //ont lance une erreur, s'il a pas de id_category
                                        throw new Exception("Erreur : Tous les champs ne sont pas rempli !"); 
                                    }
                                }else{
                                    $this->HomeController->getHome();
                                }
                           }else{
                                $this->HomeController->getHome();
                            }
                        }
                        //afficher une seule voiture
                        elseif($_GET['action'] === 'oneCar'){
                            if(array_key_exists('id', $_GET)){
                                if(isset($_GET['id']) && !empty($_GET['id'])){
                                    if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){
                                        //si tous les controles sont réussi , on appel getOneCar() qui est dans CarController.php
                                        $this->carController->getOneCar();
                                    }else{
                                        //ont lance une erreur, s'il a pas de id_category
                                        throw new Exception("Erreur : Tous les champs ne sont pas rempli !"); 
                                    }
                                }else{
                                    $this->HomeController->getHome();
                                }
                            }else{
                                $this->HomeController->getHome();
                            }
                        }
                        //ajouter un element dans le panier et afficher ce qu'il y a dans le panier
                        elseif($_GET['action'] === 'panier'){
                            if(array_key_exists('id', $_GET)){
                                if(isset($_GET['id']) && !empty($_GET['id'])){
                                    if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){
                                        //si tous les controles sont réussi , on appel panierAdd() qui est dans PanierController.php
                                        $this->PanierController->panierAdd();

                                    }else{
                                        $this->HomeController->getHome();
                                    }
                                }else{
                                    $this->HomeController->getHome();
                                }
                            }else{
                                $this->HomeController->getHome();
                            }
                        }
                        //afficher ce qu'il y a dans le panier
                        elseif($_GET['action'] === 'panierView'){
                            //si tous les controles sont réussi , on appel PanierView() qui est dans PanierController.php
                            $this->PanierController->panierOpen();
                        }
                        //connexion user // inscription user
                        elseif($_GET['action'] === 'user'){
                            if(array_key_exists('action2', $_GET)){
                                if(isset($_GET['action2']) && !empty($_GET['action2'])){
                                    //afficher un formulaire de connexion user
                                    if(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'loginForm'){
                                        //si tous les controles sont réussi , on appel userLoginForm() qui est dans LoginController.php
                                        $this->userController->userLoginForm();
                                    } 
                                    //connection user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'login'){  
                                        //si tous les controles sont réussi , on appel userLoginFormOk() qui est dans UserLoginFormController.php
                                        $this->userController->userLogin();
                                    }
                                    //afficher un formulaire d'inscription user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'registerForm'){
                                        //si tous les controles sont réussi , on appel  userRegisterForm() qui est dans UserRegisterFormController.php                        
                                        $this->userController->userRegisterForm();
                                    }
                                    //inscription user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'register'){  
                                        //si tous les controles sont réussi , on appel userRegisterFormOk() qui est dans UserRegisterFormController.php
                                        $this->userController->userRegister();
                                    }
                                    //logout user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'logout'){  
                                        //si tous les controles sont réussi , on appel  userLougout() qui est dans UserLogoutController.php
                                        $this->userController->userLougout();
                                    }
                                    // user supprime son compte
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'deleteUser'){
                                        if(array_key_exists('id', $_GET)){
                                            if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){ 
                                                    //si tous les controles sont réussi , on appel  userDeleteSelf() qui est dans UserDeleteSelfController.php
                                                    $this->userController->userDeleteSelf();
                                                }else{
                                                    $this->HomeController->getHome();
                                                }
                                            }else{
                                                $this->HomeController->getHome();
                                            }
                                        }else{
                                            $this->HomeController->getHome();
                                        }
                                    }
                                    //prendre un RDV , affiche form
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'bookingForm'){  
                                        //si tous les controles sont réussi , on appel userBookingForm() qui est dans UserBookingFormController.php
                                        $this->userController->bookingFormView();
                                    }
                                    // RDV confirmer
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'booking'){  
                                        //si tous les controles sont réussi , on appel userBookingForm() qui est dans UserBookingFormController.php
                                        $this->userController->userBookingForm();
                                    }
                                    // Afficher les rendez-vous de user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'userRDV'){ 
                                        if(array_key_exists('user_i', $_GET)){
                                            if(isset($_GET['user_i']) && !empty($_GET['user_i'])){ 
                                                if(ctype_digit($_GET['user_i'])&& $_GET['user_i'] > 0){ 
                                                    //si tous les controles sont réussi , on appel getRDV() qui est dans UserBookingController.php
                                                    $this->userController->getRDV();
                                                }else{
                                                    $this->HomeController->getHome();
                                                }
                                            }else{
                                                $this->HomeController->getHome();
                                            }
                                        }else{
                                            $this->HomeController->getHome();
                                        }
                                    }
                                    // user effacer un rendez-vous
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'deleteOneBooking'){ 
                                        if(array_key_exists('id', $_GET)){
                                            if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){ 
                                                    //si tous les controles sont réussi , on appel getRDV() qui est dans UserBookingController.php
                                                    $this->userController->deleteRDV();
                                                }else{
                                                    $this->HomeController->getHome();
                                                }
                                            }else{
                                                $this->HomeController->getHome();
                                            }
                                        }else{
                                            $this->HomeController->getHome();
                                        }
                                    }
                                    // effacer un article dans le panier 
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'deleteOneArticle'){ 
                                        if(array_key_exists('id', $_GET)){
                                            if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){
                                                    //si tous les controles sont réussi , on appel deleteOneArticle() qui est dans PanierController.php
                                                    $this->PanierController->deleteOneArticle();
                                                }else{
                                                    $this->HomeController->getHome();
                                                }
                                            }else{
                                                $this->HomeController->getHome();
                                            }
                                        }else{
                                            $this->HomeController->getHome();
                                        }
                                    }else{
                                        $this->HomeController->getHome();
                                    } 
                                }
                                else{
                                    $this->HomeController->getHome();
                                }
                            }
                            else{
                                $this->HomeController->getHome();
                            }
                        }
                        // afficher le tarif de toute les voitures
                        elseif ($_GET['action'] === 'tarif') {
                            $this->tarifController->getTarif();
                        }
                        // afficher le a propos de l'entreprise
                        elseif ($_GET['action'] === 'aPropos') {
                            getAPropos();
                        }
                        //connexion admin // inscription admin
                        elseif ($_GET['action'] === 'admin') {
                            if(array_key_exists('action2', $_GET)){
                                if(isset($_GET['action2']) && !empty($_GET['action2'])){
                                    //afficher un formulaire de connexion admin
                                    if(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'loginForm'){
                                        //si tous les controles sont réussi , on appel loginFormView() qui est dans AdminLoginController.php
                                        $this->adminController->adminLoginForm();
                                    }
                                    //connexion admin
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'loginAdmin'){  
                                        //si tous les controles sont réussi , on appel adminLogin() qui est dans AdminLoginController.php
                                        $this->adminController->adminLogin();
                                    }
                                    //afficher un formulaire d'inscription admin
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'registerForm'){
                                        //si tous les controles sont réussi , on appel adminRegisterForm() qui est dans AdminRegisterController.php
                                        $this->adminController->adminRegisterForm();
                                    }
                                    //iscription admin
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'registerAdmin'){  
                                        //si tous les controles sont réussi , on appel adminRegister() qui est dans AdminRegisterController.php
                                        $this->adminController->adminRegister();
                                    }
                                    //déconnexion admin
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'logout'){  
                                        //si tous les controles sont réussi , on appel adminLogout() qui est dans AdminLogoutController.php
                                        $this->adminController->adminLogout();
                                    }
                                    //admin supprime son compte
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'deleteAdmin'){  
                                        if(array_key_exists('id', $_GET)){
                                            if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){ 
                                                    //si tous les controles sont réussi , on appel adminDelete() qui est dans AdminDeleteSelfController.php
                                                    $this->adminController->adminDeleteSelf();
                                                }else{
                                                    $this->HomeController->getHome();
                                                }
                                            }else{
                                                $this->HomeController->getHome();
                                            }
                                        }else{
                                            $this->HomeController->getHome();
                                        }
                                    }
                                    //admin CRUD user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'users'){  
                                        if(array_key_exists('action3', $_GET)){
                                            if(isset($_GET['action3']) && !empty($_GET['action3'])){
                                                //admin affiche un formulaire d'ajoute de users
                                                if(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'addForm'){
                                                    //si tous les controles sont réussi , on appel adminAddFormUsers() qui est dans AdminAddUserController.php
                                                    $this->adminUsersController->adminAddFormUsers();
                                                }
                                                //admin ajoute users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'add'){
                                                    //si tous les controles sont réussi , on appel adminAddUsers() qui est dans AdminAddUserController.php
                                                    $this->adminUsersController->adminAddUsers();
                                                }
                                                // afficher tous les users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'get'){
                                                    //si tous les controles sont réussi , on appel adminGetUsers() qui est dans AdminGetUsersController.php
                                                    $this->adminUsersController->adminGetUsers();
                                                }
                                                // afficher le formulaire pour modifier un users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'editForm'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){
                                                                //si tous les controles sont réussi , on appel adminEditFromUsers() qui est dans AdminEditFromUsersController.php
                                                                $this->adminUsersController->adminEditFormUsers();
                                                            }else{
                                                                $this->HomeController->getHome();
                                                            }
                                                        }else{
                                                            $this->HomeController->getHome();
                                                        }
                                                    }else{
                                                        $this->HomeController->getHome();
                                                    }
                                                }
                                                // admin modifie un users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'edit'){
                                                    //si tous les controles sont réussi , on appel adminEditUsers() qui est dans AdminEditFromUsersController.php
                                                    $this->adminUsersController->adminEditUsers();
                                                }
                                                // admin supprime un users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'delete'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){
                                                                //si tous les controles sont réussi , on appel adminDeleteUsers() qui est dans AdminDeleteUsersController.php
                                                                $this->adminUsersController->adminDeleteUsers();
                                                            }else{
                                                                $this->HomeController->getHome();
                                                            }
                                                        }else{
                                                            $this->HomeController->getHome();
                                                        }
                                                    }else{
                                                        $this->HomeController->getHome();
                                                    }
                                                }else{
                                                    $this->HomeController->getHome();
                                                }
                                            }else{
                                                $this->HomeController->getHome();
                                            }
                                        }else{
                                            $this->HomeController->getHome();
                                        }   
                                    }
                                    //admin CRUD car
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'car'){
                                        if(array_key_exists('action3', $_GET)){
                                            if(isset($_GET['action3']) && !empty($_GET['action3'])){
                                                //admin affiche tous les voitures
                                                if(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'get'){
                                                    //si tous les controles sont réussi , on appel adminGetCars() qui est dans AdminGetCarsController.php
                                                    $this->adminCarsController->adminGetCars();
                                                }
                                                //admin affiche un formulaire d'ajoute de cars
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'addForm'){
                                                    //si tous les controles sont réussi , on appel adminAddFormCars() qui est dans AdminAddCarsController.php
                                                    $this->adminCarsController->adminAddFormCars();
                                                }
                                                //admin ajoute cars
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'add'){
                                                    //si tous les controles sont réussi , on appel adminAddCars() qui est dans AdminAddCarsController.php
                                                    $this->adminCarsController->adminAddCars();
                                                }
                                                //admin supprime cars
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'delete'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){
                                                                //si tous les controles sont réussi , on appel adminDeleteCars() qui est dans AdminDeleteCarsController.php
                                                                $this->adminCarsController->adminDeleteCars();
                                                            }else{
                                                                $this->HomeController->getHome();
                                                            }
                                                        }else{
                                                            $this->HomeController->getHome();
                                                        }
                                                    }else{
                                                        $this->HomeController->getHome();
                                                    }
                                                }
                                                //admin affiche un formulaire pour modifier un car
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'editForm'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id']) && $_GET['id'] > 0){
                                                                //si tous les controles sont réussi , on appel adminEditFormCars() qui est dans AdminEditFormController.php
                                                                $this->adminCarsController->adminEditFormCars();
                                                            }else{
                                                                $this->HomeController->getHome();
                                                            }
                                                        }else{
                                                            $this->HomeController->getHome();
                                                        }
                                                    }else{
                                                        $this->HomeController->getHome();
                                                    }
                                                }
                                                //admin  modifier un car
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'edit'){
                                                    //si tous les controles sont réussi , on appel adminEditCars() qui est dans AdminEditController.php
                                                    $this->adminCarsController->adminEditCars();
                                                }else{
                                                    $this->HomeController->getHome();
                                                }
                                            }else{
                                                $this->HomeController->getHome();
                                            }
                                        }else{
                                            $this->HomeController->getHome();
                                        }
                                    }
                                    //admin CRUD booking
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'booking'){
                                        if(array_key_exists('action3', $_GET)){
                                            if(isset($_GET['action3']) && !empty($_GET['action3'])){
                                                //admin affiche tous les rendez-vous
                                                if(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'get'){
                                                    //si tous les controles sont réussi , on appel adminGetBooking() qui est dans AdminGetBookingController.php
                                                    $this->adminBookingController->adminGetBooking();
                                                }
                                                //admin supprime un rendez-vous
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'delete'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){
                                                                //si tous les controles sont réussi , on appel adminDeleteBooking() qui est dans AdminDeleteBookingController.php
                                                                $this->adminBookingController->adminDeleteBooking();
                                                            }
                                                            else{
                                                                $this->HomeController->getHome();
                                                            }
                                                        }else{
                                                            $this->HomeController->getHome();
                                                        }
                                                    }else{
                                                        $this->HomeController->getHome();
                                                    }
                                                }
                                                // admin affiche formulaire du booking pour pouvoir ajouter un RDV
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'bookingForm'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0){
                                                                //si tous les controles sont réussi , on appel adminBookingFormUser() qui est dans AdminBookingUserController.php
                                                                $this->adminBookingController->adminBookingFormUser();
                                                            }else{
                                                                $this->HomeController->getHome();
                                                            }
                                                        }else{
                                                            $this->HomeController->getHome();
                                                        }
                                                    }else{
                                                        $this->HomeController->getHome();
                                                    }       
                                                }
                                                // admin ajoute un RDV pour un user
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'bookingAdd'){
                                                    //si tous les controles sont réussi , on appel adminBookingUser() qui est dans AdminBookingUserController.php
                                                    $this->adminBookingController->adminAddBookingUser();
                                              
                                                }else{
                                                    $this->HomeController->getHome();
                                                }
                                            }else{
                                                $this->HomeController->getHome();
                                            }
                                        }else{
                                            $this->HomeController->getHome();
                                        }
                                    }else{
                                        $this->HomeController->getHome();
                                    }
                                }else{
                                    $this->HomeController->getHome();
                                }
                            }else{
                                $this->HomeController->getHome();
                            }
                        }else{
                            $this->HomeController->getHome();
                        }
                    }else{
                        $this->HomeController->getHome();
                    }
                }else{
                    $this->HomeController->getHome();
                }
            }else{
                // on appel par defaut,  getHome() qui est dans HomeController.php
                $this->HomeController->getHome();
            }
        }catch(Exception $e){
            $errorMessage = $e->getMessage();
            require_once 'www/templates/ErrorView.phtml';
        }
    }
}