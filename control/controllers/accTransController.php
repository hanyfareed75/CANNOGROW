<?php
require_once __DIR__.'/../models/accTransModel.php';
require_once __DIR__.'/../models/accGlModel.php'; 
 
class AccTransController {
private $model;
private $SubModel;
 
 

public function __construct() {
    $this->model = new AccTransModel();
    $this->SubModel=new AccGlModel();
 
}
    public function get() {
      try{
         
        $result = $this->model->get();
        $selecteditems=$this ->SubModel->getselected(); 
        

        require 'views/accTrans.php';  
      }
      catch (Exception $e){
          echo $e;
      } 
       
    }

    public function store($trans_value, $trans_description,  $gl_id,$trans_type,$invoice_id,$invoice_path) {
        try{
        if ($this->model->store($trans_value, $trans_description,  $gl_id,$trans_type,$invoice_id,$invoice_path)) {
            
         header("Location: index.php?accTrans");
        } else {
            echo "Failed to add Agent.";
        }
        }catch(Exception $e){
            echo $e;
        }
    }
}
