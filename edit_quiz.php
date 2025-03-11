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

    // Fetch quiz details from the database
    $query = "SELECT * FROM quizzes WHERE quiz_id = '$quiz_id'";
    $result = mysqli_query($conn, $query);
    $quiz = mysqli_fetch_assoc($result);
} else {
    // If no quiz ID is provided, redirect to manage quizzes page
    header("Location: manage_quizzes.php");
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_name = mysqli_real_escape_string($conn, $_POST['quiz_name']);
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $quiz_description = mysqli_real_escape_string($conn, $_POST['quiz_description']);

    // Update the quiz details in the database
    $query = "UPDATE quizzes 
              SET quiz_name = '$quiz_name', subject_id = '$subject_id', quiz_description = '$quiz_description' 
              WHERE quiz_id = '$quiz_id'";

    if (mysqli_query($conn, $query)) {
        echo "Quiz updated successfully!";
        header("Location: manage_quizzes.php"); // Redirect back to manage quizzes
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Quiz</title>
</head>
<body>
    <h1>Edit Quiz</h1>

    <form action="" method="POST">
        <label for="quiz_name">Quiz Name:</label>
        <input type="text" id="quiz_name" name="quiz_name" value="<?php echo $quiz['quiz_name']; ?>" required><br><br>

        <label for="subject_id">Select Subject:</label>
        <select id="subject_id" name="subject_id" required>
            <?php
            // Fetch all subjects to populate the dropdown
            $subjects_query = "SELECT id, name FROM subjects";
            $subjects_result = mysqli_query($conn, $subjects_query);
            while ($subject = mysqli_fetch_assoc($subjects_result)):
            ?>
                <option value="<?php echo $subject['id']; ?>" <?php echo ($quiz['subject_id'] == $subject['id']) ? 'selected' : ''; ?>><?php echo $subject['name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="quiz_description">Quiz Description:</label>
        <textarea id="quiz_description" name="quiz_description" required><?php echo $quiz['quiz_description']; ?></textarea><br><br>

        <input type="submit" value="Update Quiz">
    </form>

    <br>
    <a href="manage_quizzes.php">Back to Manage Quizzes</a>
</body>
</html>
