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

$appointment = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT 
                a.*, 
                u.full_name AS patient_name, 
                u.gender, 
                TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age, 
                u.dob, 
                u.contact 
            FROM appointments a
            JOIN users u ON a.user_id = u.id
            WHERE a.id = $id";

    $result = $conn->query($sql);
    if ($result && $result->num_rows === 1) {
        $appointment = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Appointment</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            max-width: 700px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .detail {
            margin-top: 20px;
        }

        .detail p {
            margin: 12px 0;
            font-size: 1rem;
            color: #444;
        }

        .label {
            font-weight: 600;
            color: #666;
        }

        .back-btn {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Appointment Details</h2>

    <?php if ($appointment): ?>
        <div class="detail">
            <p><span class="label">Status:</span> <?= htmlspecialchars($appointment['status']) ?></p>
            <p><span class="label">Patient Name:</span> <?= htmlspecialchars($appointment['patient_name']) ?></p>
            <p><span class="label">Gender:</span> <?= htmlspecialchars($appointment['gender']) ?></p>
            <p><span class="label">Age:</span> <?= htmlspecialchars($appointment['age']) ?></p>
            <p><span class="label">Date of Birth:</span> <?= htmlspecialchars($appointment['dob']) ?></p>
            <p><span class="label">Contact:</span> <?= htmlspecialchars($appointment['contact']) ?></p>
            <p><span class="label">Appointment Date:</span> <?= htmlspecialchars($appointment['date']) ?></p>
            <p><span class="label">Appointment Time:</span> <?= date("h:i A", strtotime($appointment['time'])) ?></p>
            <p><span class="label">Date Created:</span> <?= htmlspecialchars($appointment['date_created']) ?></p>
        </div>
    <?php else: ?>
        <p style="color:red;">Appointment not found.</p>
    <?php endif; ?>

    <a href="appointments.php" class="back-btn">&larr; Back to Appointments</a>
</div>

</body>
</html>

<?php $conn->close(); ?>
