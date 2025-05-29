<?php

require_once 'models/zoneModel.php';
 
class ZoneController {
private $model;


public function __construct() {
   
    $this->model=new ZoneModel();
 
}
    public function get() {
      
         
        $result = $this->model->get();
       
        

        require 'views/zone.php';  
        
       
    }

    public function store($area_name, $area_desc, $zone_id, $notes) {
        try{
        if ($this->model->store($area_name, $area_desc, $zone_id, $notes)) {
            
         header("Location: index.php?zones");
        } else {
            echo "Failed to add Area.";
        }
        }catch(Exception $e){
            echo $e;
        }
    }
}

?>
