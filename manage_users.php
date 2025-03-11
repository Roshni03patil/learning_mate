<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all users from the database
$query = "SELECT id, username, email, dob FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h1>

    <!-- Navigation Links for Admin -->
   

    <h2>Manage Users</h2>

    <!-- Table to display existing users -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['dob'] ? $user['dob'] : 'N/A'; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> |
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>
    <div class="center-buttons">
        <a href="admin_dashboard.php">Back to Dashboard</a>
        <a href="admin_logout.php" class="logout-button">Logout</a>
    </div>
    
   
</body>
</html>
