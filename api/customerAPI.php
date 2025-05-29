<?php

declare(strict_types=1);

// Headers
header("Referrer-Policy: strict-origin-when-cross-origin");
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

require_once __DIR__ . '/../controllers/customerController.php';  // Fixed path

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
$controller = new CustomerController();

// Log requests
$file = fopen("request_log.txt", "a");
fwrite($file, "Request at " . date("Y-m-d H:i:s") . "\n");
fwrite($file, "REQUEST: " . print_r($_REQUEST, true) . "\n");
if ($method === 'POST') {
    fwrite($file, "POST Data: " . file_get_contents("php://input") . "\n");
}
fclose($file);

// Main Router
switch ($method) {
    case 'GET':
        try {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $result = $controller->findById((int)$id);
                echo json_encode($result ?: ['error' => 'Customer not found']);
            } else {
                echo json_encode($controller->getAPI());
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    case 'POST':
        try {
            if (!$input) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid JSON data']);
                break;
            }

            // Handle PUT request using POST method
            if (isset($input['_method']) && $input['_method'] === 'PUT') {
                if (!isset($input['cust_id'], $input['cust_name'], $input['address'], $input['mobile_1'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required fields for update']);
                    break;
                }

                $updated = $controller->update(
                    (int)$input['cust_id'],
                    trim($input['cust_name']),
                    trim($input['address']),
                    trim($input['mobile_1']),
                    trim($input['mobile_2'] ?? ''),
                    trim($input['email'] ?? ''),
                    trim($input['notes'] ?? '')
                );
                echo json_encode(['success' => $updated]);
                break;
            }

            // Handle DELETE request using POST method
            if (isset($input['_method']) && $input['_method'] === 'DELETE') {
                if (!isset($input['cust_id'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Customer ID is required for deletion']);
                    break;
                }

                $deleted = $controller->delete((int)$input['cust_id']);
                echo json_encode(['success' => $deleted]);
                break;
            }

            // Handle new customer creation
            if (!isset($input['cust_name'], $input['address'], $input['mobile_1'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                break;
            }
            
            $created = $controller->store	(
                trim($input['cust_name']),
                trim($input['mobile_1']),
                trim($input['mobile_2'] ?? ''),
                trim($input['address']),
                trim($input['area'] ?? '')
            );
            
            http_response_code(201);
            echo json_encode(['success' => $created]);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
}