<?php
declare(strict_types=1);

// Set headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

require_once '../controllers/orderDelivaryController.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $controller = new OrderDelivaryController();
    $response = [];

    // Handle OPTIONS request for CORS
    if ($method === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    // Parse input data for POST/PUT requests
    $input = [];
    if (in_array($method, ['POST', 'PUT'])) {
        $input = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON payload');
        }
    }

    // Route requests
    switch ($method) {
        case 'GET':
          if (isset($_GET['test'])) {
            echo json_encode([
                'success' => true,
                'message' => 'API is accessible',
                'method' => $method,
                'get_params' => $_GET
            ]);}
         
            elseif (isset($_GET['products'])) {
                $response = $controller->getOrderProducts();
            } elseif (isset($_GET['order_id'])) {
                $orderId = filter_var($_GET['order_id'], FILTER_VALIDATE_INT);
                if ($orderId === false) {
                    throw new InvalidArgumentException('Invalid order ID');
                }
                $response = $controller->getOrderWithProducts($orderId);
            } else {
                $response = $controller->getAPI();
            }
            break;

        case 'POST':
           
        

            $orderId = filter_var($input['order_id'], FILTER_VALIDATE_INT);
            if ($orderId === false) {
                throw new InvalidArgumentException('Invalid order ID');
            }

            if (isset($input['status']) && $input['status'] === 'delivered') {
                $response = $controller->updateDelivaryStatus($orderId);
            } else {
                throw new InvalidArgumentException('Invalid status update request');
            }
            break;

        default:
            throw new InvalidArgumentException('Method not allowed');
    }

    // Send response
    http_response_code($response['success'] ? 200 : 400);
    echo json_encode($response);

} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} catch (Exception $e) {
    error_log("API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error'
    ]);
}
