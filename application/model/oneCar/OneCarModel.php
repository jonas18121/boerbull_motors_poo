<?php
require_once 'model/Model.php';
include_once 'library/Tools.php';

class OneCarModel extends Model{


    /** selectionne une voiture 
     * 
     * @param int
     * @return array
    */
    public function OneCar(int $one) : array 
    {
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
     * @param array $session
     * @return array $oneCar
    */
    public function OneCarBooking(array $session) :array
    {
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