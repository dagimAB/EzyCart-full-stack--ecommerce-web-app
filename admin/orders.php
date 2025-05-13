<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
redirectIfNotAdmin();

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    
    header("Location: orders.php?success=Order status updated");
    exit();
}

// Fetch all orders with user information
$sql = "SELECT o.*, u.first_name, u.last_name 
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.created_at ASC";
$result = $conn->query($sql);
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="./admin_styles/orders.css">
</head>
<body>
    <?php include './admin_header.php'; ?>
    
    <div class="container">
        <h1>Order Management</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        
        <div class="order-filters">
            <select id="status-filter">
                <option value="all">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="Shipped">Shipped</option>
                <option value="Delivered">Delivered</option>
            </select>
            <input type="date" id="date-filter" placeholder="Filter by date">
        </div>
        
        <table class="order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr data-status="<?= $order['status'] ?>" data-date="<?= date('Y-m-d', strtotime($order['created_at'])) ?>">
                    <td>#<?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></td>
                    <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                    <td>
                        <form method="post" class="status-form">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="status" class="status-select">
                                <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Shipped" <?= $order['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-update">Update</button>
                        </form>
                    </td>
                    <td>
                        <a href="order_details.php?id=<?= $order['id'] ?>" class="btn btn-view">View Details</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



<script src="./admin_script/orders.js"></script>
</body>
</html>