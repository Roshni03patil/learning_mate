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
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $pdf_link = mysqli_real_escape_string($conn, $_POST['pdf_link']);

    // Handle the file upload for the subject image
    $image_path = "uploads/" . basename($_FILES['subject_image']['name']);
    move_uploaded_file($_FILES['subject_image']['tmp_name'], $image_path);

    // Insert the new subject into the database
    $query = "INSERT INTO subjects (name, subject_name, pdf_link, subject_image) 
              VALUES ('$name', '$subject_name', '$pdf_link', '$image_path')";

    if (mysqli_query($conn, $query)) {
        echo "Subject added successfully!";
        header("Location: manage_subjects.php"); // Redirect back to manage subjects
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
