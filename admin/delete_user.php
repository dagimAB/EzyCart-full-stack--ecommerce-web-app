<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
redirectIfNotAdmin();

// Verify CSRF token
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: users.php?error=invalid_id");
    exit();
}

$user_id = (int)$_GET['id'];

// Prevent self-deletion
if ($user_id === $_SESSION['user_id']) {
    header("Location: users.php?error=self_delete");
    exit();
}

// Check if user exists
$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: users.php?error=user_not_found");
    exit();
}



$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$success = $stmt->execute();

if ($success) {
    // Log the deletion
    logAdminAction("Deleted user ID: $user_id");
    header("Location: users.php?success=user_deleted");
} else {
    header("Location: users.php?error=delete_failed");
}
exit();
?>