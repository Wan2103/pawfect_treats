<?php
$servername = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // No password
$database = "pawfect_treats"; // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
