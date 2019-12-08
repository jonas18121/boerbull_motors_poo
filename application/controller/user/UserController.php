<?php
//controlleur mettre en relation le model et la vue 

//appel du model
require_once 'model/user/UserModel.php';
require_once 'model/panier/NewPanierModel.php';
require_once 'model/car/CarModel.php';

//appel de la session
require_once 'aSession/UserSession.php';

//appel d'un fichier dans la librairie
require_once 'library/Tools.php';


class UserController{

    private $userSession;
    private $userModel;
    private $panierModel;
    private $carModel;

    public function __construct()
    {
        // instance de session et de model
        $this->userSession =    new UserSession();
        $this->userModel =      new UserModel();
        $this->panierModel =    new PanierModel();
        $this->carModel =       new CarModel();
    }


    /////////// register ////////////
    //en $_GET
    public function userRegisterForm(){
        //appel de la vue
        require_once 'www/templates/user/register/UserRegisterFormView.phtml';
    }

    //$_POST
    //A partir du routeur , il appelera notre function userRegisterFormOk()
    public function userRegister(){

        //controle de formulaire en php
        if(!empty($_POST)){
            if(array_key_exists('first_name',$_POST) && isset($_POST['first_name']) && ctype_alpha($_POST['first_name'])){
                if( strlen($_POST['first_name']) >= 2 && strlen($_POST['first_name']) <= 25){
                    if(array_key_exists('last_name',$_POST) && isset($_POST['last_name']) && ctype_alpha($_POST['first_name'])){
                        if(strlen($_POST['first_name']) >= 2 && strlen($_POST['first_name']) <= 25){
                            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                                    
                                        //si tous les controles sont bon
                                        //inscription user
                                        $this->userModel->registerUser($_POST['first_name'] , $_POST['last_name'], $_POST['mail'], $_POST['password']);

                                        //redirection à la page de connexion pour user 
                                        redirect('index.php?action=user&action2=loginForm');
                                    } 
                                }
                            }
                        }
                    }
                }
            } 
        }
    
        // s'il y a un controle qui n'est pas bon, on redirectionne à la page d' inscription pour user
        redirect('index.php?action=user&action2=registerForm');
    }





    /////////// login ////////////
     // en $_GET
     public function userLoginForm(){
        //appel de la vue
        require_once 'www/templates/user/login/UserLoginFormView.phtml';
    }

    // en $_POST
    //A partir du routeur , userLogin() appelera notre function loginUser()
    public function userLogin(){

        //controle de formulaire en php
        if(!empty($_POST)){
            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                        //connection user
                        $login = $this->userModel->loginUser($_POST['mail'], $_POST['password'] );
                    
                        //on crée la session
                        $this->userSession->create($login['id'], $login['first_name'], $login['last_name'], $login['mail']);

                        //redirection à la page d'accueil
                        redirect('index.php');

                    }else{
                        //si un controle n'est pas bon, redirection à la page de connexion
                        redirect('index.php?action=user&action2=loginForm'); 
                    }
                }else{
                    //si un controle n'est pas bon, redirection à la page de connexion
                    redirect('index.php?action=user&action2=loginForm'); 
                }
            }else{
                //si un controle n'est pas bon, redirection à la page de connexion
                redirect('index.php?action=user&action2=loginForm'); 
            }
        }
        //si un controle n'est pas bon, redirection à la page de connexion
        redirect('index.php?action=user&action2=loginForm'); 
    }




    /////////// logout ////////////
    //en $_GET
    public function userLougout(){

        //on appel userDestroy() qui est dans UserSession.php
        $this->userSession->userDestroy();

        //puis on ce redire vers l'accueil
        redirect('index.php');
    }



    /////////// delete ////////////

    //en $_GET
    //supprimer une voiture
    public function userDeleteSelf(){


        //si le admin n'est pas connecter au le renvois a l'accueil
        if(!$this->userSession->isAuthenticatedUser()){
            redirect("index.php");
        }

        // Avec $_GET, on recupère la valeur de l'id qui est dans l'url 
        $this->userModel->deleteSelfUser($_GET['id']);

        //on detruit la session de user
        $this->userSession->userDestroy();

        //on redirectionne vers l'accueil
        redirect("index.php");
    }



    /////////// bookingForm ////////////

    // en $_GET
    //A partir du routeur , bookingFormView() appelera les différente function 
    public function bookingFormView(){
        // On ne peut pas réserver sans être connecté !
        // sinon l'utilisateur sera renvoyer vers la page de connexion
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }

        $session = array_keys($_SESSION['panier']);//recupère le ou les clé qui son dans la session panier

        //$panierModel = new PanierModel();//instance de panier model
        $panier = $this->panierModel->PanierView($session); //appel de la fonction panierVie(), puis on le met dans la variable $panier
        $prix_total_TTC = $this->panierModel->prixTTC($session);

    
    
        if(!empty($session)){
            //appel de la fontion du model
            $oneCar = $this->carModel->OneCarBooking($session);
        }else {
            $oneCar = '';
        }

        //appel de la vue
        require_once 'www/templates/user/booking/BookingFormView.phtml';
    }




    //en POST
    //A partir du routeur , il appelera notre function userBookingForm()
    public function userBookingForm(){

        // On ne peut pas réserver sans être connecté !
        // sinon l'utilisateur sera renvoyer vers la page de connexion
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }

        if(!empty($_POST)){
            if(array_key_exists('id',$_POST) && isset($_POST['id']) && ctype_digit($_POST['id'])){ 
                if(array_key_exists('user_i',$_POST) && isset($_POST['user_i']) && ctype_digit($_POST['user_i'])){ 
                    if(array_key_exists('numberOfSeats',$_POST) && isset($_POST['numberOfSeats']) && ctype_digit($_POST['numberOfSeats'])){ 
                        if(array_key_exists('datetimepicker',$_POST) && isset($_POST['datetimepicker'])){  
                            if(array_key_exists('datetimepicker2',$_POST) && isset($_POST['datetimepicker2'])){ 

                                //récupération du compte client de l'utilisateur connecté
                                //$userId = getUserId();
                                $userId = $_POST['user_i'];

                                //récupération id de ou des voitures selectionner
                                $car_id = $_POST['id'];


                                //Récupéré la date de debut jusqu'a 10 caractères, EX : 2019-06-21
                                $dateDebut = new DateTime(date(substr($_POST['datetimepicker'], 0, 10)));

                                //récupéré les heures qui s'ajoutera après la date et s'affichera au 11èmes caractères 
                                $hourDebut = substr($_POST['datetimepicker'],11);

                            


                                //Récupéré la date de fin jusqu'a 10 caractères, EX : 2019-06-21
                                $dateFin = new DateTime(date(substr($_POST['datetimepicker2'], 0, 10)));

                                //récupéré les heures qui s'ajoutera après la date et s'affichera au 11èmes caractères 
                                $hourFin = substr($_POST['datetimepicker2'],11);



                                //création de la reservation
                                $this->userModel->addBooking($userId, $dateDebut->format('Y-m-d'), $hourDebut, $dateFin->format('Y-m-d'), $hourFin, $_POST['numberOfSeats'], $car_id);

                            

                                //$panierModel = new PanierModel(); 
                                $this->panierModel->deleteAll();


                                //redirection vers la page d'accueil
                                redirect('index.php');
                            }
                        }
                    }
                }
            }
            redirect('index.php?action=user&action2=bookingForm&id='.  $_POST['id'] );
        }
        //redirection vers la page d'accueil
        redirect('index.php');
    }




    /////////// booking ////////////

    //en $_GET
    //afficher les RDV
    public function getRDV(){

        // On ne peut pas afficher les réservations sans être connecté !
        // sinon l'utilisateur sera renvoyer vers la page de connexion
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }

        //pour éviter que la session de l'utilisateur en cours, ait accès au RDV des autres utilisateurs   
        if(isset($_GET['user_i']) && $_GET['user_i'] ===  $_SESSION['user']['id'] ){
    
            $getBooking = $this->userModel->getBooking($_GET['user_i']);

            //appel de la vue
            require_once 'www/templates/user/booking/BookingView.phtml';
        }

        // si $_GET['user_i'] est différent , 
        //on remet $_SESSION['user']['id'] dans $_GET['user_i'] pour afficher le bon resultat
        $_GET['user_i'] = $_SESSION['user']['id'];
        $getBooking = $this->userModel->getBooking($_GET['user_i']);


        //appel de la vue
        require_once 'www/templates/user/booking/BookingView.phtml';
    }



    //en $_GET
    //effacer un RDV
    public function deleteRDV(){
        // On ne peut pas effacer les réservations sans être connecté !
        // sinon l'utilisateur sera renvoyer vers la page de connexion
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }
    
        $this->userModel->deleteBooking($_GET['id']);

        redirect('index.php?action=user&action2=userRDV&user_i='. $this->userSession->getUserId());
    }
}