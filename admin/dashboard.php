<?php
session_start();
require_once('../includes/config.php');
require_once('../includes/functions.php');




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Resources/icons-and-logo/E-logo-correct.webp" type="image/x-icon">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./admin_styles/dashboard.css">
    <link rel="stylesheet" href="../style/styles.css">
</head>
<body>
    <?php include 'admin_header.php'; ?>


    <div class="admin-container">
        <h1>Admin Dashboard</h1>
        
        <div class="admin-stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <?php
                $sql = "SELECT COUNT(*) as total FROM users";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo "<p>" . $row['total'] . "</p>";
                ?>
            </div>
            
            <div class="stat-card">
                <h3>Total Products</h3>
                <?php
                $sql = "SELECT COUNT(*) as total FROM products";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo "<p>" . $row['total'] . "</p>";
                ?>
            </div>
            
            <div class="stat-card">
                <h3>Total Orders</h3>
                <?php
                $sql = "SELECT COUNT(*) as total FROM orders";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo "<p>" . $row['total'] . "</p>";
                ?>
            </div>
        </div>
        
        <div class="admin-actions">
            <a href="users.php" class="action-btn">Manage Users</a>
            <a href="products.php" class="action-btn">Manage Products</a>
            <a href="orders.php" class="action-btn">View Orders</a>
        </div>
    </div>
    <br>
    <br>
    <?php include '../includes/footer.php'; ?>
</body>
</html>