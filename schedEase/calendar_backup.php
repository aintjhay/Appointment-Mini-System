<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>SchedEase - Admin View</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.min.js'></script>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        #calendar { max-width: 900px; margin: 0 auto; }
    </style>
</head>
<body>
    <h1>📅 Appointment Calendar</h1>
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                timeZone: 'local',
                events: 'fetch_events.php',
                eventColor: '#28a745',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
