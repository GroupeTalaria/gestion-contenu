<?php


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Get request Header
$headers = getallheaders();
$auth = $headers['Authorization'] ?? "Bearer ";

// Get JWT Secret
$jwt = substr($auth, 7);
$key = JWT_SECRET;

try {
    $payload = JWT::decode($jwt, new Key($key, 'HS256'));
} catch (\Exception $e) {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Authorization');
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode([
        'error' => 'Unauthorized'
    ]);
    die();
}
