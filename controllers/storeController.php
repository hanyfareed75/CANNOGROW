<?php
require_once 'models/storeModel.php';
require_once 'models/itemsModel.php';
class StoreController {
private $model;
private $itemsModel;


public function __construct() {
    $this->model = new StoreModel();
    $this->itemsModel=new ItemModel();
}
    public function getStore() {
      
         
        $store = $this->model->getallStore();
        $selecteditems=$this -> itemsModel->getselected();      

        require 'views/store.php';  // Make sure no output before header() call
        
       
    }

    public function store($tran_date, $item_id, $qty, $trans,$notes) {
        try{
        if ($this->model->insertStore($tran_date, $item_id, $qty, $trans,$notes)) {
            echo "ITEM added successfully!";
          //  header("Location: index.php?store");
        } else {
            echo "Failed to add ITEM.";
        }
        }catch(Exception $e){
            echo $e;
        }
    }
}

?>
