<?php
// middleware/auth.php

function authenticate(): void {
    $headers = getallheaders();
    $token = $headers['Authorization'] ?? '';

    // Example: simple token validation
    $validToken = 'Bearer mysecrettoken';

    if ($token !== $validToken) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
}