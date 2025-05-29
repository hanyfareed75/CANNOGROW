<?php
 require_once __DIR__ . '/../models/recipeModel.php';
    require_once __DIR__ . '/../models/productModel.php';
    require_once __DIR__ . '/../models/itemsModel.php';
class RecipeController {
private $model;
private $Pmodel;
private $Imodel; 
public function __construct() {
   


    $this->model = new RecipeModel();
    $this ->Imodel =new ItemModel();
    $this -> Pmodel=new ProductModel();
 ;
 
}
    public function get() {
      
         try {
        $result = $this->model->get();
        $selectedP=$this -> Pmodel->getselected(); 
        $selectedI=$this -> Imodel->getselected(); 

        require 'views/recipe.php';  
         }catch (Exception $e){
             die($e);
         }
       
    }
public function getAPI(){
    return json_encode($this->model->get());
}
    public function store( $item_id,$product_id,$qty,$notes) {
        try{
        if ($this->model->store($item_id,$product_id,$qty,$notes)) {
            
         //header("Location: index.php?recipe");
        } else {
            
        }
        }catch(Exception $e){
            echo $e;
        }}
    function deletebyid($id) {
        $this->model->deletebyid($id);  
    }

    public function getMeasure($id){
        return json_encode($this->model->getMeasure($id));
    }
}