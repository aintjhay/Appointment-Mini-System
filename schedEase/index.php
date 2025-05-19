<?php
$date = isset($_GET['date']) ? $_GET['date'] : null;

$formattedDate = null;
$selectedDate = null;

if ($date) {
    // Assume MM-DD-YYYY format explicitly
    $parts = explode('-', $date);
    if (count($parts) === 3) {
        list($month, $day, $year) = $parts;
        // Validate numbers
        if (checkdate((int)$month, (int)$day, (int)$year)) {
            // Build timestamp
            $timestamp = mktime(0, 0, 0, (int)$month, (int)$day, (int)$year);
            $formattedDate = date("F d, Y", $timestamp);
            $selectedDate = date("Y-m-d", $timestamp);
        } else {
            echo "<p style='color:red;'>Invalid date components: " . htmlspecialchars($date) . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Invalid date format received: " . htmlspecialchars($date) . "</p>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Your Details & Time Slot | LebKhim's Clinic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <style>
    /* Your existing styles */
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
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
      max-width: 580px;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      padding: 40px;
      box-sizing: border-box;
      text-align: center;
      animation: fadeUp 0.6s ease-out;
    }

    .selected-date {
      font-size: 1.25rem;
      color: #28a745;
      text-align: center;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .timeslot-button {
      display: inline-block;
      background-color: #28a745;
      color: white;
      padding: 12px 30px;
      margin: 5px;
      font-size: 1rem;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: background-color 0.3s ease, transform 0.1s ease;
    }

    .timeslot-button:hover {
      background-color: #333;
    }

    .timeslot-button:active {
      background-color: #5a5a5a;
      transform: scale(0.97);
    }

    .time-slots {
      margin-bottom: 30px;
    }

    .timeslot-selected {
      background-color: #6c757d !important;
      color: white;
      animation: pulse 0.3s ease;
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.06); }
      100% { transform: scale(1); }
    }

    .submit-btn {
      padding: 12px 30px;
      background-color: #28a745;
      color: white;
      font-size: 1rem;
      border-radius: 6px;
      border: none;
      transition: background 0.3s ease;
      cursor: pointer;
      width: 100%;
      margin-top: 20px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .submit-btn:hover {
      background-color: #218838;
    }

    .back-btn {
      margin-top: 20px;
      background-color: #6c757d;
      color: white;
      padding: 10px 18px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 1rem;
      transition: background-color 0.3s ease;
      display: inline-block;
    }

    .back-btn:hover {
      background-color: #5a6268;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<nav>
  <a href="home.php">Home</a>
  <a href="months.php">Book Appointment</a>
</nav>

<div class="container">
  <?php if ($formattedDate): ?>
    <div class="selected-date">Book for date: <?= htmlspecialchars($formattedDate) ?></div>
  <?php else: ?>
    <div class="selected-date" style="color: #dc3545;">Please select a date first.</div>
  <?php endif; ?>

  <a href="months.php" class="back-btn">← Change Date</a>

  <div class="time-slots">
    <h4>Select a Time Slot</h4>
    <button type="button" class="timeslot-button" data-time="09:00:00">09:00 AM</button>
    <button type="button" class="timeslot-button" data-time="10:00:00">10:00 AM</button>
    <button type="button" class="timeslot-button" data-time="11:00:00">11:00 AM</button>
    <button type="button" class="timeslot-button" data-time="13:00:00">01:00 PM</button>
    <button type="button" class="timeslot-button" data-time="14:00:00">02:00 PM</button>
    <button type="button" class="timeslot-button" data-time="15:00:00">03:00 PM</button>
  </div>

  <!-- Form for Appointment Submission -->
  <form action="submit_appointment.php" method="POST" id="appointmentForm" onsubmit="return validateForm()">
    <?php if ($selectedDate): ?>
      <input type="hidden" name="date" value="<?= htmlspecialchars($selectedDate) ?>">
    <?php endif; ?>
    <!-- time input will be added dynamically by JS -->
    <button class="submit-btn" type="submit"><i class="fas fa-check-circle icon"></i> Book Appointment</button>
  </form>
</div>

<script>
  const timeslotButtons = document.querySelectorAll('.timeslot-button');
  let selectedTimeslot = null;

  timeslotButtons.forEach(button => {
    button.addEventListener('click', function () {
      timeslotButtons.forEach(btn => btn.classList.remove('timeslot-selected'));
      this.classList.add('timeslot-selected');
      selectedTimeslot = this.dataset.time;

      let input = document.querySelector('input[name="time"]');
      if (!input) {
        input = document.createElement("input");
        input.type = "hidden";
        input.name = "time";
        document.getElementById("appointmentForm").appendChild(input);
      }
      input.value = selectedTimeslot;
    });
  });

  function validateForm() {
    if (!selectedTimeslot) {
      alert('Please select a time slot before proceeding.');
      return false;
    }
    return true;
  }
</script>

</body>
</html>
