<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header('Location: login_signup.php');
    exit();
}

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_id = $_POST['quiz_id'];
    $question_ids = $_POST['question_ids'];
    $answers = $_POST['answer'];

    // Initialize score counters
    $correct_count = 0;
    $wrong_count = 0;
    $total_questions = count($question_ids);

    // Calculate score
    foreach ($question_ids as $question_id) {
        $query = "SELECT correct_answer FROM questions WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $question = $result->fetch_assoc();

        if ($question && isset($answers[$question_id])) {
            if ($answers[$question_id] === $question['correct_answer']) {
                $correct_count++;
            } else {
                $wrong_count++;
            }
        }
    }

    // Calculate score
    $score = $correct_count;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="submit_quiz.css">
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

    <div class="result-container">
        <h2>Quiz Results</h2>
        <p>Total Questions: <?php echo $total_questions; ?></p>
        <p class="correct">Correct Answers: <?php echo $correct_count; ?></p>
        <p class="wrong">Wrong Answers: <?php echo $wrong_count; ?></p>
        <p class="score">Your Score: <?php echo $score; ?> out of <?php echo $total_questions; ?></p>
        <a href="quiz.php">Try Again</a>
    </div>
</body>
</html>