<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking Requests</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: kanit;
        }
    </style>
</head>

<body>
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

    // Check if the user clicked "Confirm" and process the request
    if (isset($_GET['user_id']) && isset($_GET['bandname']) && isset($_GET['date']) && isset($_GET['time'])) {
        // SQL query to update the booking request status to "confirmed"
        $updateQuery = "UPDATE booking_requests SET status = 'confirmed' WHERE user_id = ? AND bandname = ? AND date = ? AND time = ?";
        $updateStmt = $conn->prepare($updateQuery);

        if ($updateStmt) {
            $user_id = $_GET['user_id'];
            $bandname = $_GET['bandname'];
            $date = $_GET['date'];
            $time = $_GET['time'];

            $updateStmt->bind_param("ssss", $user_id, $bandname, $date, $time);

            if ($updateStmt->execute()) {
                echo "Booking request confirmed!👍👍👍";
            } else {
                echo "Error confirming the booking request.";
            }

            $updateStmt->close();
        } else {
            echo 'Error: ' . $conn->error;
        }
    }

    // SQL query to fetch booking requests for this band
    $sql = "SELECT user_id, bandname, date, time FROM booking_requests WHERE bandname = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $bandname = $_SESSION['bandname']; // Get the band's name from the session
        $stmt->bind_param("s", $bandname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<h2>Booking Requests</h2>';
            echo '<table>';
            echo '<tr><th>User</th><th>Band</th><th>Date</th><th>Time</th><th>Action</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['user_id'] . '</td>';
                echo '<td>' . $row['bandname'] . '</td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['time'] . '</td>';
                echo '<td>';
                echo '<form method="GET">';
                echo '<input type="hidden" name="user_id" value="' . $row['user_id'] . '">';
                echo '<input type="hidden" name="bandname" value="' . $row['bandname'] . '">';
                echo '<input type="hidden" name="date" value="' . $row['date'] . '">';
                echo '<input type="hidden" name="time" value="' . $row['time'] . '">';
                echo '<button type="submit">Confirm</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No pending booking requests.</p>';
        }

        $stmt->close();
    } else {
        echo 'Error: ' . $conn->error;
    }

    $conn->close();
    ?>
</body>

</html>