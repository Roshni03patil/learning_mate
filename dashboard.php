<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.html");
    exit();
}

// Display the dashboard
echo "Welcome, " . $_SESSION['username'];
?>
