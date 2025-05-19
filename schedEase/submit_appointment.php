<?php
session_start();

// Enable error reporting for MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// DB connection
$conn = new mysqli("localhost", "root", "", "sched_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in user ID from session
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';

    if ($user_id && $date && $time) {
        $stmt = $conn->prepare("INSERT INTO appointments (user_id, `date`, `time`) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $date, $time);
        $stmt->execute();
        $stmt->close();

        header("Location: success.php");
        exit();
    } else {
        echo "Please select a date and time and ensure you're logged in.";
    }
}

$conn->close();
?>
