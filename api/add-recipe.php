<?php
ob_start();
header('Content-Type: application/json');
require_once '../controllers/recipeController.php';
    
   $data = json_decode(file_get_contents('php://input'), true); 
    
   
try{
    $controller=new RecipeController();
  
     $product_id= $data['product_id'] ?? null;
    $item_id=$data['item_id'] ?? 0;
    $qty=$data['qty'] ?? 0;
    $notes=$data['notes'] ?? '';

$controller->store($item_id,$product_id,$qty,$notes);
echo "Sucsses";
}catch(Exception $e) {
    echo $e;
}
ob_clean();
ob_end_flush();