<?php
// Replace with your database connection
$host = 'localhost';
$db = 'sched_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';

    if ($full_name && $email && $reason && $date && $time) {
        $stmt = $conn->prepare("INSERT INTO appointments (full_name, email, reason, date, time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $email, $reason, $date, $time);
        $stmt->execute();
        $stmt->close();

        header("Location: success.php"); // Or show success message here
        exit();
    } else {
        echo "Please fill in all fields.";
    }
}
$conn->close();
?>
