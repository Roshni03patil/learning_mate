<?php
// admin_logout.php

// Start the session to access session variables
session_start();

// Destroy all session variables
session_unset(); // Remove all session variables

// Destroy the session itself
session_destroy();

// Redirect the user to the login page after logging out
header("Location: admin_login.php"); 
exit();
?>
