<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the signup form is submitted

    // Retrieve band input
    $bandname = $_POST['bandname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $genre = $_POST['genre'];
    $nomem = $_POST['nomem'];

    // Connect to the database
    $conn = new mysqli("localhost", "alhad", "1234", "mini");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SQL query to insert a new band
    $stmt = $conn->prepare("INSERT INTO bands (bandname, email, password, genre, nomem) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $bandname, $email, $password, $genre, $nomem);

    if ($stmt->execute()) {
        echo "Band registration successful";
    } else {
        echo "Band registration failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>