<?php
function dispatch($route) {
   $controllerFile = __DIR__ .'/../controllers/'. $route['controller'] . '.php';

   if (!file_exists($controllerFile)) {
       http_response_code(404);
       echo json_encode(['error' => 'Controller file not found',$controllerFile]);
       exit();
   }

   require_once $controllerFile;

   if (!class_exists($route['controller'])) {
       http_response_code(500);
       echo json_encode(['error' => 'Controller class not found']);
       exit();
   }

   $controller = new $route['controller']();
   $input = json_decode(file_get_contents('php://input'), true);

   if (!method_exists($controller, $route['action'])) {
       http_response_code(404);
       echo json_encode(['error' => 'Action not found']);
       exit();
   }
//    $params = ($_SERVER['REQUEST_METHOD'] === 'GET')
//        ? $_GET
//        : json_decode(file_get_contents('php://input'), true);

//    $params = $params ?? [];
//    unset($params['resource'], $params['action']);

//    // تمرير البيانات كـ arguments للدالة
//    $args = array_values($params);

       

//    $result = call_user_func_array([$controller, $route['action']], $args);
//    echo json_encode(['success' => true, 'data' => $result]);

//    $result = $controller->{$route['action']}($input);
//    echo json_encode(['success' => true, 'data' => $result]);
if (method_exists($controller, $action)) {
   $result = $controller->$action($input);
   echo json_encode(['success' => true, 'data' => $result]);
} else {
   http_response_code(404);
    echo $action;
   echo json_encode(['error' => 'Action not found']);
}

}