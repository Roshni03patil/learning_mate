<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if quiz ID is passed
if (isset($_GET['id'])) {
    $quiz_id = $_GET['id'];

    // Delete the quiz from the database
    $query = "DELETE FROM quizzes WHERE quiz_id = '$quiz_id'";
    if (mysqli_query($conn, $query)) {
        echo "Quiz deleted successfully!";
        header("Location: manage_quizzes.php"); // Redirect back to manage quizzes
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
