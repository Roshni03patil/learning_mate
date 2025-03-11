<?php
// Initialize error and success messages
$error = $success = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate inputs
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email setup
        $to = "youremail@example.com"; // Replace with your email
        $subject = "New Contact Form Submission from $name";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email";

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "There was an error sending your message. Please try again.";
        }
    } else {
        $error = "Please fill in all fields correctly.";
    }

    // Redirect back to index.php with status messages
    header("Location: index.php?success=" . urlencode($success) . "&error=" . urlencode($error));
    exit();
}
?>
