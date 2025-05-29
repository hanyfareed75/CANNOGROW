<?php
require_once 'models/accJournModel.php';
 
 
class AccJournController {
private $model;
 
 

public function __construct() {
    $this->model = new AccJournModel();
 ;
 
}
    public function get() {
      
         
        $order = $this->model->get();
        $selecteditems=$this -> SubModel->getselected(); 
        

        require 'views/accJournModels.php';  
        
       
    }

    public function store($date, $gl_id, $value, $notes) {
        try{
        if ($this->model->store($date, $gl_id, $value, $notes)) {
            
         header("Location: index.php?accJournModels");
        } else {
            echo "Failed to add Agent.";
        }
        }catch(Exception $e){
            echo $e;
        }
    }
}

?>
