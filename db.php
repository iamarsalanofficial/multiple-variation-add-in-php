<?php
// db.php
$servername = "localhost";
$username = "root"; // Change as per your DB credentials
$password = "";     // Change as per your DB credentials
$dbname = "client_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
