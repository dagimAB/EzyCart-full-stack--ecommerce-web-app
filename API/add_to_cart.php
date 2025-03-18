<?php
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../pages/signIn.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = getUserId();

    // Check if product already exists in cart
    $sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update quantity
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
    } else {
        // Insert new item
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>