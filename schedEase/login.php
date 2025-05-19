<?php
session_start();

// Database connection variables
$servername = "localhost";
$dbusername = "root";       // change if your MySQL username is different
$dbpassword = "";           // change if your MySQL password is set
$dbname = "sched_db";       // replace with your actual database name

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = $conn->real_escape_string($_POST['username_email']);
    $password = $_POST['password'];

    // Query to find user by username or email
    $sql = "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // ✅ Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username']; // ✅ fixed: use user_name
            $_SESSION['is_admin'] = (bool)$user['is_admin'];

            // Redirect
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'home.php';
            header("Location: $redirect");
            exit();
        } else {
            $login_error = "Incorrect password.";
        }
    } else {
        $login_error = "No user found with that username or email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - LebKhim's Clinic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      animation: fadeInBody 1s ease-in-out;
    }

    @keyframes fadeInBody {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .login-container {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      width: 90%;
      max-width: 400px;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.6s ease-out forwards;
      text-align: center;
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .branding {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 25px;
    }

    .branding img {
      width: 50px;
      height: 50px;
      margin-right: 12px;
    }

    .branding h2 {
      margin: 0;
      color: #e74c3c;
      font-size: 1.6rem;
      font-weight: 600;
    }

    form {
      display: flex;
      flex-direction: column;
      text-align: left;
    }

    input[type="text"],
    input[type="password"] {
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #e74c3c;
      outline: none;
    }

    button {
      padding: 14px;
      background-color: #e74c3c;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: 600;
      margin-top: 10px;
    }

    button:hover {
      background-color: #c0392b;
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: 0.95rem;
      color: #666;
    }

    .register-link a {
      color: #e74c3c;
      text-decoration: none;
      font-weight: 600;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: red;
      margin-bottom: 15px;
      font-weight: 600;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="branding">
    <img src="image/download1.png" alt="Clinic Logo">
    <h2>LebKhim's Clinic</h2>
  </div>

  <?php if ($login_error): ?>
    <div class="error-message"><?= htmlspecialchars($login_error) ?></div>
  <?php endif; ?>

  <form action="" method="POST">
    <input type="text" name="username_email" placeholder="Username or Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Login</button>
  </form>

  <div class="register-link">
    Don't have an account? <a href="register.php">Register</a>
  </div>
</div>

</body>
</html>
