<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();
?>
