<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login_signup.php");
    exit();
}

include 'db.php'; // Include the database connection

// Fetch subjects from the database
$sql = "SELECT id, name, subject_name, pdf_link, subject_image FROM subjects";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Subjects</title>
    <link rel="stylesheet" href="subjects.css">
</head>
<body>

<!-- Header -->
<header>
    <div class="logo">
        <img src="Assets/logo.png" alt="Learning Mate Logo">
        <h2>Learning Mate</h2>
    </div>
    <nav>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <li><a href="profile.php"><i class="fas fa-user-graduate"></i> Profile</a></li>
                <li><a href="subjects.php"><i class="fas fa-book"></i> Subjects</a></li>
            <?php else: ?>
                <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <li><a href="signup.php"><i class="fas fa-user-plus"></i> Sign Up</a></li>
            <?php endif; ?>
            <li><a href="quiz.php"><i class="fas fa-question-circle"></i> Quiz</a></li>
        </ul>
    </nav>
</header>

<!-- Main content area -->
<div class="container">
    
    <input type="text" class="search-box" id="searchInput" onkeyup="filterSubjects()" placeholder="Search subjects...">

    <div id="subjectsList">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="subject-card">';
                
                // Display image if available
                if (!empty($row['subject_image'])) {
                    echo '<img src="' . htmlspecialchars($row['subject_image']) . '" class="subject-image" alt="' . htmlspecialchars($row['subject_name']) . '">';
                } else {
                    echo '<img src="uploads/default_image.jpg" class="subject-image" alt="Default Image">';
                }

                echo '<div class="subject-details">';
                echo '<div class="subject-title">' . htmlspecialchars($row['subject_name']) . '</div>';
                
                // Optional description field
                echo '<div class="subject-description">A brief description of the subject goes here...</div>';

                // Display PDF link if available
                if (!empty($row['pdf_link'])) {
                    echo '<a class="read-notes" href="' . htmlspecialchars($row['pdf_link']) . '" target="_blank">Read Notes</a>';
                } else {
                    echo '<p class="no-notes">No notes available</p>';
                }

                echo '</div></div>';
            }
        } else {
            echo "<p>No subjects available.</p>";
        }
        ?>
    </div>
</div>

<script>
    function filterSubjects() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let cards = document.querySelectorAll(".subject-card");

        cards.forEach(card => {
            let title = card.querySelector(".subject-title").innerText.toLowerCase();
            if (title.includes(input)) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
            }
        });
    }
</script>

</body>
</html>

<?php mysqli_close($conn); ?>
