<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    header("Location: /EzyCart-PHP-orig/index.php");
    exit();
}
?>


        <nav class="admin-nav">
            <a href="../index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="../pages/logout.php">Logout</a>
        </nav>
