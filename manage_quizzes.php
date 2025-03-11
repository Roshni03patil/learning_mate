<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all quizzes from the database
$query = "SELECT q.quiz_id, q.quiz_name, q.quiz_description, s.name AS subject_name 
          FROM quizzes q 
          JOIN subjects s ON q.subject_id = s.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Quizzes</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h1>Manage Quizzes</h1>

    <!-- Table to display existing quizzes -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Quiz Name</th>
                <th>Subject Name</th>
                <th>Quiz Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($quiz = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $quiz['quiz_id']; ?></td>
                <td><?php echo $quiz['quiz_name']; ?></td>
                <td><?php echo $quiz['subject_name']; ?></td>
                <td><?php echo $quiz['quiz_description']; ?></td>
                <td>
                    <a href="edit_quiz.php?id=<?php echo $quiz['quiz_id']; ?>">Edit</a> |
                    <a href="delete_quiz.php?id=<?php echo $quiz['quiz_id']; ?>" onclick="return confirm('Are you sure you want to delete this quiz?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>

    <!-- Form to add a new quiz -->
    <h3>Add New Quiz</h3>
    <form action="add_quiz.php" method="POST">
        <label for="quiz_name">Quiz Name:</label>
        <input type="text" id="quiz_name" name="quiz_name" required><br><br>

        <label for="subject_id">Select Subject:</label>
        <select id="subject_id" name="subject_id" required>
            <?php
            // Fetch all subjects to populate the dropdown
            $subjects_query = "SELECT id, name FROM subjects";
            $subjects_result = mysqli_query($conn, $subjects_query);
            while ($subject = mysqli_fetch_assoc($subjects_result)):
            ?>
                <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="quiz_description">Quiz Description:</label>
        <textarea id="quiz_description" name="quiz_description" required></textarea><br><br>

        <input type="submit" value="Add Quiz">
    </form>

    <br>
    <div class="center-buttons">
        <a href="admin_dashboard.php">Back to Dashboard</a>
        <a href="admin_logout.php" class="logout-button">Logout</a>
    </div>
    
</body>
</html>
