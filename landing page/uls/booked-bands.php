<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: kanit;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 150px;
        }
        .contents{
            border: solid #647483;
            padding: 30px;
        }
        h1 {
            position: relative;
            top: -40px;
        }
    </style>
</head>
<body>
    <h1>Booked bands</h1>
    <div class="contents">
    <?php
    // Start or resume a session
    session_start();

    // Check if the user is logged in, and their user ID is stored in the session
    if (!isset($_SESSION['user_id'])) {
        echo 'User is not logged in. Please log in to view booked bands.';
        exit();
    }

    // Include your database connection code
    $conn = new mysqli("localhost", "alhad", "1234", "mini");

    // Check for a successful connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Replace with your actual user session handling code
    $user_id = $_SESSION['user_id'];

    // SQL query to fetch booked bands for the user including location and event_type
    $sql = "SELECT bandname, date, time, location, event_type, status FROM booking_requests WHERE user_id = $user_id AND status = 'paid'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are booked bands
    if ($result !== false && $result->num_rows > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<th>Band Name</th>';
        echo '<th>Date</th>';
        echo '<th>Time</th>';
        echo '<th>Location</th>'; // Added column header for location
        echo '<th>Event Type</th>'; // Added column header for event_type
        echo '<th>Status</th>';
        echo '</tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['bandname'] . '</td>';
            echo '<td>' . $row['date'] . '</td>';
            echo '<td>' . $row['time'] . '</td>';
            echo '<td>' . $row['location'] . '</td>'; // Display location
            echo '<td>' . $row['event_type'] . '</td>'; // Display event_type
            echo '<td>' . $row['status'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No booked bands found.</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
</div>
</body>
</html>