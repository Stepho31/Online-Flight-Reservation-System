<?php
session_start();
include 'db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials against database
    $stmt = $conn2->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
    if (!$stmt) {
        echo "Prepare failed: (" . $conn2->errno . ") " . $conn2->error;
        exit;
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verify password using the correct index 'password_hash'
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id']; // Make sure to use 'user_id', as fetched from the database
            // Debug before redirect
            echo "Redirecting to Airline.html";
            // Redirect to a new page or display success message
            header("Location: Airline.html");
            exit();
        } else {
            // Handle wrong password
            echo "Invalid password."; // Display error message
        }
    } else {
        // Handle user not found
        echo "No user found with that username."; // Display error message
    }
}
?>
