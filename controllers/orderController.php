<?php
require_once __DIR__ . '/../models/orderModel.php';
require_once  __DIR__ . '/../models/productModel.php';
require_once  __DIR__ . '/../models/customerModel.php';
class OrderController {
private $model;
private $SubModel;
private $submodel2;


public function __construct() {
    $this->model = new OrderModel();
    $this->SubModel=new ProductModel();
    $this-> submodel2=new CustomerModel();
}
    public function get() {
      
         
        $order = $this->model->get();
        $selecteditems=$this -> SubModel->getselected();
        $customers=$this->submodel2->get();  
       require __DIR__ .  '/../views/order.php';
       }

        function getOrderDetails(){
            return $this->model->getOrderDetails();
        }
public function getAPI(){
    return $this->model->get();
}
    public function store($created_at, $cust_id, $order_value, $sp_discounts, $order_status, $notes) {
        try{
        if ($this->model->store($created_at, $cust_id, $order_value, $sp_discounts, $order_status, $notes)) {
            
        //  header("Location: index.php?orders");
        } else {
            echo "Failed to add Order.";
        }
        }catch(Exception $e){
            echo $e;
        }
    }
    public function storeitems($order_id,$product_id,$qty,$total,$notes) {
        try{
        if ($this->model->storeitems($order_id,$product_id,$qty,$total,$notes)) {
            
        //  header("Location: index.php?orders");
        } else {
            echo "Failed to add Order.";
        }
        }catch(Exception $e){
            echo $e;
        }
    }
}

?>
