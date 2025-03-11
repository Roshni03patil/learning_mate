<?php
session_start();
include 'db.php'; // Include database connection

// Handle login form submission
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}

// Handle signup form submission
if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Error signing up!";
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Login/Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Login/Signup Form Container -->
<div class="form-container">
    <div class="form-toggle">
        <button id="loginBtn" onclick="showLogin()">Login</button>
        <button id="signupBtn" onclick="showSignup()">Sign Up</button>
    </div>

    <!-- Login Form -->
    <div id="loginForm" class="form-content">
        <h2>Login</h2>
        <form method="POST" action="login_signup.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>

    <!-- Signup Form -->
    <div id="signupForm" class="form-content" style="display:none;">
        <h2>Sign Up</h2>
        <form method="POST" action="login_signup.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="signup">Sign Up</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</div>

<script>
    function showLogin() {
        document.getElementById("loginForm").style.display = "block";
        document.getElementById("signupForm").style.display = "none";
        document.getElementById("loginBtn").classList.add("active");
        document.getElementById("signupBtn").classList.remove("active");
    }

    function showSignup() {
        document.getElementById("loginForm").style.display = "none";
        document.getElementById("signupForm").style.display = "block";
        document.getElementById("loginBtn").classList.remove("active");
        document.getElementById("signupBtn").classList.add("active");
    }

    // Initialize to show login form by default
    window.onload = function() {
        showLogin();
    };
</script>

</body>
</html>
