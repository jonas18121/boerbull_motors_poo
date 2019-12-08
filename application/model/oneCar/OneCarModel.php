<?php
//model , gestion de la base de donnée

//inclure la classe Model
require_once 'model/Model.php';

//appel dans la librairie
include_once 'library/Tools.php';


class OneCarModel extends Model{


    /** selectionne une voiture 
     * 
     * @param int
     * 
     * @return array
    */
    public function OneCar($one){
       

        $sql = "SELECT * FROM car WHERE id = :id";

        $oneCar = $this->pdo->prepare($sql);
        $oneCar->execute(array('id' => $one));

        $oneCar = $oneCar->fetchAll();
    
        if(empty($oneCar)){
            redirect("index.php");
        }

        return $oneCar;
    }


    /** selectionne une voiture 
     * 
     * @param array
     * 
     * @return array
    */
    public function OneCarBooking(array $session){

        $sql = 'SELECT * FROM car WHERE id IN ('.implode(',',$session).')';

        $oneCar = $this->pdo->prepare($sql);
        $oneCar->execute(array('id' => implode(',' , $session)));

        $oneCar = $oneCar->fetchAll();

        if(empty($oneCar)){
            redirect("index.php");
        }

        return $oneCar;
    }
}