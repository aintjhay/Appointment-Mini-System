<?php
session_start();

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    header("Location: appointments.php");
    exit();
}

$id = intval($_GET['id']);
$status = $_GET['status'];

// Validate status value to prevent invalid inputs
$valid_statuses = ['Accepted', 'Rejected'];
if (!in_array($status, $valid_statuses)) {
    header("Location: appointments.php");
    exit();
}

// DB connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sched_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the appointment status
$stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();
$stmt->close();
$conn->close();

// Redirect back to appointments page with notifier param
$notif = strtolower($status) === 'accepted' ? 'accepted' : 'rejected';
header("Location: appointments.php?notif=$notif");
exit();
?>
