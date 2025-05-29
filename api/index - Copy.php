<?php
declare(strict_types=1);

header("Content-Type: application/json");

require_once __DIR__ . '/../controllers/orderDelivaryController.php';
require_once __DIR__ . '/../controllers/agentController.php';
require_once __DIR__ . '/../controllers/productController.php';
require_once __DIR__ . '/../controllers/orderController.php';
// Instantiate controllers
$orderModel = new OrderDelivaryController();
$agentModel = new AgentController();
$productModel = new ProductController();
$orderModel = new OrderController();


// Determine HTTP method and route
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim(str_replace("/managment/api", "", $uri), "/");

// Read JSON input for POST requests
$input = ($method === 'POST') ? json_decode(file_get_contents("php://input"), true) : [];

// Route handling
switch ("$method $path") {

    case 'GET orders':
        echo json_encode([
            'orders'    => $orderModel->getOrderProducts(),
            'customers' => $orderModel->getAPI()
        ]);
        break;

    case 'POST orders':
        if (empty($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON input']);
            break;
        }

        $result = $orderModel->store(
            $input['created_at'] ?? '',
            $input['cust_id'] ?? '',
            $input['order_value'] ?? 0,
            $input['sp_discounts'] ?? 0,
            $input['order_status'] ?? 'Ordered',
            $input['notes'] ?? ''
        );

        echo json_encode(['success' => $result]);
        break;

    case 'POST orders/items':
        if (empty($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON input']);
            break;
        }

        $result = $orderModel->storeitems(
            $input['order_id'] ?? '',
            $input['product_id'] ?? '',
            $input['qty'] ?? 0,
            $input['total'] ?? 0,
            $input['notes'] ?? ''
        );

        echo json_encode(['success' => $result]);
        break;

    case 'POST delivary':
        if (empty($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON input']);
            break;
        }

        $result = $orderModel->updateDelivaryStatus($input['order_id'] ?? '');
        echo json_encode(['success' => $result]);
        break;

    case 'GET agents':
        echo json_encode($agentModel->get());
        break;
        case 'GET s_product':
          echo json_encode([
              'orders'    => $orderModel->getOrderProducts(),
              'customers' => $orderModel->getAPI()
          ]);
          break;
    default:
        http_response_code(404);
        echo json_encode(['error' => "Unknown endpoint: $method $path"]);
        break;
}
