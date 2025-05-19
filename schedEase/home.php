<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check admin role
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

// Extract first name from full name
$fullName = $_SESSION['full_name'] ?? '';
$firstName = explode(' ', $fullName)[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LebKhim's Clinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
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
            padding: 12px 15px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-left,
        .nav-right {
            display: flex;
            align-items: center;
        }

        .nav-left a,
        .nav-right a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .nav-left a:hover,
        .nav-right a:hover {
            color: #e74c3c;
        }

        .container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 60%;
            max-width: 600px;
            margin-top: 90px;
            margin-bottom: 50px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 1rem;
            color: #777;
            margin-bottom: 25px;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s 0.3s forwards;
        }

        .icon-container span {
            color: #333;
            font-size: 2rem;
            transition: color 0.3s ease, transform 0.3s ease;
            cursor: default;
        }

        .icon-container span:hover {
            color: #e74c3c;
            transform: scale(1.2);
        }

        .button {
            padding: 16px 30px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background 0.3s ease, transform 0.3s ease;
            margin-top: 30px;
        }

        .button:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .icon-container {
                flex-direction: column;
                gap: 10px;
            }

            .button {
                width: 100%;
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .services-section {
            width: 100%;
            padding: 60px 20px;
            background-color: #fdfdfd;
            text-align: center;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s 0.5s forwards;
        }

        .service-card {
            flex: 1 1 200px;
            max-width: 240px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards;
        }

        .service-card:nth-child(1) { animation-delay: 0.2s; }
        .service-card:nth-child(2) { animation-delay: 0.3s; }
        .service-card:nth-child(3) { animation-delay: 0.4s; }
        .service-card:nth-child(4) { animation-delay: 0.5s; }

        </style>
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <div class="nav-left">
        <a href="home.php">Home</a>
        <a href="months.php">Book Appointment</a>
        <?php if ($isAdmin): ?>
            <a href="appointments.php">Appointments</a>
        <?php endif; ?>
    </div>
    <div class="nav-right">
        <a href="logout.php">Logout</a>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <img src="image/download1.png" alt="LebKhim's Clinic Logo" class="logo">
    <h1>Welcome to LebKhim's Clinic</h1>
    <?php
$userName = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest';
?>
<h2>Hello,  <?php echo $userName; ?>👋!</h2>

    <p>Your health is our priority. Schedule your appointment today for a healthier tomorrow.</p>

    <div class="icon-container">
        <span title="Book an Appointment"><i class="fas fa-calendar-alt"></i></span>
        <span title="Contact Us"><i class="fas fa-phone-alt"></i></span>
        <span title="About Us"><i class="fas fa-info-circle"></i></span>
    </div>

    <a href="months.php" class="button" style="margin-top: 120px;">📅 Book Appointment</a>
</div>

<!-- Services Section -->
<div class="services-section">
    <h2 style="font-size: 2rem; margin-bottom: 40px; color: #333;">Services We Offer</h2>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">
        <div class="service-card">
            <i class="fas fa-user-md" style="font-size: 2rem; color: #e74c3c;"></i>
            <h3 style="font-size: 1.2rem; margin: 15px 0 10px;">General Check-up</h3>
            <p style="font-size: 0.95rem; color: #555;">Routine health exams for early detection and peace of mind.</p>
        </div>
        <div class="service-card">
            <i class="fas fa-baby" style="font-size: 2rem; color: #e74c3c;"></i>
            <h3 style="font-size: 1.2rem; margin: 15px 0 10px;">Pediatric Care</h3>
            <p style="font-size: 0.95rem; color: #555;">Compassionate care tailored for your little ones’ health.</p>
        </div>
        <div class="service-card">
            <i class="fas fa-syringe" style="font-size: 2rem; color: #e74c3c;"></i>
            <h3 style="font-size: 1.2rem; margin: 15px 0 10px;">Vaccinations</h3>
            <p style="font-size: 0.95rem; color: #555;">Protect yourself and your family with up-to-date immunizations.</p>
        </div>
        <div class="service-card">
            <i class="fas fa-notes-medical" style="font-size: 2rem; color: #e74c3c;"></i>
            <h3 style="font-size: 1.2rem; margin: 15px 0 10px;">Health Consultations</h3>
            <p style="font-size: 0.95rem; color: #555;">One-on-one discussions to guide your wellness journey.</p>
        </div>
    </div>
</div>

</body>
</html>