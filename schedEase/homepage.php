<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>LebKhim's Clinic - Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    /* Reset and base */
    * {
      box-sizing: border-box;
    }
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #fceae9; /* fallback background color */
      overflow: hidden;
    }

    /* Background image container */
    .background-image {
  position: fixed;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  background-color: limegreen; /* you can remove or keep */
  background-image: url('image/doctor.png');
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover; /* fully cover entire viewport */
  filter: blur(7px);
  transform: scale(1.05); /* scale up a bit to hide blur edges */
  z-index: 0;
}


    /* Background overlay to soften tint */
    .background-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(252, 234, 233, 0.5); /* subtle pink tint */
      z-index: 1;
      pointer-events: none; /* so clicks pass through */
    }

    /* Main content container */
    .content {
      position: relative;
      z-index: 10; /* above bg and overlay */
      height: 100vh;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #555;
      overflow-y: auto;
      gap: 20px;
    }

    /* Animations */
    @keyframes fadeSlideIn {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h1 {
      font-size: 4rem;
      color: #e74c3c;
      margin-bottom: 10px;
      text-shadow: 1px 1px 4px #c0392b;
      animation: fadeSlideIn 1s ease forwards;
    }

    p {
      font-size: 1.25rem;
      margin-bottom: 40px;
      max-width: 500px;
      animation: fadeSlideIn 1.5s ease forwards;
      opacity: 0;
      animation-fill-mode: forwards;
      animation-delay: 0.5s;
    }

    /* Buttons container */
    .btn-container {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
      width: 100%;
      max-width: 360px;
    }

    /* Buttons base */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 14px 30px;
      font-size: 1rem;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
      animation: fadeSlideIn 2s ease forwards;
      opacity: 0;
      animation-fill-mode: forwards;
      animation-delay: 1s;
      user-select: none;
      min-width: 160px;
    }

    /* Primary button: Login */
    .btn-primary {
      background-color: #e74c3c;
      color: white;
      border: none;
      box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
    }
    .btn-primary:hover, .btn-primary:focus {
      background-color: #c0392b;
      transform: scale(1.05);
      box-shadow: 0 6px 16px rgba(192, 57, 43, 0.6);
      outline: none;
    }
    .btn-primary:focus-visible {
      outline: 3px solid #c0392b;
      outline-offset: 3px;
    }

    /* Secondary button: Register */
    .btn-secondary {
      background-color: transparent;
      color: #e74c3c;
      border: 2px solid #e74c3c;
      box-shadow: none;
      transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-secondary:hover, .btn-secondary:focus {
      background-color: #e74c3c;
      color: white;
      box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
      outline: none;
      transform: scale(1.05);
    }
    .btn-secondary:focus-visible {
      outline: 3px solid #c0392b;
      outline-offset: 3px;
    }

    /* Icon spacing */
    .btn svg {
      margin-right: 8px;
      height: 1.2em;
      width: 1.2em;
      fill: currentColor;
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
      h1 {
        font-size: 2.5rem;
      }
      p {
        font-size: 1rem;
        margin-bottom: 30px;
      }
      .btn-container {
        flex-direction: column;
        max-width: none;
        gap: 15px;
      }
      .btn {
        width: 100%;
        min-width: unset;
        justify-content: center;
      }
    }
  </style>
</head>
<body>

  <div class="background-image"></div>
  <div class="background-overlay"></div>

  <div class="content">
    <h1>LebKhim's Clinic</h1>
    <p>Welcome to LebKhim’s Clinic! Please login or register to book an appointment.</p>

    <div class="btn-container">
    <a href="login.php" class="btn btn-primary" aria-label="Login to your account" id="loginBtn">
  <!-- Login Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px; width:1.2em; height:1.2em;">
    <path d="M15 12H3" />
    <path d="M10 17l5-5-5-5" />
  </svg>
  Login
</a>

<a href="register.php" class="btn btn-secondary" aria-label="Register a new account" id="registerBtn">
  <!-- Register Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px; width:1.2em; height:1.2em;">
    <line x1="12" y1="5" x2="12" y2="19" />
    <line x1="5" y1="12" x2="19" y2="12" />
  </svg>
  Register
</a>

    </div>
  </div>

</body>
</html>
