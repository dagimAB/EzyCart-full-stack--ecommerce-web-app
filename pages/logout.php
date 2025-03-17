<?php
// logout.php

// Start the session
session_start();

// Destroy all session data
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the homepage or login page
header('Location: ../index.php'); // Change this to your desired redirect location
exit();
?>