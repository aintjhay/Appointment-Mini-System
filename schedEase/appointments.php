<?php
// Database connection
$host = 'localhost'; // Database host
$dbname = 'sched_db'; // Database name
$username = 'root';   // MySQL username
$password = '';       // MySQL password (leave empty if none for root)

$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch all appointments
$query = "SELECT * FROM appointments ORDER BY created_at DESC"; // Order by created_at to show the latest appointments
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments | LebKhim's Clinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            overflow-x: hidden;
        }

        nav {
            width: 100%;
            background-color: #333;
            padding: 12px 30px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        nav a:hover {
            color: #e74c3c;
        }

        .container {
            margin-top: 100px;
            width: 96%;
            max-width: 980px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .appointment-actions a {
            text-decoration: none;
            color: #e74c3c;
            font-weight: 600;
            margin-right: 10px;
        }

        .appointment-actions a:hover {
            color: #c0392b;
        }
    </style>
</head>
<body>

<nav>
    <a href="home.php">Home</a>
    <a href="index.php">Book Appointment</a>
    <a href="appointments.php">View Appointments</a>
</nav>

<div class="container">
    <h2>Appointments</h2>

    <?php
    if ($result->num_rows > 0) {
        // Table header
        echo "<table>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Reason</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Created At</th>
                </tr>";

        // Loop through the results and display them
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['full_name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['reason']) . "</td>
                    <td>" . htmlspecialchars($row['date']) . "</td>
                    <td>" . htmlspecialchars($row['time']) . "</td>
                    <td>" . htmlspecialchars($row['created_at']) . "</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No appointments found.</p>";
    }

    // Close the database connection
    $mysqli->close();
    ?>
</div>

</body>
</html>
