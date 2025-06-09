<?php
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../pages/signIn.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = getUserId();
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Check if product exists in cart (existing code)
        $sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update quantity (existing code)
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        } else {
            // Insert new item (existing code)
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        
        // Commit if successful
        $conn->commit();
        
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        error_log("Cart update failed: " . $e->getMessage());
    }
    
    // Existing redirect (unchanged)
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>