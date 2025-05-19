<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "sched_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Check if the appointment exists first (optional but good practice)
    $check = $conn->prepare("SELECT id FROM appointments WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Appointment deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete appointment.";
        }
    } else {
        $_SESSION['message'] = "Appointment not found.";
    }

    $check->close();
} else {
    $_SESSION['message'] = "No appointment ID provided.";
}

$conn->close();
header("Location: appointments.php");
exit;
?>
