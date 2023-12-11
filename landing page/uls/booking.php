<?php
// Check if the 'bandname' parameter is set in the URL
if (isset($_GET['bandname'])) {
    $bandname = urldecode($_GET['bandname']);
} else {
    // Handle the case where 'bandname' is not set
    die("Invalid band selection.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking for <?php echo $bandname; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: kanit;
            
           
        }

        .sdate {
            width: 200px;
            margin: 12px auto;
            padding:30px;
            display: flex;
            flex-direction:column;
        }

        .dayd {
            margin: 12px;
            border: none;
            background: #38a9a7;
            text-decoration: none;
            padding: 12px;
            border-radius: 20px;
        }
    </style>
      <script>
        function showBookingMessage() {
            alert("Band booked successfully! if slot is not already booked");
        }
    </script>
</head>

<body>
    <h2>Booking for <?php echo $bandname; ?></h2>
    <form action="process_booking.php" class="sdate" method="POST">
        <input type="hidden" name="bandname" value="<?php echo $bandname; ?>">

        <div>
            <label for="location">Location:</label>
            <input class="dayd" type="text" name="location" id="location" required>
        </div>

        <div>
            <label for="event_type">Event Type:</label>
            <input class="dayd" type="text" name="event_type" id="event_type" required>
        </div>

        <div>
            <label for="date">Select a Date:</label>
            <input class="dayd" type="date" name="date" id="date" required>
        </div>

        <div>
            <label for="time">Select a Time:</label>
            <input type="time" class="dayd" name="time" id="time" required>
        </div>

        <input type="submit" class="dayd" value="Book Now" onclick="showBookingMessage()">
    </form>
</body>

</html>