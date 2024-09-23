
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start(); // Start the session
 // Start the session at the beginning of the script
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the POST request
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Make sure this matches the form input name

    // Prepare the SQL statement
    $stmt = $conn2->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)"); // Make sure the column name matches
    if (!$stmt) {
        die("Failed to prepare statement: " . $conn2->error); // Use die() to output the error and stop the script
    } else {
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            // Registration success
            $_SESSION['user_id'] = $conn2->insert_id; // Save the new user's ID in the session
            // Redirect to the airline.html page
            header("Location: Airline.html");
            exit();
        } else {
            die("Failed to execute statement: " . $stmt->error); // Use die() to output the error and stop the script
        }
    }
} else {
    echo "No POST request received.\n"; // For debugging purposes
}
?>