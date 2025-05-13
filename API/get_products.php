<?php 
    require_once '../includes/config.php'; 
    require_once '../includes/functions.php'; 

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    // Check if the request method is GET
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        // If the request method is not GET, return a 405 (Method Not Allowed) response
        http_response_code(405);
        echo json_encode([
            "error" => "Method Not Allowed",
            "message" => "Only GET requests are allowed."
        ]);
        exit(); // Stop further execution
    }
    // Check if the database connection is established
    if (!$conn) {
        // If the connection failed, return a 500 (Internal Server Error) response
        http_response_code(500);
        echo json_encode([
            "error" => "Internal Server Error",
            "message" => "Database connection failed. Please try again later."
        ]);
        exit(); // Stop further execution
    }


    $products = [];

    // Query to fetch products
    $sql = "SELECT * FROM home_page_products";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // If the query failed, return a 500 (Internal Server Error) response
        http_response_code(500);
        echo json_encode([
            "error" => "Internal Server Error",
            "message" => "There was an issue with the database query. Please try again later."
        ]);
        exit(); // Stop further execution
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = [
                "id" => (int) $row["id"],
                "image" => $row["image_url"],
                "name" => $row["name"],
                "description" => $row["description"],
                "price" => (float) $row["price"]
            ];
        }
        echo json_encode($products);
    } else {
        // If no products are found, return a 404 (Not Found) response
        http_response_code(404);
        echo json_encode([
            "error" => "Not Found",
            "message" => "No products found."
        ]);
    }
