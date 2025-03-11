<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all subjects from the database
$query = "SELECT * FROM subjects";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Subjects</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h1>Manage Subjects</h1>

    <!-- Table to display existing subjects -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Subject Name</th>
                <th>PDF Link</th>
                <th>Subject Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($subject = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $subject['id']; ?></td>
                <td><?php echo $subject['name']; ?></td>
                <td><?php echo $subject['subject_name']; ?></td>
                <td><a href="<?php echo $subject['pdf_link']; ?>" target="_blank">View PDF</a></td>
                <td><img src="<?php echo $subject['subject_image']; ?>" alt="Subject Image" width="100"></td>
                <td>
                    <a href="edit_subject.php?id=<?php echo $subject['id']; ?>">Edit</a> |
                    <a href="delete_subject.php?id=<?php echo $subject['id']; ?>" onclick="return confirm('Are you sure you want to delete this subject?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>

    <!-- Form to add a new subject -->
    <h3>Add New Subject</h3>
    <form action="add_subject.php" method="POST" enctype="multipart/form-data">
        <label for="name">Subject Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="subject_name">Subject Details:</label>
        <input type="text" id="subject_name" name="subject_name" required><br><br>

        <label for="pdf_link">PDF Link:</label>
        <input type="text" id="pdf_link" name="pdf_link" required><br><br>

        <label for="subject_image">Subject Image:</label>
        <input type="file" id="subject_image" name="subject_image" required><br><br>

        <input type="submit" value="Add Subject">
    </form>

    <div class="center-buttons">
        <a href="admin_dashboard.php">Back to Dashboard</a>
        
    </div>
    
</body>
</html>
