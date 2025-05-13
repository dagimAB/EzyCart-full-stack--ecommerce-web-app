<?php
// functions.php

// Ensure session is started correctly
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include config.php and ensure it's loaded once
if (file_exists(__DIR__ . '/config.php')) {
    require_once(__DIR__ . '/config.php');
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

// Function to check if user is admin
if (!function_exists('isAdmin')) {
    function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }
}

// Function to redirect non-admin users
if (!function_exists('redirectIfNotAdmin')) {
    function redirectIfNotAdmin() {
        if (!isAdmin()) {
            header("Location: ../index.php");
            exit();
        }
    }
}

// Function to log admin actions
if (!function_exists('logAdminAction')) {
    function logAdminAction($action) {
        global $conn;
        
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        $user_id = $_SESSION['user_id'];
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        try {
            $stmt = $conn->prepare("INSERT INTO admin_logs (user_id, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $action, $ip_address, $user_agent);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Failed to log admin action: " . $e->getMessage());
            return false;
        }
    }
}

// CSRF Protection Functions
if (!function_exists('generateCSRFToken')) {
    function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('validateCSRFToken')) {
    function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

// User Validation Functions
if (!function_exists('validateUserId')) {
    function validateUserId($id) {
        if (!is_numeric($id)) return false;
        
        global $conn;
        $stmt = $conn->prepare("SELECT id FROM users WHERE id = ? AND is_deleted = 0");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}

if (!function_exists('preventSelfAction')) {
    function preventSelfAction($target_user_id) {
        if ($target_user_id == $_SESSION['user_id']) {
            header("Location: users.php?error=self_action");
            exit();
        }
    }
}

// Input Sanitization
if (!function_exists('sanitizeInput')) {
    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}

// Database Helpers
if (!function_exists('getUserById')) {
    function getUserById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
}





// //Add this to your functions.php

if (!function_exists('getCategoryName')) {
    function getCategoryName($category_id) {
        global $conn;
        if (!$category_id) return "All Categories";
        
        $stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['name'] ?? 'Unknown Category';
    }
}
?>