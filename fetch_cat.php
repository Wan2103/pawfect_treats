<?php
session_start();
include 'db_config.php';

// Set the header to return JSON
header('Content-Type: application/json');

// Check if 'action' is set and if it is 'cat'
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'cat') {
        $result = $conn->query("SELECT image, name, gender, age FROM cats ORDER BY RAND() LIMIT 1");
        
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                echo json_encode(["success" => true] + $row);
            } else {
                echo json_encode(["success" => false, "message" => "No cat found."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Failed to execute query."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid action: " . $_GET['action']]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No action provided."]);
}
exit();
?>
