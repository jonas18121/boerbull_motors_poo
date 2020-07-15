<?php
declare(strict_types=1);

class AdminSession{

    public function __construct()
    {
        // Démarrage du module PHP de gestion des sessions.
        /*si le statut de la session courante et que les sessions sont activées, mais qu'aucune n'existe. 
        on demarre une session*/
        if (session_status() === PHP_SESSION_NONE) {
            session_start();//demarre
        }
    } 

    /**
     * Construction de la session admin.
     *
     * @param int $id
     * @param string $name
     * @param string $email
     * @return void
     */
    public function adminCreate(int $id, string $name, string $email) : void
    {
        $_SESSION['admin']['id']   = $id;
        $_SESSION['admin']['name'] = $name;
        $_SESSION['admin']['mail'] = $email;
    }

    /**
     * Destruction de l'ensemble de la session.
     * @return void
     */
    public function AdminDestroy() : void
    {
        unset($_SESSION['admin']);
    }

    /**
     * Afficher le mail
     * @return string|null
     */
    public function getAdminEmail() : ?string
    {
        if (!$this->isAuthenticatedAdmin()) {
            return null;
        }
        //s'il est connecté on peut affiché la session , $_SESSION['admin']['mail']
        return $_SESSION['admin']['mail'];
    }

    /**
     * Afficher le prénom
     * @return string|null
     */
    public function getAdminName() : ?string
    {
        //if (!$this->isAuthenticated()) = si le admin n'est pas connècté, alors ne rien renvoyé  
        if (!$this->isAuthenticatedAdmin()) {
            return null;
        }
        //s'il est connecté on peut affiché la session , $_SESSION['admin']['first_name']
        return $_SESSION['admin']['name'];
    }

    /**
     * Afficher le id
     *
     * @return int|null
     */
    public function getAdminId() : ?int
    {

        if (!$this->isAuthenticatedAdmin()) {
            return null;
        }
        //s'il est connecté on peut affiché la session , $_SESSION['admin']['id']
        return $_SESSION['admin']['id'];
    }

    /**
     * on verifie si la session user existe et qu'il y a du contenu dedans
     * @return boolean
     */
	public function isAuthenticatedAdmin() : bool
    {
        if(array_key_exists('admin', $_SESSION)) {
            if (!empty($_SESSION['admin']) && isset($_SESSION['admin'])) {
                return true;
            }
        }
        return false;
    }
}
    
    
