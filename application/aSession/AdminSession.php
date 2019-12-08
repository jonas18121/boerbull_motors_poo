<?php
    // Démarrage du module PHP de gestion des sessions.


class AdminSession{


    public function __construct(){

        // Démarrage du module PHP de gestion des sessions.
        /*si le statut de la session courante et que les sessions sont activées, mais qu'aucune n'existe. 
        on demarre une session*/
        if (session_status() === PHP_SESSION_NONE) {
            session_start();//demarre
        }

    } 

    // Construction de la session admin.
    public function adminCreate($id, $name, $email){

        $_SESSION['admin']['id'] = $id;
        $_SESSION['admin']['name'] = $name;
        $_SESSION['admin']['mail'] = $email;
    }

    //on detruit la session
    public function AdminDestroy(){
        // Destruction de l'ensemble de la session.
        unset($_SESSION['admin']);
    }

    //afficher le mail
    public function getAdminEmail(){

        if (!$this->isAuthenticatedAdmin()) {
            return null;
        }
        //s'il est connecté on peut affiché la session , $_SESSION['admin']['mail']
        return $_SESSION['admin']['mail'];
    }


    //afficher le nom
    public function getAdminName(){

        //if (!$this->isAuthenticated()) = si le admin n'est pas connècté, alors ne rien renvoyé  
        if (!$this->isAuthenticatedAdmin()) {
            return null;
        }
        //s'il est connecté on peut affiché la session , $_SESSION['admin']['first_name']
        return $_SESSION['admin']['name'];
    }


    //afficher le id
    public function getAdminId(){

        if (!$this->isAuthenticatedAdmin()) {
            return null;
        }
        //s'il est connecté on peut affiché la session , $_SESSION['admin']['id']
        return $_SESSION['admin']['id'];
    }



    //on verifie si la session user existe et qu'il y a du contenu dedans
	public function isAuthenticatedAdmin(){

        if(array_key_exists('admin', $_SESSION)) {
            if (!empty($_SESSION['admin']) && isset($_SESSION['admin'])) {
                return true;
            }
        }
        return false;
    }
}
    
    
