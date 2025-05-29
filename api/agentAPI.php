<?php


declare(strict_types=1);

// Headers
header("Referrer-Policy: strict-origin-when-cross-origin");
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

require_once __DIR__ . '/../controllers/agentController.php';

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
$controller = new AgentController();

// Main Router
switch ($method) {
    case 'GET':
        try {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $result = $controller->findById((int)$id);
                echo json_encode($result ?: ['error' => 'Agent not found']);
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

            // Handle DELETE request using POST method
            if (isset($input['_method']) && $input['_method'] === 'DELETE') {
                if (!isset($input['agent_id'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Agent ID is required for deletion']);
                    break;
                }

                $deleted = $controller->delete((int)$input['agent_id']);
                echo json_encode(['success' => $deleted]);
                break;
            }

            // Handle PUT request using POST method
            if (isset($input['_method']) && $input['_method'] === 'PUT') {
                if (!isset($input['agent_id'], $input['agent_name'], $input['address'], $input['mobile_1'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required fields for update']);
                    break;
                }

                $updated = $controller->update(
                    (int)$input['agent_id'],
                    trim($input['agent_name']),
                    trim($input['address']),
                    trim($input['mobile_1']),
                    trim($input['mobile_2'] ?? ''),
                    trim($input['notes'] ?? '')
                );

                echo json_encode(['success' => $updated]);
                break;
            }

            // Handle new agent creation
            if (!isset($input['agent_name'], $input['address'], $input['mobile_1'], $input['areas']) 
                || !is_array($input['areas'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields or invalid areas format']);
                break;
            }

            // Begin transaction
            $controller->beginTransaction();

            try {
                // Create new agent
                $agent_id = $controller->store(
                    trim($input['agent_name']),
                    trim($input['address']),
                    trim($input['mobile_1']),
                    trim($input['mobile_2'] ?? ''),
                    trim($input['notes'] ?? '')
                );

                // Store areas
                foreach ($input['areas'] as $area) {
                    if (!isset($area['area_id'])) {
                        throw new Exception('Invalid area format');
                    }
                    $controller->storeAreas( (int)$area['area_id'],$area['agent_name'] ?? '');
                }

                // Commit transaction
                $controller->commit();
                http_response_code(201);
                echo json_encode(['success' => true, 'agent_id' => $agent_id]);

            } catch (Exception $e) {
                // Rollback on error
                $controller->rollback();
                throw $e;
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
}