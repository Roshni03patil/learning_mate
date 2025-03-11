<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_signup.php"); // Redirect to login page if not logged in
    exit();
}

include 'db.php'; // Include the database connection

// Get the logged-in user's information from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profile.css"> <!-- Link to profile-specific CSS -->
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <img src="Assets/logo.png" alt="Learning Mate Logo" class="logo-img">
            <h2>Learning Mate</h2>
        </div>
        <ul class="nav-links">
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="subjects.php"><i class="fa-solid fa-book"></i> Subjects</a></li>
            <li><a href="quiz.php"><i class="fa-solid fa-laptop-code"></i> Quiz</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>

</header>

<!-- Profile Section -->
<section class="profile">
    <div class="profile-card">
        <h2>Profile Information</h2>
        <!-- Display Profile Picture -->
        <div class="profile-image">
            <?php if ($user['profile_picture']): ?>
                <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
            <?php else: ?>
                <img src="uploads/default_image.jpg" alt="Default Profile Picture">
            <?php endif; ?>
        </div>

        <!-- Display User Details -->
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
            <p><strong>Class:</strong> <?php echo htmlspecialchars($user['class']); ?></p>
        </div>

        <!-- Form to Update Profile Information -->
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="class" value="<?php echo htmlspecialchars($user['class']); ?>" placeholder="Class">
            <input type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" placeholder="Date of Birth">
            <input type="file" name="profile_picture" accept="image/*">
            <button type="submit">Update Profile</button>
        </form>
    </div>
</section>

</body>
</html>

<?php mysqli_close($conn); ?>
