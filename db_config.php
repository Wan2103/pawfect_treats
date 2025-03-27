<?php
$servername = "localhost";
$username = "root";  // Change this if using a different DB user
$password = "";      // Set a strong password for production
$dbname = "pawfect_treats";

// Secure connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}
?>
