<?php
require_once 'models/complainModel.php';
require_once 'models/customerModel.php';
 
class ComplainController {
private $model;
private $SubModel;
 

public function __construct() {
    $this->model = new ComplainModel();
    $this->SubModel=new customerModel();
 
}
    public function get() {
      
         
        $order = $this->model->get();
        $selecteditems=$this -> SubModel->getselected(); 
        $selecteditems2=$this -> SubModel2->getselected();     

        require 'views/complain.php';  
        
       
    }

    public function store($comp_date, $cust_id, $category, $complain,$status) {
        try{
        if ($this->model->store($comp_date, $cust_id, $category, $complain,$status)) {
            
         header("Location: index.php?complains");
        } else {
            echo "Failed to add Complain.";
        }
        }catch(Exception $e){
            echo $e;
        }
    }
}

?>
