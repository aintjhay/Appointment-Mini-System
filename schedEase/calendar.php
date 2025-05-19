<?php
// calendar.php

date_default_timezone_set("Asia/Manila");

// Default current month and year
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Ensure $month is within the valid range (1-12)
if ($month < 1 || $month > 12) {
    $month = date('m');
}

$monthNames = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDayOfMonth = date("w", strtotime("$year-$month-01"));
$today = date("Y-m-d");

// Define if user is an admin (for demonstration purposes, assuming an admin session variable)
session_start();
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar | LebKhim's Clinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding-top: 60px; /* Adjusting for fixed navbar */
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .calendar-container {
            max-width: 800px;
            margin: auto;
            text-align: center;
            padding: 30px 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .calendar {
            border-collapse: collapse;
            width: 100%;
        }

        .calendar th,
        .calendar td {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            font-size: 1rem;
            border: 1px solid #ddd;
        }

        .calendar th {
            background-color: #f7f7f7;
            color: #333;
            font-weight: 600;
        }

        .calendar td {
            height: 100px;
            font-size: 1.1rem;
            color: #333;
        }

        .calendar .today {
            background-color: #d4edda;
        }

        .empty {
            background-color: #f9f9f9;
        }

        .btn-book {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            margin-top: 10px;
            font-size: 0.9rem;
            text-decoration: none;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-book:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .btn-book.disabled {
            background-color: #dc3545; /* red */
            cursor: not-allowed;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-book.disabled:hover {
            background-color: #c82333;
        }

        .month-navigation {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .month-navigation button {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .month-navigation button:hover {
            background-color: #218838;
        }

        .back-link {
            margin-top: 30px;
        }

        .back-link a {
            text-decoration: none;
            color: #fff;
            background-color: #6c757d;
            padding: 10px 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .back-link a:hover {
            background-color: #5a6268;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            padding: 12px 30px;
            z-index: 100;
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

    </style>
</head>
<body>

<!-- Fixed Navigation Bar -->
<nav>
    <a href="home.php">Home</a>
    <a href="months.php">Book Appointment</a>
    <?php if ($isAdmin): ?>
        <a href="appointments.php">Appointments</a>
    <?php endif; ?>
</nav>

<div class="calendar-container">
    <h2>Calendar for <?= $monthNames[$month] . ' ' . $year ?></h2>

    <table class="calendar">
        <thead>
            <tr>
                <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th>
                <th>Thu</th><th>Fri</th><th>Sat</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $day = 1;
            $cellCount = 0;
            echo "<tr>";

            for ($i = 0; $i < $firstDayOfMonth; $i++) {
                echo "<td class='empty'></td>";
                $cellCount++;
            }

            while ($day <= $daysInMonth) {
                $currentDate = date("Y-m-d", strtotime("$year-$month-$day"));
                echo "<td>";
                echo "<div>$day</div>";

                if ($currentDate >= $today) {
                    $formattedDate = date("m-d-Y", strtotime($currentDate));
                    echo "<a class='btn-book' href='index.php?date=$formattedDate'>Book Now</a>";
                } else {
                    echo "<div class='btn-book disabled'>N/A</div>";
                }

                echo "</td>";
                $day++;
                $cellCount++;

                if ($cellCount % 7 === 0 && $day <= $daysInMonth) {
                    echo "</tr><tr>";
                }
            }

            while ($cellCount % 7 !== 0) {
                echo "<td class='empty'></td>";
                $cellCount++;
            }

            echo "</tr>";
            ?>
        </tbody>
    </table>

    <div class="month-navigation">
        <form method="get" action="calendar.php">
            <input type="hidden" name="year" value="<?= ($month == 1) ? $year - 1 : $year ?>">
            <button type="submit" name="month" value="<?= ($month == 1) ? 12 : $month - 1 ?>">← Previous</button>
        </form>
        <form method="get" action="calendar.php">
            <input type="hidden" name="year" value="<?= ($month == 12) ? $year + 1 : $year ?>">
            <button type="submit" name="month" value="<?= ($month == 12) ? 1 : $month + 1 ?>">Next →</button>
        </form>
    </div>

    <div class="back-link">
        <a href="months.php">← Back to Months</a>
    </div>
</div>

</body>
</html>
