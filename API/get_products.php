<?php


require_once '../includes/config.php';
require_once './ProductController.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        "error" => "Method Not Allowed",
        "message" => "Only GET requests are allowed."
    ]);
    exit();
}

// Check database connection
if (!$conn) {
    http_response_code(500);
    echo json_encode([
        "error" => "Internal Server Error",
        "message" => "Database connection failed. Please try again later."
    ]);
    exit();
}

// Handle the request
$productController = new ProductController($conn);
$response = $productController->getProducts();

http_response_code($response['statusCode']);
echo json_encode($response['data']);
?>