<?php
// get_available_times.php

$date = $_GET['date'] ?? '';
$day = date('l', strtotime($date));

// Sample logic: Replace with DB query to check actual booked slots
$booked = ['2025-05-05' => ['09:00', '10:00']];

$allTimes = ($day === 'Saturday' || $day === 'Sunday') ?
    ['09:00', '10:00', '11:00'] :
    ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00'];

$available = array_diff($allTimes, $booked[$date] ?? []);
echo json_encode(array_values($available));
?>
