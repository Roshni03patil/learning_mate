<?php
session_start();
include 'db.php'; // Connect to database

// Check if admin is already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to find the admin
    $query = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    // Verify password (plain text — we'll upgrade to hashed later)
    if ($admin && $password === $admin['password']) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
