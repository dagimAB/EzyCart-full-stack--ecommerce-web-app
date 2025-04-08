<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
redirectIfNotAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $id = (int)$_POST['id'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    
    $stmt = $conn->prepare("UPDATE users SET is_admin = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_admin, $id);
    $stmt->execute();
    
    header("Location: users.php");
    exit();
}

// Get user data
$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT id, first_name, last_name, email, is_admin FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./admin_styles/edit_users.css">
    <title>edit-user</title>
</head>
<body>
    <?php include './admin_header.php' ?>
    <div class="edit-user">
        <h2>Edit User</h2>
    </div>
<form method="post">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">
    
    <div class="form-group">
        <label>Name:</label>
        <p><?= htmlspecialchars($user['first_name'].' '.$user['last_name']) ?></p>
    </div>
    
    <div class="form-group">
        <label>Email:</label>
        <p><?= htmlspecialchars($user['email']) ?></p>
    </div>
    
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_admin" <?= $user['is_admin'] ? 'checked' : '' ?>>
            Administrator
        </label>
    </div>
    
    <button type="submit" class="user_btn">Save Changes</button>
</form> 
</body>
</html>

