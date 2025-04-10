<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    die("CSRF token validation failed");
}

// Validate user is logged in
if (!isLoggedIn()) {
    header("Location: ../signIn.php");
    exit();
}

// Get user details
$user_id = getUserId();
$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$phone = $conn->real_escape_string($_POST['phone']);
$email = $conn->real_escape_string($_POST['email']);
$city = $conn->real_escape_string($_POST['city']);
$payment_method = $conn->real_escape_string($_POST['payment_method']);

// Get cart items
$sql = "SELECT p.id, p.price, c.quantity 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Start transaction
$conn->begin_transaction();

try {
    // 1. Create order record
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Pending')");
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $order_id = $conn->insert_id;

    // 2. Add order items
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart_items as $item) {
        $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $stmt->execute();
        
        // Update product stock (optional)
        $conn->query("UPDATE products SET stock_quantity = stock_quantity - {$item['quantity']} WHERE id = {$item['id']}");
    }

    // 3. Clear cart
    $conn->query("DELETE FROM cart WHERE user_id = $user_id");

    // Commit transaction
    $conn->commit();

    // Redirect to success page
    header("Location: ../pages/order_success.php?order_id=$order_id");
    exit();

} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    error_log("Order failed: " . $e->getMessage());
    header("Location: ../cart.php?error=order_failed");
    exit();
}