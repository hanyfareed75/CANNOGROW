<?php
// إعدادات الرؤوس
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
   http_response_code(200);
   exit();
}

// تحديد الموارد (resource) والإجراء (action)
$resource = $_GET['resource'] ?? '';
$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

if (!$resource || !$action) {
   http_response_code(400);
   echo json_encode(['error' => 'Missing resource or action']);
   exit();
}

// اسم الكنترولر ومساره
$controllerName = strtolower($resource) . 'Controller';
$controllerFile = __DIR__ ."/../controllers/$controllerName.php";

// التحقق من وجود الملف
if (!file_exists($controllerFile)) {
   http_response_code(404);
   echo json_encode(['error' => 'Controller file not found']);
   exit();
}

require_once $controllerFile;

// التحقق من وجود الكلاس
if (!class_exists($controllerName)) {
   http_response_code(500);
   echo json_encode(['error' => 'Controller class not found']);
   exit();
}

$controller = new $controllerName();

// قراءة المعاملات
$input = [];
if ($method === 'GET') {
   $input = $_GET;
   unset($input['resource'],$input['action']);
} elseif (in_array($method, ['POST', 'PUT', 'DELETE'])) {
   $json = file_get_contents('php://input');
   $input = json_decode($json, true) ?? [];
}

// التحقق من وجود الدالة
if (!method_exists($controller, $action)) {
   http_response_code(404);
   echo json_encode(['error' => 'Action not found']);
   exit();
}

// تنفيذ الدالة وتمرير المعاملات
try {
   $result = $controller->$action($input);
   echo json_encode(['success' => true, 'data' => $result]);
} catch (Throwable $e) {
   http_response_code(500);
   echo json_encode(['error' => $e->getMessage()]);
   echo json_encode($input);
}
