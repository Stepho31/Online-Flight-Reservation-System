<?php
session_start(); // Start the session at the beginning of the script

include 'db.php'; // Ensure database connection is correct

// Check if the user is logged in and get the user_id from the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Modify this function to accept user_id and return flights for that user
    function fetchBookedFlights($conn, $user_id) {
        $stmt = $conn->prepare("SELECT `from`, `to`, `depart-date`, `return-date`, `adults`, `children`, `class` FROM `flights`.`Flights Info` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $flights = [];
        while ($row = $result->fetch_assoc()) {
            $flights[] = $row;
        }
        return $flights;
    }

    header('Content-Type: application/json');
    $result = fetchBookedFlights($conn, $user_id); // Call the function with the user ID
    echo json_encode($result);

} else {
    // User is not logged in, return an error or redirect to login page
    http_response_code(403);
    echo json_encode(['error' => 'User not authenticated']);
}
?>