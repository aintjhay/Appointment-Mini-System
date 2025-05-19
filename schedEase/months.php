<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Month | LebKhim's Clinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            height: auto;
            flex-direction: column;
            text-align: center;
            overflow-y: auto;
            scroll-behavior: smooth;
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

        .calendar-container {
            max-width: 1000px; /* Reverted to original size */
            margin: auto;
            text-align: center;
            padding: 30px 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            animation: fadeIn 1s ease-in-out;
            margin-top: 90px; /* Added margin for navbar */
        }

        .month-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .month-card {
            background-color: #28a745;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .month-card:hover {
            transform: scale(1.05);
            background-color: #218838;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .month-name {
            font-size: 1.2rem;
            font-weight: 500;
            text-decoration: none;
            color: white;
            display: block;
            transition: color 0.3s ease;
        }

        .month-name:hover {
            color: #e2f7e9;
        }

        .back-home {
            margin-top: 30px;
        }

        .back-home a {
            background-color: #6c757d;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .back-home a:hover {
            background-color: #5a6268;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <a href="home.php">Home</a>
    <a href="index.php">Book Appointment</a>
    <?php if ($isAdmin): ?>
        <a href="appointments.php">Appointments</a>
    <?php endif; ?>
</nav>

<div class="calendar-container">
    <h2>Select a Month</h2>

    <!-- Month Grid -->
    <div class="month-grid">
        <?php
        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        foreach ($monthNames as $monthNumber => $monthName) {
            echo "<a href='calendar.php?month=$monthNumber' class='month-card'>";
            echo "<span class='month-name'>$monthName</span>";
            echo "</a>";
        }
        ?>
    </div>

    <!-- Back to Home Button -->
    <div class="back-home">
        <a href="home.php">← Back to Home</a>
    </div>
</div>

</body>
</html>
