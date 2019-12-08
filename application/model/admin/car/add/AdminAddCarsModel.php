<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

class AdminAddCarsModel extends Model{



    /** admin ajoute une voiture 
     *
     * @param string/int
     * 
     * @return void  
     */ 
    public function addCars($marque, $modele, $annee, $conso, $color, $prix_trois_jours, $puissance, $moteur, $carburant, $cent, $nombre_de_place, $id_category, $image_url){
     
        $sql = "INSERT INTO car(marque, modele, annee, conso, color, prix_trois_jours, puissance, moteur, carburant, cent, nombre_de_place, id_category, image_url) 
            VALUES(:marque, :modele, :annee, :conso, :color, :prix_trois_jours, :puissance, :moteur, :carburant, :cent, :nombre_de_place, :id_category, :image_url)";


        $addCar = $this->pdo->prepare($sql);
        
        $addCar->execute([
            ':marque' => $marque, 
            ':modele' => $modele, 
            ':annee' => $annee,
            ':conso' => $conso,
            ':color' => $color,
            ':prix_trois_jours' => $prix_trois_jours,
            ':puissance' => $puissance,
            ':moteur' => $moteur,
            ':carburant' => $carburant,
            ':cent' => $cent,
            ':nombre_de_place' => $nombre_de_place,
            ':id_category' => $id_category, 
            ':image_url' => $image_url
        ]);
    }



    /** admin ajoute une categorie à la voiture qu'on a ajouter 
     * 
     * @return array
    */
    public function category(){

        $sql = "SELECT * FROM category";
        $category = $this->pdo->query($sql);
        $category = $category->fetchAll();
    
        return $category;
    }
}