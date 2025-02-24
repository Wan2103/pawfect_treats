<?php
session_start();
include 'db_config.php';

// Set the header to return JSON
header('Content-Type: application/json');

// Check if 'action' is set and if it is 'merchandise'
if (isset($_GET['action']) && $_GET['action'] == 'merchandise') {
    // Query to fetch all merchandise
    $query = "SELECT images, item_name, price FROM merchandises";
    $result = $conn->query($query);
    
    // Check if the query was successful
    if ($result) {
        $merchandises = []; // Array to hold the merchandise data
        
        // Fetch all merchandise records
        while ($row = $result->fetch_assoc()) {
            // Append each merchandise record to the array
            $merchandises[] = [
                'images' => $row['images'],
                'item_name' => $row['item_name'],
                'price' => $row['price']
            ];
        }
        
        // Check if we have merchandise data
        if (count($merchandises) > 0) {
            // Return the merchandise data as a JSON response
            echo json_encode(["success" => true, "data" => $merchandises]);
        } else {
            // No merchandise found, return a message
            echo json_encode(["success" => false, "message" => "No merchandise found."]);
        }
    } else {
        // Query failed, return a message
        echo json_encode(["success" => false, "message" => "Failed to execute query."]);
    }
    exit();
} else {
    // Invalid action
    echo json_encode(["success" => false, "message" => "Invalid action."]);
    exit();
}
?>
