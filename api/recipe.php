<?php
    ob_start(); // يبدأ تخزين الإخراج مؤقتًا

    header('Content-Type: application/json');
    
    require_once '../controllers/recipeController.php';
    
    $controller = new RecipeController();
    
    $output = $controller->getAPI();
    
    // تنظيف الإخراج المؤقت من أي شيء طُبع قبله (مثل // أو فراغات)
    ob_clean();
    
    echo $output;
    
    ob_end_flush();