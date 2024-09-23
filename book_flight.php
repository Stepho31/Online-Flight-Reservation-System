<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php'; // Ensure this path correctly points to your database connection script.

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect them to the login page
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Define the function for date validation and formatting
function validateAndFormatDate($date) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    return $dateTime ? $dateTime->getTimestamp() : false;  // Return Unix timestamp
}

// Define the function for booking flights
function bookFlight($conn, $user_id, $from, $to, $departDate, $returnDate, $adults, $children, $class, $cardNumber, $cardExpiry) {
    $stmt = $conn->prepare("INSERT INTO `flights`.`Flights Info` (`user_id`, `from`, `to`, `depart-date`, `return-date`, `adults`, `children`, `class`, `card-number`, `card-expiry`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }
    
    $stmt->bind_param("isssiiisss", $user_id, $from, $to, $departDate, $returnDate, $adults, $children, $class, $cardNumber, $cardExpiry);
    
    if ($stmt->execute()) {
        header("Location: booked-flights.html");
        exit();
    } else {
        die("Error executing statement: " . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

// Process POST request for booking flights
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $departDate = validateAndFormatDate($_POST['depart-date']);
    $returnDate = validateAndFormatDate($_POST['return-date']);
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $class = $_POST['class'];
    $cardNumber = $_POST['card-number'];
    $cardExpiry = $_POST['card-expiry'];
    // Note: Never store the CVV number

    if (!$departDate || !$returnDate) {
        echo "Invalid date provided.";
        exit;
    }

    // Continue with booking if dates are valid
    bookFlight($conn, $user_id, $from, $to, $departDate, $returnDate, $adults, $children, $class, $cardNumber, $cardExpiry);
}

?>