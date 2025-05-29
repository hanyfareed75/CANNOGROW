<?php
header('Content-Type: application/json');
    
require_once '../controllers/recipeController.php';
    
$controller = new RecipeController();
// Read raw JSON input
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;

if (!$id) {
  http_response_code(400);
  echo "Invalid ID";
  exit;
}
$controller->deletebyid($id);

?>
