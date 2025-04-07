<?php

require_once __DIR__ . '/../app/controllers/ApiController.php';

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get request data
$requestData = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true) ?? [];
} else {
    $requestData = $_GET;
}

// Get endpoint from URL
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';

// Initialize API controller
$apiController = new ApiController();

// Handle request
$response = $apiController->handleRequest($endpoint, $requestData);

// Send response
echo json_encode($response);