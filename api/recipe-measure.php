<?php
    ob_start(); // يبدأ تخزين الإخراج مؤقتًا

    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true); 
    require_once '../controllers/recipeController.php';
    
    $controller = new RecipeController();
    
    $output = $controller->getMeasure($data);
     
    // تنظيف الإخراج المؤقت من أي شيء طُبع قبله (مثل // أو فراغات)
    ob_clean();
    echo $output;
   
    
    ob_end_flush();