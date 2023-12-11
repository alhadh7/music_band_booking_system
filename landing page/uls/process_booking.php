<?php
// Start or resume a session
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in, and you should manage user sessions
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php'); // Redirect to the login page if not logged in
        exit();
    }

    // Get the user ID from the session (replace with your own user session handling)
    $user_id = $_SESSION['user_id'];

    // Retrieve booking data from the form
    $bandname = $_POST['bandname'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $event_type = $_POST['event_type'];

    // Perform database connection (replace with your database connection code)
    $conn = new mysqli("localhost", "alhad", "1234", "mini");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check for availability before inserting the booking request
    $availabilityCheckQuery = "SELECT * FROM booking_requests WHERE bandname = ? AND date = ? AND time = ?";
    $availabilityCheckStmt = $conn->prepare($availabilityCheckQuery);
    $availabilityCheckStmt->bind_param("sss", $bandname, $date, $time);
    $availabilityCheckStmt->execute();
    $availabilityCheckResult = $availabilityCheckStmt->get_result();

    if ($availabilityCheckResult->num_rows > 0) {
        // The time slot is not available
        echo '<script>alert("Sorry, this time slot is already booked. Please choose another."); window.location.href = "booking.php?bandname=' . urlencode($bandname) . '";</script>';
        exit();
    }

    // Prepare and execute an SQL query to insert the booking request
    $insertBookingQuery = "INSERT INTO booking_requests (user_id, bandname, date, time, location, event_type) VALUES (?, ?, ?, ?, ?, ?)";
    $insertBookingStmt = $conn->prepare($insertBookingQuery);
    $insertBookingStmt->bind_param("ssssss", $user_id, $bandname, $date, $time, $location, $event_type);

    if ($insertBookingStmt->execute()) {
        // The booking request was successfully added to the database
        header("Location: userdash.php");
    } else {
        // Handle the case where the request failed to be added to the database
        echo "Error: " . $insertBookingQuery . "<br>" . $conn->error;
    }

    $availabilityCheckStmt->close();
    $insertBookingStmt->close();
    $conn->close();
} else {
    // If the form was not submitted, handle this accordingly, e.g., show an error message.
    echo "Form not submitted.";
}
?>