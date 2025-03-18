<?php
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../pages/signIn.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = getUserId();

    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>