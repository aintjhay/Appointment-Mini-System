<?php
session_start();
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

$conn = new mysqli("localhost", "root", "", "sched_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
            a.*, 
            u.full_name AS patient_name, 
            u.gender, 
            TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age, 
            u.dob, 
            u.contact 
        FROM appointments a
        JOIN users u ON a.user_id = u.id
        ORDER BY a.date_created DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Appointments - LebKhim's Clinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            min-height: 100vh;
        }

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 100px auto 60px;
        }

        h1 {
            font-size: 3rem;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        .appointments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        @media (min-width: 1200px) {
            .appointments-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .appointment-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-header {
            margin-bottom: 12px;
        }

        .card-body p {
            margin: 5px 0;
            font-size: 1rem;
        }

        .card-actions {
            margin-top: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-actions a {
            flex: 1 1 48%;
            text-align: center;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 6px;
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .edit-btn { background-color: #3498db; }
        .edit-btn:hover { background-color: #2980b9; }

        .view-btn { background-color: #2ecc71; }
        .view-btn:hover { background-color: #27ae60; }

        .delete-btn { background-color: #e74c3c; }
        .delete-btn:hover { background-color: #c0392b; }

        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            display: inline-block;
            color: white;
        }

        .status-accepted { background-color: #27ae60; }
        .status-rejected { background-color: #e74c3c; }
        .status-pending { background-color: #95a5a6; }

        .back-home {
            display: inline-block;
            background-color: #e74c3c;
            color: white;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
            margin: 50px auto 0;
            text-align: center;
        }

        .back-home:hover {
            background-color: #c0392b;
        }

        @media (max-width: 768px) {
            .card-actions a {
                font-size: 0.85rem;
                padding: 7px 10px;
            }

            .card-body p {
                font-size: 0.95rem;
            }
        }

        /* ✅ Notifier styles */
        .notifier {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #2ecc71;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            font-weight: bold;
            font-size: 1rem;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeOut 4s ease forwards;
        }

        .notifier.rejected {
            background-color: #e74c3c;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; transform: translateY(-20px); }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- ✅ Notifier Section -->
    <?php if (isset($_GET['notif'])): ?>
        <div class="notifier <?= $_GET['notif'] === 'rejected' ? 'rejected' : '' ?>">
            <?php if ($_GET['notif'] === 'accepted'): ?>
                <i class="fas fa-check-circle"></i> Appointment accepted successfully!
            <?php elseif ($_GET['notif'] === 'rejected'): ?>
                <i class="fas fa-times-circle"></i> Appointment rejected.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <h1>Appointments</h1>

    <div class="appointments-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                    $status = strtolower($row['status']);
                    $badgeClass = 'status-badge ';
                    if ($status === 'accepted') {
                        $badgeClass .= 'status-accepted';
                    } elseif ($status === 'rejected') {
                        $badgeClass .= 'status-rejected';
                    } else {
                        $badgeClass .= 'status-pending';
                    }
                ?>
                <div class="appointment-card">
                    <div class="card-header">
                        <span class="<?= $badgeClass ?>"><?= htmlspecialchars($row['status']) ?></span>
                    </div>
                    <div class="card-body">
                        <p><strong>Patient:</strong> <?= htmlspecialchars($row['patient_name']) ?></p>
                        <p><strong>Gender:</strong> <?= htmlspecialchars($row['gender']) ?></p>
                        <p><strong>Age:</strong> <?= htmlspecialchars($row['age']) ?></p>
                        <p><strong>DOB:</strong> <?= htmlspecialchars($row['dob']) ?></p>
                        <p><strong>Contact:</strong> <?= htmlspecialchars($row['contact']) ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($row['date']) ?></p>
                        <p><strong>Time:</strong> <?= date("h:i A", strtotime($row['time'])) ?></p>
                        <p><strong>Created:</strong> <?= htmlspecialchars($row['date_created']) ?></p>
                    </div>
                    <div class="card-actions">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <a href="view.php?id=<?= $row['id'] ?>" class="view-btn">View</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                        <a href="update_status.php?id=<?= $row['id'] ?>&status=Accepted" class="edit-btn" onclick="return confirm('Accept this appointment?')">Accept</a>
                        <a href="update_status.php?id=<?= $row['id'] ?>&status=Rejected" class="delete-btn" onclick="return confirm('Reject this appointment?')">Reject</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 1.2rem;">No appointments found.</p>
        <?php endif; ?>
    </div>

    <div style="text-align: center;">
        <a href="home.php" class="back-home">&larr; Back to Home</a>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
