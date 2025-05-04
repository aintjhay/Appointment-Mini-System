<?php
include 'db.php';

$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['full_name'],
        'start' => $row['date'] . 'T' . $row['time']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
