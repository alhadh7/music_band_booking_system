<?php
// Start or resume a session
session_start();

// Function to retrieve user information from the database (you can use the function you've defined)
function getUserInfo($field) {
    // Implement your database connection and retrieval logic here
}

// Check if the user is logged in, and their user ID is stored in the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit();
}

// Use the getUserInfo function to retrieve user data
$username = getUserInfo('username');
$email = getUserInfo('email');

// Your database connection code here
$conn = new mysqli("localhost", "alhad", "1234", "mini");
// Query to fetch the user's booking requests
$user_id = $_SESSION['user_id'];
$sql = "SELECT bandname, date, time, status,location, event_type  FROM booking_requests WHERE user_id = $user_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userdash.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">

    <title>Booking Status</title>
    <style>
        body{
        font-family:kanit;
        }
        .payment-section {
            display: none;
        }
        .content{
         border: 1px solid #ccc;
         padding:30px;
        display: flex;
    justify-content: center;
        }
        .btn{
            border:none;
    background:red;
    text-decoration:none;
    padding:12px;
    border-radius:20px;
        }
        h2{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="profilepic.png" alt="Profile Picture">
        <h1> Welcome <?php echo $username; ?>!</h1>
    </div>
    <h2>Booking Status</h2>
    <div class="content">
        <?php
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Band Name</th>';
            echo '<th>Date</th>';
            echo '<th>Time</th>';
            echo '<th>Location</th>'; // New
            echo '<th>Event-Type</th>'; // New
            echo '<th>Status</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['bandname'] . '</td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['time'] . '</td>';
                
                // Check if the keys exist in the $row array before trying to access them
                echo '<td>' . (isset($row['location']) ? $row['location'] : 'N/A') . '</td>';
                echo '<td>' . (isset($row['event_type']) ? $row['event_type'] : 'N/A') . '</td>';
                
                echo '<td>' . $row['status'] . '</td>';
                echo '<td>';
            
                if ($row['status'] === 'confirmed') {
                    // Display the fixed price of $100 with some space and then the "Pay Now" button.
                    echo 'Price: $100 &nbsp;&nbsp;'; // Added some non-breaking spaces for spacing
                    echo '<form method="post">';
                    echo '<button type="submit" class="btn" name="pay" value="' . $row['bandname'] . '">Pay Now</button>';
                    echo '</form>';
                } elseif ($row['status'] === 'paid') {
                    echo 'Booked';
                } else {
                    echo 'Payment option available after confirmation';
                }
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No booking requests found.</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
if (isset($_POST['pay'])) {
    $bandname = $_POST['pay'];
    // Update the status of the booking in your database to "paid"
    // Perform an SQL query to update the status for the specific bandname.
    $updateSql = "UPDATE booking_requests SET status = 'paid' WHERE user_id = $user_id AND bandname = '$bandname'";
    if ($conn->query($updateSql) === TRUE) {
        echo '<p>Payment Successful</p>';
        echo '<img src="qr.jpg" alt="QR Code" style="height:140px">';
    } else {
        echo '<p>Error updating payment status: ' . $conn->error . '</p>';
    }
}

// Close the database connection
$conn->close();
?>