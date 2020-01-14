<?php
require_once 'model/category/CategoryModel.php';

/** sélectionner une categorie */
function getOneCategory()
{
    $categories = findCategory($_GET['id_category']);
    require_once 'www/templates/category/CategoryView.phtml';
}