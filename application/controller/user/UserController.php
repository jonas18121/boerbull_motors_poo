<?php

declare(strict_types=1);

require_once 'library/Tools.php';
require_once 'model/user/UserModel.php';
require_once 'model/panier/PanierModel.php';
require_once 'model/car/CarModel.php';
require_once 'aSession/UserSession.php';
require_once 'aSession/MessageFlashSession.php';


class UserController{

    /** @var MessageFlashSession */
    private MessageFlashSession $messageFlashSession;

    /** @var UserSession */
    private UserSession $userSession;

    /** @var UserModel */
    private UserModel $userModel;

    /** @var PanierModel */
    private PanierModel $panierModel;

    /** @var CarModel */
    private CarModel $carModel;

    public function __construct()
    {
        $this->userSession  = new UserSession();
        $this->userModel    = new UserModel();
        $this->panierModel  = new PanierModel();
        $this->carModel     = new CarModel();
        $this->messageFlashSession  = new MessageFlashSession();
    }


    /////////// register ////////////

    /** en $_GET, afficher le formulaire d'inscription
     * 
     * @return void
     */
    public function userRegisterForm() : void
    {
        require_once 'www/templates/user/register/UserRegisterFormView.phtml';
    }

    /** 
     * en $_POST, Permettre l'inscription si les controlles sont bons
     * 
     * @return void
     */
    public function userRegister() : void
    {
        if(!empty($_POST)){
            if(array_key_exists('first_name',$_POST) && isset($_POST['first_name']) && ctype_alpha($_POST['first_name'])){
                if( strlen($_POST['first_name']) >= 2 && strlen($_POST['first_name']) <= 25){
                    if(array_key_exists('last_name',$_POST) && isset($_POST['last_name']) && ctype_alpha($_POST['first_name'])){
                        if(strlen($_POST['first_name']) >= 2 && strlen($_POST['first_name']) <= 25){
                            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail'])){

                                        $this->userModel->registerUser($_POST['first_name'] , $_POST['last_name'], $_POST['mail'], $_POST['password']);

                                        //redirection à la page de connexion pour user 
                                        redirect('index.php?action=user&action2=loginForm');
                                    } 
                                    redirect('index.php?action=user&action2=registerForm');
                                }
                                redirect('index.php?action=user&action2=registerForm');
                            }
                            redirect('index.php?action=user&action2=registerForm');
                        }
                        redirect('index.php?action=user&action2=registerForm');
                    }
                    redirect('index.php?action=user&action2=registerForm');
                }
                redirect('index.php?action=user&action2=registerForm');
            } 
            redirect('index.php?action=user&action2=registerForm');
        }
        redirect('index.php?action=user&action2=registerForm');
    }


    /////////// login ////////////

     /** 
      * en $_GET, afficher le formulaire de connection
      *
      *  @return void
      */
    public function userLoginForm() : void
    {
        require_once 'www/templates/user/login/UserLoginFormView.phtml';
    }

    /** 
     * en $_POST, Permettre la connexion si les controlles sont bons
     * 
     * @return void
     */
    public function userLogin() : void
    {
        if(!empty($_POST)){
            if(array_key_exists('password',$_POST) && isset($_POST['password']) && strlen($_POST['password']) >= 8){
                if(array_key_exists('mail',$_POST) && isset($_POST['mail'])){
                    if(preg_match("/^[a-zA-Z][a-zA-Z0-9._-]{1,19}@[a-z]{4,7}\.[a-z]{2,3}$/", $_POST['mail']))
                    {
                        $login = $this->userModel->loginUser($_POST['mail'], $_POST['password'] );//connection user
                    
                        $this->userSession->create((int)$login['id'], $login['first_name'], $login['last_name'], $login['mail']);//on crée la session

                        redirect('index.php');//redirection à la page d'accueil
                    }
                    throw new PDOException('Le mail n\'est pas bien écrit ');
                    // redirect('index.php?action=user&action2=loginForm'); 
                }
                throw new PDOException('Le mail ou le mot de passe est incorrect');
                //redirect('index.php?action=user&action2=loginForm'); 
            }
            $this->messageFlashSession->setFlash('red', 'Le mot de passe ou le mail est incorrect');
            //throw new PDOException('Le mot de passe ou le mail est incorrect');
            // redirect('index.php?action=user&action2=loginForm');
        }
        redirect('index.php?action=user&action2=loginForm'); 
    }

    /////////// logout ////////////

    /** en $_GET
     * deconnexion de l'utilisateur
     * 
     * @return void
     */
    public function userLougout() : void
    {
        $this->userSession->userDestroy();
        redirect('index.php');
    }



    /////////// delete ////////////

    /** en $_GET, l'utilisateur supprime son compte
     * 
     * @return void
     */
    public function userDeleteSelf() : void
    {
        if(!$this->userSession->isAuthenticatedUser())
        {
            redirect("index.php");
        }
        $this->userModel->deleteSelfUser((int)$_GET['id']);
        $this->userSession->userDestroy();//on detruit la session de user
        redirect("index.php?action=user&action2=registerForm");//on redirectionne vers la page d' inscrition
    }



    /////////// bookingForm ////////////

    /** en $_GET, Afficher le formulaire de réservation
     * 
     * @return void
     */
    public function bookingFormView() : void
    {
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }

        $session = array_keys($_SESSION['panier']);//recupère le ou les clé qui son dans la session panier
        $panier = $this->panierModel->PanierView($session);
        $prix_total_TTC = $this->panierModel->prixTTC($session);

        if(!empty($session))
        {
            $oneCar = $this->carModel->OneCarBooking($session);
        }else {
            $oneCar = '';
        }
        require_once 'www/templates/user/booking/BookingFormView.phtml';
    }

    /** 
     * en POST, l'utilisateur fait une reservation
     * 
     * @return void
     */
    public function userBookingForm() : void
    {
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }

        if(!empty($_POST)){
            if(array_key_exists('id',$_POST) && isset($_POST['id']) && ctype_digit($_POST['id'])){ 
                if(array_key_exists('user_i',$_POST) && isset($_POST['user_i']) && ctype_digit($_POST['user_i'])){ 
                    if(array_key_exists('numberOfSeats',$_POST) && isset($_POST['numberOfSeats']) && ctype_digit($_POST['numberOfSeats'])){ 
                        if(array_key_exists('datetimepicker',$_POST) && isset($_POST['datetimepicker'])){  
                            if(array_key_exists('datetimepicker2',$_POST) && isset($_POST['datetimepicker2']))
                            { 
                                $userId = $_POST['user_i'];// récupération du client
                                $car_id = $_POST['id'];//récupération id de ou des voitures selectionner



                                //Récupéré la date de debut jusqu'a 10 caractères, EX : 2019-06-21
                                // $dateDebut = new DateTime(date(substr($_POST['datetimepicker'], 0, 10)));
                                $dateDebut = DateTime::createFromFormat('d/m/Y', date(substr($_POST['datetimepicker'], 0, 10)));

                                //récupéré les heures qui s'ajouteront après la date et s'affichera au 11èmes caractères 
                                $hourDebut = substr($_POST['datetimepicker'],11);




                                //Récupéré la date de fin jusqu'a 10 caractères, EX : 2019-06-21
                                // $dateFin = new DateTime(date(substr($_POST['datetimepicker2'], 0, 10)));
                                $dateFin = DateTime::createFromFormat('d/m/Y', date(substr($_POST['datetimepicker2'], 0, 10)));

                                //récupéré les heures qui s'ajouteront après la date et s'affichera au 11èmes caractères 
                                $hourFin = substr($_POST['datetimepicker2'],11);




                                //création de la reservation
                                $this->userModel->addBooking((int) $userId, $dateDebut->format('Y-m-d'), $hourDebut, $dateFin->format('Y-m-d'), $hourFin, (int)$_POST['numberOfSeats'], (int)$car_id);
 
                                $this->panierModel->deleteAll();
                                redirect('index.php');
                            }
                            redirect('index.php?action=user&action2=bookingForm&id=' . $_POST['id'] );
                        }
                        redirect('index.php?action=user&action2=bookingForm&id='.  $_POST['id'] );
                    }
                    redirect('index.php?action=user&action2=bookingForm&id='.  $_POST['id'] );
                }
                redirect('index.php?action=user&action2=bookingForm&id='.  $_POST['id'] );
            }
            redirect('index.php?action=user&action2=bookingForm&id='.  $_POST['id'] );
        }
        redirect('index.php');
    }




    /////////// booking ////////////

    /** 
     * en $_GET, afficher les RDV
     * 
     * @return void
     */
    public function getRDV() : void
    {
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }

        //pour éviter que la session de l'utilisateur en cours, ait accès au RDV des autres utilisateurs   
        if(isset($_GET['user_i']) && $_GET['user_i'] ===  $_SESSION['user']['id'] )
        {
            $getBooking = $this->userModel->getBooking((int)$_GET['user_i']);
            require_once 'www/templates/user/booking/BookingView.phtml';
        }
        else
        {
            // si $_GET['user_i'] est différent , 
            //on remet $_SESSION['user']['id'] dans $_GET['user_i'] pour afficher le bon resultat
            $_GET['user_i'] = $_SESSION['user']['id'];
            $getBooking = $this->userModel->getBooking((int) $_GET['user_i']);
            require_once 'www/templates/user/booking/BookingView.phtml';
        }
    }

    /** 
     * en $_GET, effacer un RDV
     * 
     * @return void
     */
    public function deleteRDV() : void
    {
        if(!$this->userSession->isAuthenticatedUser()){
            redirect('index.php?action=user&action2=loginForm');
        }
        $this->userModel->deleteBooking((int) $_GET['id']);
        redirect('index.php?action=user&action2=userRDV&user_i='. $this->userSession->getUserId());
    }
}