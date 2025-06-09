<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
redirectIfNotAdmin();
?>

<?php


if (isset($_GET['error'])) {
    $message = match($_GET['error']) {
        'self_delete' => 'You cannot delete your own account',
        'user_not_found' => 'User not found',
        'delete_failed' => 'Failed to delete user',
        default => 'An error occurred'
    };
    echo "<div class='alert error'>$message</div>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Resources/icons-and-logo/E-logo-correct.webp" type="image/x-icon">
    <link rel="stylesheet" href="./admin_styles/edit_users.css">
    <title>users</title>
</head>
<body>
    <?php include './admin_header.php' ?>
    <div class="user-mng">
        <h2>User Management</h2>
    </div>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT id, first_name, last_name, email, is_admin 
        FROM users 
        WHERE is_deleted = 0 
        ORDER BY id ASC";
        $result = $conn->query($sql);
        while ($user = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['first_name'].' '.$user['last_name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
            <td>
                <a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a>
                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                | <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</body>
</html>
