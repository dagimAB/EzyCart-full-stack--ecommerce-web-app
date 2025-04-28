<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isset($_GET['order_id'])) {
    header("Location: ../index.php");
    exit();
}

$order_id = (int)$_GET['order_id'];
$user_id = isLoggedIn() ? getUserId() : 0;

// Verify order belongs to user
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../style/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <br><br>
    <div class="container">
        <h1>Order Confirmation</h1>
        <div class="order-success">
            <p>Thank you for your order!</p>
            <p>Your order ID is: <strong>#<?= $order['id'] ?></strong></p>
            <p>Total Amount: <strong>$<?= number_format($order['total_amount'], 2) ?></strong></p>
            <p>Status: <span class="status-badge"><?= $order['status'] ?></span></p>
            <br>
            <a href="../index.php" class="cont-shop-btn">Continue Shopping</a>
        </div>
    </div>
    <br>
    <br>
    <br>

    <?php include '../includes/footer.php'; ?>
</body>
</html>