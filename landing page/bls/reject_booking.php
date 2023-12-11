<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start or resume a session (bands need to be logged in)
session_start();

// Check if the user is a band
if (!isset($_SESSION['band_id'])) {
    header('Location: login.php');
    exit();
}

// Include your database connection code
$conn = new mysqli("localhost", "alhad", "1234", "mini");

// Check for a successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user clicked "Reject" and process the request
if (isset($_GET['user_id']) && isset($_GET['bandname'])) {
    // SQL query to update the booking request status to "rejected"
    $updateQuery = "UPDATE booking_requests SET status = 'rejected' WHERE user_id = ? AND bandname = ?";
    $updateStmt = $conn->prepare($updateQuery);

    if ($updateStmt) {
        $user_id = $_GET['user_id'];
        $bandname = $_GET['bandname'];
        $updateStmt->bind_param("ss", $user_id, $bandname);

        if ($updateStmt->execute()) {
            echo "Booking request rejected.";
        } else {
            echo "Error rejecting the booking request.";
        }

        $updateStmt->close();
    } else {
        echo 'Error: ' . $conn->error;
    }
}

$conn->close();
?>