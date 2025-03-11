<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Generate a reset token
        $token = bin2hex(random_bytes(50));
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send password reset email
        $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
        mail($email, "Password Reset", "Click here to reset your password: $reset_link");

        echo "Password reset link sent to your email!";
    } else {
        echo "No account found with that email.";
    }

    $stmt->close();
}
?>

<h2>Forgot Password?</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Enter your email" required><br>
    <button type="submit">Send Reset Link</button>
</form>
