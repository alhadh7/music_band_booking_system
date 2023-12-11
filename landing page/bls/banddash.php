<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="banddash.css">
    <title>Band Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: kanit;
        }

        .btnc {
            border: none;
            background: green;
            text-decoration: none;
            padding: 5px;
            font-weight: 600;
            color: white;
            border-radius: 20px;
        }

        .btnr {
            border: none;
            background: red;
            text-decoration: none;
            padding: 5px;
            font-weight: 600;
            color: white;
            border-radius: 20px;
        }

        .active,
        .collapsible:hover {
            background-color: #362a2a;
        }
    </style>
</head>
<body>
    <h3>Band Dashboard</h3>

    <button type="button" class="collapsible">Booking requests</button>
    <div class="content">
        <?php
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

        // SQL query to fetch booking requests for this band
        // You'll need a table to store booking requests, modify the query accordingly
        $sql = "SELECT user_id, bandname, date, time, location, event_type FROM booking_requests WHERE bandname = ? AND status = 'pending'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $bandname = $_SESSION['bandname']; // Get the band's name from the session
            $stmt->bind_param("s", $bandname);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<h2>Booking Requests</h2>';
                echo '<table>';
                echo '<tr><th>User</th><th>Band</th><th>Date</th><th>Time</th><th>Location</th><th>Event-Type</th><th>Action</th></tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['user_id'] . '</td>';
                    echo '<td>' . $row['bandname'] . '</td>';
                    echo '<td>' . $row['date'] . '</td>';
                    echo '<td>' . $row['time'] . '</td>';
                    echo '<td>' . $row['location'] . '</td>'; // Display location
                    echo '<td>' . $row['event_type'] . '</td>'; // Display event_type
                    echo '<td><a class="btnc" href="confirm_booking.php?user_id=' . $row['user_id'] . '&bandname=' . $row['bandname'] . '">Confirm</a> | ';
                    echo '<a class="btnr" href="reject_booking.php?user_id=' . $row['user_id'] . '&bandname=' . $row['bandname'] . '">Reject</a></td>';
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
    </div>

    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        }
    </script>
</body>
</html>