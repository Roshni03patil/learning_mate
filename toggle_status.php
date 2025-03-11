<?php
session_start();
include('db.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Get the current status
    $sql = "SELECT status FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $new_status = $user['status'] == 'active' ? 'inactive' : 'active';

        // Update the user status
        $sql = "UPDATE users SET status = '$new_status' WHERE id = $user_id";
        mysqli_query($conn, $sql);
    }
}

header("Location: admin_manage_users.php");
exit();
