<?php
session_start(); // Start the session

// Check if the user is logged in
$is_logged_in = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>E-Learning Platform - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigation Bar -->
<header>
    <nav>
        <div class="logo">
            <img src="Assets/logo.png" alt="Learning Mate Logo" class="logo-img">
            <h2>Learning Mate</h2>
        </div>
        <ul class="nav-links">
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <?php if ($is_logged_in): ?>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <li><a href="profile.php"><i class="fa-solid fa-user-graduate"></i> Profile</a></li>
            <?php else: ?>
                <li><a href="login_signup.php"><i class="fas fa-sign-in-alt"></i> Login/Sign Up</a></li>
            <?php endif; ?>
            <li><a href="subjects.php"><i class="fa-solid fa-book"></i> Subjects</a></li>
            <li><a href="quiz.php"><i class="fa-solid fa-laptop-code"></i> Quiz</a></li>
        </ul>
    </nav>

</header>


<!-- Display Welcome Message if Logged In (Moved to Top) -->
<?php if ($is_logged_in): ?>
        <section class="welcome-message">
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <p>We're glad to have you back! Explore the subjects and enhance your learning experience.</p>
        </section>
    <?php endif; ?>

<!-- Hero Section -->
<main id="content">
    <div class="main-content-wrapper">
        <!-- Left Section: Hero -->
        <section class="hero">
            <h1>Welcome to Learning Mate!</h1>
            <p>Your Last-Minute Study Guide!</p>
            <a href="#subjects" class="cta-button">Browse Subjects</a>
        </section>

        <!-- Right Section: Single Image -->
        <div class="right-section">
            <div class="image-container">
                <img src="Assets/women.jpg" alt="Learning Image">
            </div>
        </div>
    </div>
</main>

<!-- Features Section -->
<section class="features">
    <h2>Why Choose Learning Mate?</h2>
    <div class="feature-container">
        <div class="feature-card">
            <i class="fas fa-book-open"></i>
            <h3>Wide Range of Subjects</h3>
            <p>Access various subjects and study materials at one place.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-search"></i>
            <h3>Smart Search</h3>
            <p>Find study materials quickly and efficiently.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-user-graduate"></i>
            <h3>Personalized Learning</h3>
            <p>Save your favorite notes and track your progress.</p>
        </div>
    </div>
</section>

<!-- Subjects Section -->
<section id="subjects">
    <h2>Popular Subjects</h2>
    <div class="subject-list">
        <div class="subject-card">
        <img src="Assets/dbmspic.jpg" alt="DBMS Image">
            <h3>DBMS</h3>
            <p>Explore data, columns, and manage systems.</p>
            <a href="<?php echo ($is_logged_in) ? 'subjects.php' : 'login_signup.php'; ?>">View Notes</a>
        </div>
        <div class="subject-card">
        <img src="Assets/computer.jpg" alt="Computer science Image">
            <h3>Computer Science</h3>
            <p>Learn programming, databases, and algorithms.</p>
            <a href="<?php echo ($is_logged_in) ? 'subjects.php' : 'login_signup.php'; ?>">View Notes</a>
        </div>
        <div class="subject-card">
        <img src="Assets/data.jpg" alt="DSA Image">
            <h3>DSA</h3>
            <p>Understand concepts with detailed explanations.</p>
            <a href="<?php echo ($is_logged_in) ? 'subjects.php' : 'login_signup.php'; ?>">View Notes</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials">
    <h2>What Our Students Say</h2>
    <div class="testimonial-container">
        <div class="testimonial">
        <img src="Assets/boy.jpg" alt="Student Photo" class="testimonial-img">
            <p>"I love how interactive and user-friendly Learning Mate is. 
                The subject cards and notes are just a click away — it’s a game-changer!"</p>
            <h4>- John Doe</h4>
        </div>
        <div class="testimonial">
        <img src="Assets/best.jpg" alt="Student Photo" class="testimonial-img">
            <p>"The best platform for last-minute study!"</p>
            <h4>- Sarah Smith</h4>
        </div>
        <div class="testimonial">
        <img src="Assets/guy.jpg" alt="Student Photo" class="testimonial-img">
            <p>"Thanks to Learning Mate, I can quickly find the notes I need and focus more on what truly matters — understanding the concepts."</p>
            <h4>- Abhay Singh</h4>
        </div>
        <div class="testimonial">
        <img src="Assets/study.jpg" alt="Student Photo" class="testimonial-img">
            <p>"Learning Mate helped me ace my exams! Highly recommended."</p>
            <h4>- Esha kapoor</h4>
        </div>
        
    </div>
</section>

<!-- Contact Us Section -->
<section class="contact">
    <h2>Contact Us</h2>
    <?php
    // Check if there's a success or error message in the URL
    if (isset($_GET['success'])) {
        echo "<p style='color: green;'>" . htmlspecialchars($_GET['success']) . "</p>";
    }
    if (isset($_GET['error'])) {
        echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>
    <form action="contact.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</section>

<!-- Footer Section -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-column about-us">
            <h3>About Us</h3>
            <p>Learning Mate is a platform dedicated to enhancing your learning experience with a wide range of subjects and resources.</p>
        </div>
        <div class="footer-column quick-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Blogs</a></li>
            </ul>
        </div>
        <div class="footer-column social-links">
            <h3>Follow Us</h3>
            <a href="#" class="social-icon"><i class="fa-brands fa-facebook"></i> Facebook</a>
            <a href="#" class="social-icon"><i class="fa-brands fa-twitter"></i> Twitter</a>
            <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i> Instagram</a>
            <a href="#" class="social-icon"><i class="fa-brands fa-linkedin"></i> LinkedIn</a>
            <a href="#" class="social-icon"><i class="fa-brands fa-youtube"></i> YouTube</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Learning Mate. All rights reserved.</p>
    </div>
</footer>

<!-- JavaScript -->
<script>
    // Smooth Scroll for Browse Subjects Button
    document.querySelector('.cta-button').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('subjects').scrollIntoView({ behavior: 'smooth' });
    });
</script>

</body>
</html>
