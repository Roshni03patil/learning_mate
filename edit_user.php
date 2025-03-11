<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];

    $updateQuery = "UPDATE users SET username = ?, email = ?, dob = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $username, $email, $dob, $id);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?php echo $user['dob']; ?>"><br>
        <button type="submit">Update User</button>
    </form>
</body>
</html>
