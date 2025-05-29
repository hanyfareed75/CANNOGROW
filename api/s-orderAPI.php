<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

require_once '../controllers/orderController.php';
require_once '../controllers/customerController.php';
require_once '../controllers/agentController.php';
require_once '../controllers/productController.php';
require_once '../controllers/areaController.php';
require_once '../controllers/delivaryController.php';

function jsonError(string $message, int $code = 400): void {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit;
}

// Log incoming requests (اختياري)
file_put_contents('request_log.txt', "[$method] $endpoint @ " . date("Y-m-d H:i:s") . "\n", FILE_APPEND);

// Handle only GET and POST for now
if (!in_array($method, ['GET', 'POST'], true)) {
    jsonError('Method not allowed', 405);
}

$input = json_decode(file_get_contents('php://input'), true);

// Route based on endpoint
switch ($endpoint) {
    case 'orders':
        $controller = new OrderController();
        if ($method === 'GET') {
            echo json_encode($controller->getAPI());
        } elseif ($method === 'POST') {
            // استخدم هنا نفس منطق store/storeitems الذي استخدمته سابقاً
        }
        break;

    case 'customers':
        $controller = new CustomerController();
        if ($method === 'GET') {
            echo json_encode($controller->getAll());
        } elseif ($method === 'POST') {
            $name = $input['name'] ?? '';
            $phone = $input['phone'] ?? '';
            $controller->create($name, $phone);
            echo json_encode(['success' => 'Customer created']);
        }
        break;

    case 'agents':
        $controller = new AgentController();
        if ($method === 'GET') {
            echo json_encode($controller->getAll());
        } elseif ($method === 'POST') {
            $name = $input['name'] ?? '';
            $controller->create($name);
            echo json_encode(['success' => 'Agent created']);
        }
        break;

    case 'products':
        $controller = new ProductController();
        if ($method === 'GET') {
            echo json_encode($controller->getAll());
        } elseif ($method === 'POST') {
            $name = $input['name'] ?? '';
            $price = $input['price'] ?? 0;
            $controller->create($name, $price);
            echo json_encode(['success' => 'Product created']);
        }
        break;

    case 'areas':
        $controller = new AreaController();
        if ($method === 'GET') {
            echo json_encode($controller->getAll());
        } elseif ($method === 'POST') {
            $name = $input['name'] ?? '';
            $controller->create($name);
            echo json_encode(['success' => 'Area created']);
        }
        break;

    case 'delivary':
        $controller = new DeliveryController();
        if ($method === 'GET') {
            echo json_encode($controller->getAll());
        } elseif ($method === 'POST') {
            $orderId = $input['order_id'] ?? '';
            $agentId = $input['agent_id'] ?? '';
            $status = $input['status'] ?? 'pending';
            $controller->assign($orderId, $agentId, $status);
            echo json_encode(['success' => 'Delivery assigned']);
        }
        break;

    default:
        jsonError('Unknown endpoint');
}
