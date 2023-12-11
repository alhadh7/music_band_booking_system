<?php
// Start or resume a session
session_start();

// Function to retrieve user information from the database
function getUserInfo($field) {
 
    $conn = new mysqli("localhost", "alhad", "1234", "mini");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Replace "your_user_id" with the actual user's ID or session ID
    $user_id = $_SESSION['user_id']; // You should manage user sessions

    // Query to retrieve user information
    $sql = "SELECT $field FROM users WHERE id = $user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row[$field];
    } else {
        return "User Not Found";
    }

    $conn->close();
}

// Check if the user is logged in, and their user ID is stored in the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit();
}

// Use the getUserInfo function to retrieve user data
$username = getUserInfo('username');
$email = getUserInfo('email');
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="userdash.css">
    <title>User Dashboard</title>
 
</head>
<style>

.book-button{
    border:none;
    padding:5px 10px;
    background:#2a9d8f;
    border-radius:30px;
    color:white;
    height: 5vh;
    margin-top:17px;
    font-weight:600;
}

body{
    
font-family:kanit;
}
a{
text-decoration:none;
}
h2{
color:white;
}
.booked-bands{
margin-top:-50px;
margin-left:30px;
}
.booking-status{
margin-left:30px;

}
.available-bands{
   width: 70%;
   border-radius:30px;
   margin:auto;
    border: 1px solid #ccc;
 
    padding:50px;
    margin-top:30px;
    padding-top:-20px;
}
.bottom{
    border: 1px solid #ccc;
}


.band {
    display: flex;
    border:1px solid white;
    margin:10px;
    border-radius:30px;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-evenly;
}

</style>
<body>
    <div class="header">
        <img src="profilepic.png" alt="Profile Picture">
        <h1> Welcome <?php echo $username; ?>!</h1>
    </div>
    <div class="profile">
        <h2>Profile Information</h2>
        <p>Username: <?php echo $username; ?></p>
        <p>Email: <?php echo $email; ?></p>
    </div>
    <div class="content">
<!-- Available Bands Section -->
<section class="available-bands">
    <h2>Available Bands</h2>

    <?php
    // Include your database connection code
    $conn = new mysqli("localhost", "alhad", "1234", "mini");

    // Check for a successful connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch available bands
    $sql = "SELECT bandname, genre, nomem, email FROM bands";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are available bands
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="band">';
            echo '<h3>' . $row['bandname'] . '</h3>';
            echo '<p>Genre: ' . $row['genre'] . '</p>';
            echo '<p>Members: ' . $row['nomem'] . '</p>';
            echo '<p>Email: ' . $row['email'] . '</p>';
            
            // Modify the "Book Now" link to go to a booking page and include band information
            echo '<a class="book-button" href="booking.php?bandname=' . urlencode($row['bandname']) . '">Book Now</a>';
            echo '</div>';
        }
    } else {
        echo '<p>No available bands at the moment.</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
</section>    
<br>
<div class="bottom">
     <!--  Bookings status Section -->
    <section class="booking-status">
        <!-- Add a link to the booking status page here -->
       <a  href="booking_status.php"><h2>Booking Status</h2></a>
    </section>
    <!-- Messages Section -->
    <section class="booked-bands">
        <!-- Implement booked bands functionality here -->
        <br>
        <a href="booked-bands.php"><h2>Booked bands</h2></a>
    </section></div>
   
    </div>
</body>

</html>
