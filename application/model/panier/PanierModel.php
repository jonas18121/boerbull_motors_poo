<?php
declare(strict_types=1);

require_once 'model/Model.php';

class panierModel extends Model{


    public function __construct()
    {
        if(!isset($_SESSION)){
            session_start();
        }

        if (!isset($_SESSION['panier'])){
            $_SESSION['panier'] = array();
        }
        parent::__construct();
    }




    /** 
     * compter le nombre d'élément présent dans le panier
     * @return int|float
    */
    public function countt(){
        return array_sum($_SESSION['panier']);
    }





    /**
     * calcul le total des prix hors taxe des élément présent dans le panier
     * 
     * @param array $session
     * @return int $total
     */
    public function prixHorsTaxe(array $session) : int 
    {
        $total = 0;

        if(empty($session)){
            $products = (int)implode(array());
            return $products; //return 0

        }else {

            $sql = 'SELECT id, prix_trois_jours FROM car WHERE id IN ('.implode(',',$session).')';
            $products = $this->pdo->prepare($sql);
            $products->execute(array('id' => implode(',' , $session)));
            $products = $products->fetchAll(PDO::FETCH_OBJ); // PDO::FETCH_OBJ pour recupéré le résultat sous forme d'objet

            foreach($products as $product){
                //prix hors taxes , fois le nombres de voiture avec le même id
                $total += $product->prix_trois_jours * $_SESSION['panier'][$product->id];
            }
            return $total;
        }
    }




    /** 
     * calculer la TVA qui s'ajoutera au prix hors taxes 
     * 
     * @param array $session
     * @return float $products OR $total
    */
    public function TVA(array $session) : float 
    {
        $total = 0;

        if(empty($session)){

            $products = (int)implode(array());
            return $products;

        }else {
            $sql = 'SELECT id, round(SUM(prix_trois_jours)*(0.2),2) AS TVA FROM car WHERE id IN ('.implode(',',$session).')';

            $TVA = $this->pdo->prepare($sql);
            $TVA->execute(array('id' => implode(',' , $session)));
            $TVA = $TVA->fetchAll(PDO::FETCH_OBJ);


            foreach($TVA as $product){

                $total += $product->TVA * $_SESSION['panier'][$product->id];
            }
            return $total;
        }
    }





    /** 
     * calculer le prix TTC 
     * 
     * @param array $session
     * @return float $products OR $total
    */
    public function prixTTC(array $session) : float 
    {
        $total = 0;

        if(empty($session)){

            $products = (int)implode(array()); 
            return $products;

        }else {
            $sql = 'SELECT id, SUM(prix_trois_jours)*(1.2) AS prixTTC FROM car WHERE id IN ('.implode(',',$session).')';

            $session = implode(',',$session);

            $prixTTC = $this->pdo->prepare($sql);
            $prixTTC->execute(array('id' => $session));
            $prixTTC = $prixTTC->fetchAll(PDO::FETCH_OBJ);

            foreach($prixTTC as $product){

                $total += $product->prixTTC * $_SESSION['panier'][$product->id];
            }
            return $total;
        }
    }


    /** 
     * ajouter un element au panier
     * 
     * @param int $product_id
     * @return void
     */
    public function addPanier(int $product_id) : void 
    {
        if(isset($product_id)){

            $sql = 'SELECT id FROM car WHERE id = :id';

            $products = $this->pdo->prepare($sql);
            $products->execute(array('id' => $product_id));
            $products = $products->fetchAll(PDO::FETCH_OBJ); // PDO::FETCH_OBJ pour recupéré le résultat sous forme d'objet
        }


        // $products[0]->id est l'id de la voiture qu'on a ajouter au panier
        if(isset($_SESSION['panier'][$products[0]->id])){

            $_SESSION['panier'][$products[0]->id] = '1';
        }else {
        
            $_SESSION['panier'][$products[0]->id] = '1' ;
        }
        redirect("index.php?action=panierView");
    }

    /** 
     * effacer un élément du panier
     * 
     * @param int $product_id
     * @return void
     */
    public function deleteOne(int $product_id) : void 
    {
        unset($_SESSION['panier'][$product_id]);
    }

    /** effacer tous les éléments du panier
     * 
     * @return void
     */
    public function deleteAll() : void 
    {
        unset($_SESSION['panier']);
    }

    /** selectonner les voitures qui sont dans le panier
     * 
     * @param array $session
     * @return array|string
     */
    public function PanierView(array $session) 
    {

        if(!empty($session)){

            $sql = "SELECT id, marque, modele, puissance, prix_trois_jours, nombre_de_voiture FROM car WHERE id IN (".implode(',',$session).")";

            $session = implode(',',$session);

            $PanierView = $this->pdo->prepare($sql);
            $PanierView->execute(array(
                ':id' => $session,
            ));
            $PanierView = $PanierView->fetchAll();
           
            return (array)$PanierView;
            
        }else{
            $PanierView = implode(array());
            return (string)$PanierView;
        } 
    }
}