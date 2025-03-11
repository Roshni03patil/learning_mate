<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_signup.php");
    exit();
}

include 'db.php'; // Include the database connection

$username = $_SESSION['username'];
$class = $_POST['class'];
$dob = $_POST['dob'];
$profile_picture = $_FILES['profile_picture'];

// Default profile picture handling
$profile_picture_name = null;
if ($profile_picture['name']) {
    // Generate a unique name for the file
    $profile_picture_name = time() . "_" . $profile_picture['name'];
    $target_path = "uploads/" . $profile_picture_name;

    // Move the uploaded file to the "uploads" folder
    move_uploaded_file($profile_picture['tmp_name'], $target_path);
}

// Update the user's profile information in the database
$sql = "UPDATE users SET class = ?, dob = ?, profile_picture = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $class, $dob, $profile_picture_name, $username);

if ($stmt->execute()) {
    // Redirect to profile page with success message
    header("Location: profile.php?success=Profile updated successfully");
} else {
    // Redirect to profile page with error message
    header("Location: profile.php?error=Failed to update profile");
}

$stmt->close();
mysqli_close($conn);
?>
