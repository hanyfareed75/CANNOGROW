<?php
require_once 'models/accGl.php';
 
 
class AccGlController {
private $model;
 
 

public function __construct() {
    $this->model = new AccGlModel();
 ;
 
}
    public function get() {
      
         
        $order = $this->model->get();
        $selecteditems=$this -> SubModel->getselected(); 
        

        require 'views/accGl.php';  
        
       
    }

    public function store($gl_name, $gl_desc) {
        try{
        if ($this->model->store($gl_name, $gl_desc)) {
            
         header("Location: index.php?accGl");
        } else {
            echo "Failed to add Agent.";
        }
        }catch(Exception $e){
            echo $e;
        }
    }
}

?>
