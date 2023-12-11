<?php
// Start or resume a session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get band input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    $conn = new mysqli("localhost", "alhad", "1234", "mini");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL query to fetch band data
    $stmt = $conn->prepare("SELECT id, bandname, password FROM bands WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a band with the provided email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($band_id, $bandname, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['band_id'] = $band_id;
            $_SESSION['bandname'] = $bandname;

            // Redirect to the band dashboard
            header("Location: banddash.php");
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Band not found";
    }

    $stmt->close();
    $conn->close();
}
?>