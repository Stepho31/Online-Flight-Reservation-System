<?php
session_start();
include 'db.php'; // Ensure this path correctly points to your database connection script.

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, return an error
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT `from`, `to`, `depart-date`, `return-date`, `adults`, `children`, `class` FROM `flights`.`Flights Info` WHERE `user_id` = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$flights = [];
while ($row = $result->fetch_assoc()) {
    $flights[] = $row;
}

echo json_encode($flights);
?>