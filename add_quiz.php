<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_name = mysqli_real_escape_string($conn, $_POST['quiz_name']);
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $quiz_description = mysqli_real_escape_string($conn, $_POST['quiz_description']);

    // Insert the new quiz into the database
    $query = "INSERT INTO quizzes (quiz_name, subject_id, quiz_description) 
              VALUES ('$quiz_name', '$subject_id', '$quiz_description')";
    if (mysqli_query($conn, $query)) {
        echo "Quiz added successfully!";
        header("Location: manage_quizzes.php"); // Redirect back to manage quizzes
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
