<?php
$servername = "127.0.0.1";
$username = "root"; 
$password = "root"; 
$database = "flight_booking_db";
$port = 8889; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // For testing purposes, to confirm if connected successfully

$conn2 = new mysqli("127.0.0.1", "root", "root", "User", 8889);
if ($conn2->connect_error) {
    die("Connection failed to flights: " . $conn2->connect_error);
}

$conn3 = new mysqli("127.0.0.1", "root", "root", "flights", 8889);
if ($conn3->connect_error) {
    die("Connection failed to flights: " . $conn3->connect_error);
}
?>