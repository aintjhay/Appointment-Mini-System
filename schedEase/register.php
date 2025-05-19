<?php
session_start();

// Database connection variables
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "sched_db"; // Change this to your DB name

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize inputs
    $username = trim($conn->real_escape_string($_POST['username']));
    $email = trim($conn->real_escape_string($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($conn->real_escape_string($_POST['full_name']));
    $gender = trim($conn->real_escape_string($_POST['gender']));
    $dob = trim($conn->real_escape_string($_POST['dob']));
    $contact = trim($conn->real_escape_string($_POST['contact']));

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($full_name) || empty($gender) || empty($dob) || empty($contact)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Check if username or email already exists
    $check_sql = "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Username or Email already taken.";
    }
    $stmt->close();

    // If no errors, insert new user
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_sql = "INSERT INTO users (username, email, password, full_name, gender, dob, contact, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssssss", $username, $email, $hashed_password, $full_name, $gender, $dob, $contact);

        if ($stmt->execute()) {
            // Registration success
            $_SESSION['success_message'] = "Registration successful! You can now log in.";
            header("Location: login.php");
            exit;
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register - LebKhim's Clinic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    /* Same style as login for consistency */
    * { box-sizing: border-box; }
    body {
      margin: 0; padding: 0;
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
    .register-container {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      width: 90%;
      max-width: 500px;
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
    input[type="email"],
    input[type="password"],
    input[type="date"],
    select {
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border 0.3s ease;
      width: 100%;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="date"]:focus,
    select:focus {
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
    .login-link {
      text-align: center;
      margin-top: 20px;
      font-size: 0.95rem;
      color: #666;
    }
    .login-link a {
      color: #e74c3c;
      text-decoration: none;
      font-weight: 600;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
    .error-message {
      color: red;
      font-weight: 600;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="register-container">
  <div class="branding">
    <img src="image/download1.png" alt="Clinic Logo" />
    <h2>LebKhim's Clinic</h2>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="error-message">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="" method="POST" autocomplete="off">
    <input type="text" name="username" placeholder="Username" required value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" />
    <input type="email" name="email" placeholder="Email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" />
    <input type="password" name="password" placeholder="Password" required />
    <input type="password" name="confirm_password" placeholder="Confirm Password" required />
    <input type="text" name="full_name" placeholder="Full Name" required value="<?= isset($full_name) ? htmlspecialchars($full_name) : '' ?>" />
    <select name="gender" required>
      <option value="" disabled <?= !isset($gender) ? 'selected' : '' ?>>Select Gender</option>
      <option value="Male" <?= (isset($gender) && $gender == 'Male') ? 'selected' : '' ?>>Male</option>
      <option value="Female" <?= (isset($gender) && $gender == 'Female') ? 'selected' : '' ?>>Female</option>
      <option value="Other" <?= (isset($gender) && $gender == 'Other') ? 'selected' : '' ?>>Other</option>
    </select>
    <input type="date" name="dob" placeholder="Date of Birth" required value="<?= isset($dob) ? htmlspecialchars($dob) : '' ?>" />
    <input type="text" name="contact" placeholder="Contact Number" required value="<?= isset($contact) ? htmlspecialchars($contact) : '' ?>" />

    <button type="submit">Register</button>
  </form>

  <div class="login-link">
    Already have an account? <a href="login.php">Login</a>
  </div>
</div>

</body>
</html>