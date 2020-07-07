<?php
// forcer les erreurs si on a pas bien typé nos class
declare(strict_types=1);

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

class Routers{

    /** @var HomeController */
    private HomeController $HomeController;

    /** @var PanierController */
    private PanierController $PanierController;

    /** @var CarController */
    private CarController $carController;

    /** @var TarifController */
    private TarifController $tarifController;

    /** @var UserController */
    private UserController $userController;

    /** @var AdminController */
    private AdminController $adminController;

    /** @var AdminUsersController */
    private AdminUsersController $adminUsersController;

    /** @var AdminCarsController */
    private AdminCarsController $adminCarsController;

    /** @var AdminBookingController */
    private AdminBookingController $adminBookingController;

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


    /** 
     * dirige vers le bon controlleur
     */
    public function run()
    {
        try{
            if($_GET){
                if(isset($_GET['action']) && !empty($_GET['action'])){
                    if(array_key_exists('action', $_GET) && ctype_alpha($_GET['action'])){
                        //afficher l'acceuil
                        if($_GET['action'] === 'home')
                        {
                            $this->HomeController->getHome();//HomeController.php
                        }
                        //afficher les categories de voiture
                        elseif($_GET['action'] === 'category'){
                            if(array_key_exists('id_category', $_GET)){
                                if(isset($_GET['id_category']) && !empty($_GET['id_category'])){
                                    if(ctype_digit($_GET['id_category'])&& $_GET['id_category'] > 0)
                                    {
                                        $this->carController->getOneCategory();//CategoryController.php
                                    }else{
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
                                    if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                    {
                                        $this->carController->getOneCar();//CarController.php
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
                                    if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                    {
                                        $this->PanierController->panierAdd();// PanierController.php
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
                        elseif($_GET['action'] === 'panierView')
                        {
                            $this->PanierController->panierOpen();// PanierController.php
                        }
                        //connexion user // inscription user
                        elseif($_GET['action'] === 'user'){
                            if(array_key_exists('action2', $_GET)){
                                if(isset($_GET['action2']) && !empty($_GET['action2'])){
                                    //afficher un formulaire de connexion user
                                    if(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'loginForm')
                                    {
                                        $this->userController->userLoginForm(); // LoginController.php
                                    } 
                                    //connection user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'login')
                                    {  
                                        $this->userController->userLogin();//UserLoginFormController.php
                                    }
                                    //afficher un formulaire d'inscription user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'registerForm')
                                    {
                                        $this->userController->userRegisterForm();//UserRegisterFormController.php
                                    }
                                    //inscription user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'register')
                                    {  
                                        $this->userController->userRegister();// UserRegisterFormController.php
                                    }
                                    //logout user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'logout')
                                    {  
                                        $this->userController->userLougout();//UserLogoutController.php
                                    }
                                    // user supprime son compte
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'deleteUser'){
                                        if(array_key_exists('id', $_GET)){
                                            if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                { 
                                                    $this->userController->userDeleteSelf();//UserDeleteSelfController.php
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
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'bookingForm')
                                    {  
                                        $this->userController->bookingFormView();//UserBookingFormController.php
                                    }
                                    // RDV confirmer
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'booking')
                                    {  
                                        $this->userController->userBookingForm();//UserBookingFormController.php
                                    }
                                    // Afficher les rendez-vous de user
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'userRDV'){ 
                                        if(array_key_exists('user_i', $_GET)){
                                            if(isset($_GET['user_i']) && !empty($_GET['user_i'])){ 
                                                if(ctype_digit($_GET['user_i'])&& $_GET['user_i'] > 0)
                                                {     
                                                    $this->userController->getRDV();//UserBookingController.php
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
                                                if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                {     
                                                    $this->userController->deleteRDV();//UserBookingController.php
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
                                                if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                {    
                                                    $this->PanierController->deleteOneArticle();//PanierController.php
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
                        elseif ($_GET['action'] === 'tarif') 
                        {
                            $this->tarifController->getTarif();
                        }
                        // afficher le a propos de l'entreprise
                        elseif ($_GET['action'] === 'aPropos') 
                        {
                            getAPropos();
                        }
                        //connexion admin // inscription admin
                        elseif ($_GET['action'] === 'admin') {
                            if(array_key_exists('action2', $_GET)){
                                if(isset($_GET['action2']) && !empty($_GET['action2'])){
                                    //afficher un formulaire de connexion admin
                                    if(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'loginForm')
                                    {
                                        $this->adminController->adminLoginForm();//AdminLoginController.php
                                    }
                                    //connexion admin
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'loginAdmin')
                                    {  
                                        $this->adminController->adminLogin();// AdminLoginController.php
                                    }
                                    //afficher un formulaire d'inscription admin
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'registerForm')
                                    {
                                        $this->adminController->adminRegisterForm();//AdminRegisterController.php
                                    }
                                    //iscription admin
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'registerAdmin')
                                    {  
                                        $this->adminController->adminRegister();// AdminRegisterController.php
                                    }
                                    //déconnexion admin
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'logout')
                                    {  
                                        $this->adminController->adminLogout();// AdminLogoutController.php
                                    }
                                    //admin supprime son compte
                                    elseif(ctype_alpha($_GET['action2']) && $_GET['action2'] === 'deleteAdmin'){  
                                        if(array_key_exists('id', $_GET)){
                                            if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                { 
                                                    $this->adminController->adminDeleteSelf();// AdminDeleteSelfController.php
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
                                                if(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'addForm')
                                                {    
                                                    $this->adminUsersController->adminAddFormUsers();//AdminAddUserController.php
                                                }
                                                //admin ajoute users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'add')
                                                {
                                                    $this->adminUsersController->adminAddUsers();//AdminAddUserController.php
                                                }
                                                // afficher tous les users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'get'){
                                                    
                                                    $this->adminUsersController->adminGetUsers();//AdminGetUsersController.php
                                                }
                                                // afficher le formulaire pour modifier un users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'editForm'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                            {    
                                                                $this->adminUsersController->adminEditFormUsers();//AdminEditFromUsersController.php
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
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'edit')
                                                {    
                                                    $this->adminUsersController->adminEditUsers();//AdminEditFromUsersController.php
                                                }
                                                // admin supprime un users
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'delete'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                            {    
                                                                $this->adminUsersController->adminDeleteUsers();//AdminDeleteUsersController.php
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
                                                if(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'get')
                                                {    
                                                    $this->adminCarsController->adminGetCars();//AdminGetCarsController.php
                                                }
                                                //admin affiche un formulaire d'ajoute de cars
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'addForm')
                                                {    
                                                    $this->adminCarsController->adminAddFormCars();//AdminAddCarsController.php
                                                }
                                                //admin ajoute cars
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'add')
                                                {    
                                                    $this->adminCarsController->adminAddCars();//AdminAddCarsController.php
                                                }
                                                //admin supprime cars
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'delete'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                            {    
                                                                $this->adminCarsController->adminDeleteCars();//AdminDeleteCarsController.php
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
                                                            if(ctype_digit($_GET['id']) && $_GET['id'] > 0)
                                                            {    
                                                                $this->adminCarsController->adminEditFormCars();// AdminEditFormController.php
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
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'edit')
                                                {    
                                                    $this->adminCarsController->adminEditCars();// AdminEditController.php
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
                                                if(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'get')
                                                {
                                                    $this->adminBookingController->adminGetBooking();//AdminGetBookingController.php
                                                }
                                                //admin supprime un rendez-vous
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'delete'){
                                                    if(array_key_exists('id', $_GET)){
                                                        if(isset($_GET['id']) && !empty($_GET['id'])){ 
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                            {    
                                                                $this->adminBookingController->adminDeleteBooking();//AdminDeleteBookingController.php
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
                                                            if(ctype_digit($_GET['id'])&& $_GET['id'] > 0)
                                                            {    
                                                                $this->adminBookingController->adminBookingFormUser();//AdminBookingUserController.php
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
                                                elseif(ctype_alpha($_GET['action3']) && $_GET['action3'] === 'bookingAdd')
                                                {    
                                                    $this->adminBookingController->adminAddBookingUser();//AdminBookingUserController.php
                                              
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