<?php
function resolveRoute() {
   $resource = $_GET['resource'] ?? null;
   $action = $_GET['action'] ?? null;
   $method = $_SERVER['REQUEST_METHOD'];

   if (!$resource || !$action) {
       http_response_code(400);
       echo json_encode(['error' => 'Missing resource or action']);
       exit();
   }

   return [
       'controller' => stripslashes(strtolower($resource).'Controller'),
       'action' => $action,
       'method' => $method
   ];
}