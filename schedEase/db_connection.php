<?php
// Database connection
$host = 'localhost';
$username = 'root'; // Default MySQL username in XAMPP
$password = ''; // Default MySQL password in XAMPP
$dbname = 'sched'; // Your existing sched database

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>