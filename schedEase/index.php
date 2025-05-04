<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Date & Time | LebKhim's Clinic</title>
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
            max-width: 580px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #28a745;
        }

        .icon {
            font-size: 18px;
            margin-right: 8px;
        }

        .available-times {
            margin-top: 15px;
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
        }

        .available-times.show {
            opacity: 1;
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

        .details-container h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .details-container textarea {
            resize: vertical;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<nav>
    <a href="home.php">Home</a>
    <a href="index.php">Book Appointment</a>
</nav>

<div class="container">
        <h3 id="selectedDate">BOOK AN APPOINTMENT</h3>

    <form action="submit_appointment.php" method="POST" id="appointmentForm" onsubmit="return validateForm()">
        <!-- Date Picker -->
        <div class="form-group">
            <label for="calendar"><i class="fas fa-calendar-day icon"></i>Select Date</label>
            <input type="date" id="calendar" onchange="updateDateTime()" min="">
        </div>

        <!-- Full Name -->
        <div class="form-group">
            <label for="name"><i class="fas fa-user icon"></i>Full Name</label>
            <input type="text" id="name" name="full_name" placeholder="Your name">
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope icon"></i>Email Address</label>
            <input type="email" id="email" name="email" placeholder="Your email">
        </div>

        <!-- Reason for Appointment -->
        <div class="form-group">
            <label for="reason"><i class="fas fa-stethoscope icon"></i>Reason for Appointment</label>
            <textarea id="reason" name="reason" rows="3" placeholder="Describe the reason for your visit..."></textarea>
        </div>

        <!-- Hidden Date Input -->
        <input type="hidden" id="selected_date_input" name="date">

        <!-- Available Time Slots -->
        <div class="available-times" id="availableTimes">
            <p>Select a date to view available time slots.</p>
        </div>

        <!-- Submit Button -->
        <button class="submit-btn" type="submit"><i class="fas fa-check-circle icon"></i>Book Appointment</button>
    </form>
</div>

<script>
    // Set today's date as the minimum
    window.onload = () => {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('calendar').setAttribute('min', today);
    };

    // Function to format time to 12-hour AM/PM format
    function formatTo12Hour(time) {
        const [hour, minute] = time.split(":").map(num => parseInt(num));
        const suffix = hour >= 12 ? "PM" : "AM";
        let formattedHour = hour % 12;
        formattedHour = formattedHour ? formattedHour : 12; // Handle 12 AM/PM
        return `${formattedHour}:${minute < 10 ? "0" + minute : minute} ${suffix}`;
    }

    // Update Date and Time Slot Options with Fade-in Effect
    function updateDateTime() {
        const dateInput = document.getElementById('calendar').value;
        const selectedDate = new Date(dateInput);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (selectedDate < today) {
            alert('Please select a valid date.');
            document.getElementById('calendar').value = '';
            document.getElementById('selectedDate').textContent = 'Select a date from the calendar';
            document.getElementById('availableTimes').innerHTML = '<p>Select a date to view available time slots.</p>';
            document.getElementById('availableTimes').classList.remove('show');
            return;
        }

        const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const months = ["January", "February", "March", "April", "May", "June", "July",
                        "August", "September", "October", "November", "December"];

        const day = weekdays[selectedDate.getDay()];
        const month = months[selectedDate.getMonth()];
        const date = selectedDate.getDate();
        const year = selectedDate.getFullYear();

        const formattedDate = `${day}, ${month} ${date}, ${year}`;
        document.getElementById('selectedDate').textContent = formattedDate;
        document.getElementById('selected_date_input').value = dateInput;

        // Fetch available times via AJAX
        fetch(`get_available_times.php?date=${dateInput}`)
            .then(response => response.json())
            .then(times => {
                let timesHtml = '<label for="time"><i class="fas fa-clock icon"></i>Select Time:</label><select id="time" name="time">';
                if (times.length === 0) {
                    timesHtml += '<option disabled>No available slots</option>';
                } else {
                    times.forEach(time => {
                        const formattedTime = formatTo12Hour(time); // Convert time to 12-hour format
                        timesHtml += `<option value="${time}">${formattedTime}</option>`;
                    });
                }
                timesHtml += '</select>';

                const availableTimesDiv = document.getElementById('availableTimes');
                availableTimesDiv.innerHTML = timesHtml;
                setTimeout(() => {
                    availableTimesDiv.classList.add('show');
                }, 10);
            })
            .catch(error => {
                console.error('Error fetching availability:', error);
            });
    }

    // Form Validation
    function validateForm() {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const reason = document.getElementById('reason').value.trim();
        const date = document.getElementById('selected_date_input').value;
        const time = document.getElementById('time')?.value;

        if (!name || !email || !reason || !date || !time) {
            alert('Please fill in all fields before submitting.');
            return false;
        }

        // Email format validation
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return false;
        }

        return true;
    }
</script>

</body>
</html>
