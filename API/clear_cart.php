<?php
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../pages/signIn.php");
    exit();
}

$user_id = getUserId();

$sql = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

header("Location: ../pages/cart.php");
exit();
?>