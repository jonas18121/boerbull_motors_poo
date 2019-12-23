<?php
require_once 'model/Model.php';
include_once 'library/Tools.php';


/** selectionner par categorie 
 * 
 * @param int $category
 * @return array $categories
*/
function findCategory(int $category) :array
{
    $sql = "SELECT car.id, image_url, modele, marque, name FROM car INNER JOIN category ON category.id = car.id_category WHERE category.id = :id_category";

    $categories = $this->pdo->prepare($sql);
    $categories->execute(array('id_category' => $category));

    $categories = $categories->fetchAll();

    if(empty($categories)){
        redirect("index.php");
    }
    return $categories;
} 


/** selectionner toutes les voitures 
 *
 * @return array 
 */ 
function findAllo()
{ 
    $sql = "SELECT * FROM car ";
    $categories = $this->pdo->query($sql);
    $categories = $categories->fetchAll();
    return  $categories;
}

