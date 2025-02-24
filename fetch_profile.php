<?php
session_start();
include 'db_config.php';

// Set the header to return JSON
header('Content-Type: application/json');

// Check if 'action' is set and if it is 'profile'
if (isset($_GET['action']) && $_GET['action'] == 'profile') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["success" => false, "message" => "User not logged in."]);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    
    // Prepare the SQL statement to fetch user profile data
    $stmt = $conn->prepare("SELECT username, email, role, images FROM users WHERE id = ?");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Failed to prepare the database query."]);
        exit();
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $email, $role, $profile_image);
    $stmt->fetch();
    
    // Close the prepared statement
    $stmt->close();

    // Check if the user exists
    if ($username === null) {
        echo json_encode(["success" => false, "message" => "User not found."]);
        exit();
    }
    
    // Use default profile image if none exists
    $profile_image = $profile_image ?: 'images/profile 2.jpeg';

    // Return the profile data in JSON format
    echo json_encode([
        "success" => true,
        "username" => $username,
        "email" => $email,
        "role" => $role,
        "image" => $profile_image
    ]);
    exit();
} else {
    echo json_encode(["success" => false, "message" => "Invalid action."]);
    exit();
}
?>
