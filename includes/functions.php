<?php
// functions.php

// Ensure session is started correctly
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include config.php and ensure it's loaded once
if (file_exists(__DIR__ . '/../includes/config.php')) {
    require_once(__DIR__ . '/../includes/config.php');
} else {
    die('Config file not found!');
}

// Function to check if user is logged in
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

// Function to get current user ID
if (!function_exists('getUserId')) {
    function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }
}
?>