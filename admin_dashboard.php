<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch admin information (optional)
$admin_username = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h1>Welcome, <?php echo $admin_username; ?>!</h1>
    
    <!-- Navigation for admin dashboard -->
    <nav>
        <ul>
            <li><a href="manage_users.php">Manage Users</a></li> <!-- Link to manage users page -->
            <li><a href="manage_subjects.php">Manage Subjects</a></li> <!-- Link to manage subjects page -->
            <li><a href="manage_quizzes.php">Manage Quizzes</a></li> <!-- Link to manage quizzes page -->
           
        </ul>
    </nav>

    <div class="center-buttons">
      
        <a href="admin_logout.php" class="logout-button">Logout</a>
    </div>

    

    <br>
</body>
</html>
