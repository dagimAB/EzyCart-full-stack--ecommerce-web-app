<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
redirectIfNotAdmin();

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = (int)$_GET['id'];

// Fetch order details
$order_sql = "SELECT o.*, u.first_name, u.last_name, u.email, u.phone 
              FROM orders o
              JOIN users u ON o.user_id = u.id
              WHERE o.id = ?";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Fetch order items
$items_sql = "SELECT oi.*, p.name as product_name, p.image_url 
              FROM order_items oi
              JOIN products p ON oi.product_id = p.id
              WHERE oi.order_id = ?";
$stmt = $conn->prepare($items_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Resources/icons-and-logo/E-logo-correct.webp" type="image/x-icon">
    <title>Order Details</title>
    <link rel="stylesheet" href="./admin_styles/order_details.css">
</head>
<body>
    <?php include './admin_header.php'; ?>
    
    <div class="container">
        <h1>Order Details #<?= $order['id'] ?></h1>
        
        <div class="order-info">
            <div class="customer-info">
                <h3>Customer Information</h3>
                <p><strong>Name:</strong> <?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
            </div>
            
            <div class="order-summary">
                <h3>Order Summary</h3>
                <p><strong>Order Date:</strong> <?= date('M j, Y g:i a', strtotime($order['created_at'])) ?></p>
                <p><strong>Status:</strong> <?= $order['status'] ?></p>
                <p><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2) ?></p>
            </div>
        </div>
        
        <h3>Order Items</h3>
        <table class="order-items">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>
                        <?php if ($item['image_url']): ?>
                        <img src="../uploads/<?= $item['image_url'] ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="product-image">
                        <?php else: ?>
                        <div class="no-image">No Image</div>
                        <?php endif; ?>
                    </td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="order-total">
            <p><strong>Total:</strong> $<?= number_format($order['total_amount'], 2) ?></p>
        </div>
        
        <a href="./orders.php" class="btn btn-back">Back to Orders</a>
    </div>
</body>
</html>