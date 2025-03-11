<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header('Location: login_signup.php');
    exit();
}

require_once 'db.php';

// Fetch subjects from the database
$query = "SELECT * FROM subjects";
$stmt = $conn->prepare($query);
$stmt->execute();
$result_subjects = $stmt->get_result();

// Fetch quiz questions for the selected subject (will be set later)
$quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;
$questions = [];

if ($quiz_id > 0) {
    // Fetch quiz questions based on the selected quiz_id
    $query = "SELECT * FROM questions WHERE quiz_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result_questions = $stmt->get_result();
    $questions = $result_questions->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Quiz Page</title>
    <link rel="stylesheet" href="quiz.css">
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
            <?php if (isset($_SESSION['user_id'])): ?>
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

    <!-- Subject Selection -->
    <div class="subject-selection">
        <h2>Choose the Subject</h2>
        <form method="POST" action="quiz.php">
            <select name="quiz_id" onchange="this.form.submit()" required>
                <option value="">Select a Subject</option>
                
                <?php while ($subject = $result_subjects->fetch_assoc()) { ?>
                    <option value="<?php echo $subject['id']; ?>" <?php echo ($quiz_id == $subject['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($subject['subject_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </form>
    </div>

    <?php if (!empty($questions)) { ?>
        <div class="quiz-container">
            <form method="POST" action="submit_quiz.php">
                <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

                <?php 
                $question_number = 1;
                foreach ($questions as $question) { 
                ?>
                    <div class="question">
                        <h3>Question <?php echo $question_number; ?>: <?php echo htmlspecialchars($question['question_text']); ?></h3>
                        <input type="hidden" name="question_ids[]" value="<?php echo $question['id']; ?>">

                        <label><input type="radio" name="answer[<?php echo $question['id']; ?>]" value="A" required> <?php echo htmlspecialchars($question['option_A']); ?></label><br>
                        <label><input type="radio" name="answer[<?php echo $question['id']; ?>]" value="B"> <?php echo htmlspecialchars($question['option_B']); ?></label><br>
                        <label><input type="radio" name="answer[<?php echo $question['id']; ?>]" value="C"> <?php echo htmlspecialchars($question['option_C']); ?></label><br>
                        <label><input type="radio" name="answer[<?php echo $question['id']; ?>]" value="D"> <?php echo htmlspecialchars($question['option_D']); ?></label><br>
                    </div>
                <?php 
                    $question_number++;
                } ?>

                <input type="submit" value="Submit Quiz">
            </form>
        </div>
    <?php } ?>
</body>
</html>
