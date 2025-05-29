<?php
    ob_start(); // يبدأ تخزين الإخراج مؤقتًا

    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true); 
    require_once '../controllers/productController.php';
    
    $controller = new ProductController();
    
    //$output = $controller->getbyid($data);
     $output=json_encode($controller->getAPI());
    // تنظيف الإخراج المؤقت من أي شيء طُبع قبله (مثل // أو فراغات)
    ob_clean();
    echo $output;
   
    
    ob_end_flush();