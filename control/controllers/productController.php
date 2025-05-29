<?php

require_once __DIR__ . '/../models/productModel.php';
class ProductController {
private $model;
 


public function __construct() {
    $this->model = new ProductModel();
    
}
    public function getProduct() {
      
         
        $products = $this->model->getallProducts();
         
        
        require __DIR__.'/../views/products.php';  // Make sure no output before header() call
        
       
    }
    public function getAPI(){
     return $this->model->getallProducts();
    }

    public function store($name_eng, $name_ar, $unit_price, $description_ar) {
        try{
        if ($this->model->store($name_eng, $name_ar, $unit_price, $description_ar)) {
           // echo "ITEM added successfully!";
           header("Location: index.php?products");
        } else {
            echo "Failed to add ITEM.";
        }
        }catch(Exception $e){ 
            echo $e;
        }
    }
    public function getbyid($id){
        return $this-> model->getbyid($id);
    }
}

?>
