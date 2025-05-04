<?php
include 'db.php';

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$date = $_POST['date'];
$time = $_POST['time'];

// Check for conflict
$sql = "SELECT * FROM appointments WHERE date = '$date' AND time = '$time'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "This slot is already booked. Please choose another time.";
} else {
    $stmt = $conn->prepare("INSERT INTO appointments (full_name, email, date, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $date, $time);
    $stmt->execute();
    echo "Appointment booked successfully!";
}
?>
