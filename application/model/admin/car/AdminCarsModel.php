<?php

declare(strict_types=1);

require_once 'model/admin/AdminModel.php';
require_once 'library/Tools.php';

class AdminCarsModel extends AdminModel
{
            //// Afficher ////
    /** Afficher tous les cars 
     * 
     * @return array $adminGetCars
    */
    public function GetCars() : array 
    {
        $sql = "SELECT * FROM car";
        $adminGetCars = $this->pdo->query($sql);
        $adminGetCars = $adminGetCars->fetchAll();

        return $adminGetCars;
    }

            //// Ajouter ////
    /** admin ajoute une voiture 
     *
     * @param string    $marque
     * @param string    $modele
     * @param int       $annee
     * @param int       $conso 
     * @param string    $color
     * @param int       $prix_trois_jours
     * @param int       $puissance
     * @param string    $moteur
     * @param string    $carburant
     * @param int       $cent
     * @param int       $nombre_de_place
     * @param int       $id_category
     * @param string    $image_url
     * 
     * @return void  
     */ 
    public function addCars(
        string $marque, string $modele, int $annee, int $conso, string $color, int $prix_trois_jours, int $puissance, 
        string $moteur, string $carburant, int $cent, int $nombre_de_place, int $id_category, string $image_url
    ) : void 
    {
        $sql = "INSERT INTO car(marque, modele, annee, conso, color, prix_trois_jours, puissance, moteur, carburant, cent, nombre_de_place, id_category, image_url) 
            VALUES(:marque, :modele, :annee, :conso, :color, :prix_trois_jours, :puissance, :moteur, :carburant, :cent, :nombre_de_place, :id_category, :image_url)";

        $addCar = $this->pdo->prepare($sql);
        
        $addCar->execute([
            ':marque'               => $marque, 
            ':modele'               => $modele, 
            ':annee'                => $annee,
            ':conso'                => $conso,
            ':color'                => $color,
            ':prix_trois_jours'     => $prix_trois_jours,
            ':puissance'            => $puissance,
            ':moteur'               => $moteur,
            ':carburant'            => $carburant,
            ':cent'                 => $cent,
            ':nombre_de_place'      => $nombre_de_place,
            ':id_category'          => $id_category, 
            ':image_url'            => $image_url
        ]);
    }

    /** admin ajoute une categorie à la voiture qu'on a ajouter 
     * 
     * @return array $category
    */
    public function category() : array 
    {
        $sql = "SELECT * FROM category";
        $category = $this->pdo->query($sql);
        $category = $category->fetchAll();
    
        return $category;
    }

                //// Modifier ////
    //en $_GET
    /** admin affiche le car a modifier 
     * 
     * @param int $id
     * @return array $editFormCars
    */
    public function editFormCars(int $id) : array 
    {
        $sql = "SELECT * FROM car WHERE id = :id";

        $editFormCars = $this->pdo->prepare($sql);
        $editFormCars->execute([':id' => $id]);
        $editFormCars = $editFormCars->fetchAll();

        if(empty($editFormCars)){
            redirect("index.php");
        }
        return $editFormCars;
    }

    // en $_POST
    /** admin modifie les paramètres d'une voiture précise 
     * 
     * @param string $marque
     * @param string $modele
     * @param int $anne
     * @param int $conso
     * @param string $color
     * @param int $prix_trois_jours
     * @param int $puissance
     * @param string $moteur
     * @param string $carburant
     * @param int $cent
     * @param int $nombre_de_place
     * @param int $id_category
     * @param int $id
     * 
     * @return void
    */
    public function editCars(
        string $marque, string $modele, int $anne, int $conso, string $color, int $prix_trois_jours, int $puissance, 
        string $moteur, string $carburant, int $cent, int $nombre_de_place, int $id_category, int $id
    ) : void 
    {
        $sql = "UPDATE car SET marque = :marque, modele = :modele, annee = :annee, conso = :conso, color = :color, prix_trois_jours = :prix_trois_jours, 
            puissance = :puissance, moteur = :moteur, carburant = :carburant, cent = :cent, nombre_de_place = :nombre_de_place, id_category = :id_category WHERE id = :id";

        $editCar = $this->pdo->prepare($sql);
        $editCar->execute([
            ':marque'           => $marque, 
            ':modele'           => $modele, 
            ':annee'            => $anne,
            ':conso'            => $conso,
            ':color'            => $color,
            ':prix_trois_jours' => $prix_trois_jours,
            ':puissance'        => $puissance,
            ':moteur'           => $moteur,
            ':carburant'        => $carburant,
            ':cent'             => $cent,
            ':nombre_de_place'  => $nombre_de_place,
            ':id_category'      => $id_category,
            ':id'               => $id
        ]);
    }

                //// Supprimer ////
    /** supprimer un car 
     * 
     * @param int $id
     * @return void
    */
    public function deleteCar(int $id) : void 
    {
        $sql = "DELETE FROM car WHERE id = :id ";

        $deleteUser = $this->pdo->prepare($sql);
        $deleteUser->execute([':id' => $id]);
    }
}