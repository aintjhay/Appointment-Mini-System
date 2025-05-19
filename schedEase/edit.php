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
$message = "";

// Get appointment data
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT 
                a.*, 
                u.full_name AS patient_name 
            FROM appointments a
            JOIN users u ON a.user_id = u.id
            WHERE a.id = $id";

    $result = $conn->query($sql);
    if ($result && $result->num_rows === 1) {
        $appointment = $result->fetch_assoc();
    }
}

// Update appointment on POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];

    $updateSql = "UPDATE appointments SET date = ?, time = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssi", $date, $time, $status, $id);

    if ($stmt->execute()) {
        $message = "Appointment updated successfully!";
        header("Location: appointments.php");
        exit;
    } else {
        $message = "Failed to update appointment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Appointment</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: 600;
            display: block;
            margin: 15px 0 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .btn {
            margin-top: 20px;
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .back-btn {
            background-color: #95a5a6;
            margin-left: 10px;
        }

        .message {
            margin-top: 15px;
            color: green;
            text-align: center;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Appointment</h2>

    <?php if ($appointment): ?>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?= $appointment['id'] ?>">

            <label>Patient Name</label>
            <input type="text" value="<?= htmlspecialchars($appointment['patient_name']) ?>" disabled>

            <label>Date</label>
            <input type="date" name="date" value="<?= htmlspecialchars($appointment['date']) ?>" required>

            <label>Time</label>
            <input type="time" name="time" value="<?= htmlspecialchars($appointment['time']) ?>" required>

            <label>Status</label>
            <select name="status" required>
                <option value="Pending" <?= $appointment['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Accepted" <?= $appointment['status'] === 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                <option value="Rejected" <?= $appointment['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>

            <button type="submit" name="update" class="btn">Update</button>
            <a href="appointments.php" class="btn back-btn">Cancel</a>
        </form>
    <?php else: ?>
        <p class="error">Appointment not found.</p>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
