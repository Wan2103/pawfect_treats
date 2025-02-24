<?php
session_start();
include 'db_config.php';

// Set the header to return JSON
header('Content-Type: application/json');

// Check if 'action' is set and if it is 'reviews'
if (isset($_GET['action']) && $_GET['action'] == 'reviews') {
    $reviews = [];
    
    // Query to get the latest 5 reviews
    $result = $conn->query("SELECT review FROM reviews ORDER BY created_at DESC LIMIT 5");

    // Check if the query was successful
    if ($result === false) {
        echo json_encode(["success" => false, "message" => "Failed to retrieve reviews."]);
        exit();
    }
    
    // Fetch reviews from the result set
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row['review'];
    }

    // If no reviews found, return a message
    if (empty($reviews)) {
        echo json_encode(["success" => false, "message" => "No reviews found."]);
        exit();
    }

    // Return the reviews in JSON format
    echo json_encode(["success" => true, "reviews" => $reviews]);
    exit();
} else {
    // Return an error if 'action' is not set or invalid
    echo json_encode(["success" => false, "message" => "Invalid action."]);
    exit();
}
?>
