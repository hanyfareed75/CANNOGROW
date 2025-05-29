<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once __DIR__ . '/../models/reportsModel.php';
require_once __DIR__ . '/../controllers/reportsController.php';

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

// Log incoming requests (اختياري)
file_put_contents('request_log.txt', "[$method] $endpoint @ " . date("Y-m-d H:i:s") . "\n", FILE_APPEND);

// Handle only GET and POST for now
if (!in_array($method, ['GET', 'POST'], true)) {
  jsonError('Method not allowed', 405);
}

$input = json_decode(file_get_contents('php://input'), true);
function jsonError(string $message, int $code = 400): void {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit;
}

switch ($method) {
    case 'GET':
        $controller = new ReportsController();
        if ($method === 'GET') {
            echo json_encode($controller->generateCustomerReport());
        }
        break;
    default:
        jsonError('Endpoint not found', 404);

}

