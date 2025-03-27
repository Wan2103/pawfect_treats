<?php
session_start();
include 'db_config.php';
header('Content-Type: application/json');

// Ensure action is set
if (!isset($_GET['action'])) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit();
}

// Fetch all merchandise
if ($_GET['action'] == 'all_merch') {
    $stmt = $conn->prepare("SELECT id, item_name, description, stock, price, images, admin_name FROM merchandises");
    
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Database query failed: " . $conn->error]);
        exit();
    }

    $result = $stmt->get_result();
    $merchandise = [];
    while ($row = $result->fetch_assoc()) {
        $merchandise[] = $row;
    }

    // If no merchandise found, return an empty message
    if (empty($merchandise)) {
        echo json_encode(["success" => false, "message" => "No merchandise available."]);
        exit();
    }

    echo json_encode(["success" => true, "merchandise" => $merchandise]);
    exit();
}

// Fetch a random "Merchandise of the Day"
if ($_GET['action'] == 'merch_of_the_day') {
    $stmt = $conn->prepare("SELECT id, item_name, description, stock, price, images, admin_name FROM merchandises ORDER BY RAND() LIMIT 1");

    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Database query failed: " . $conn->error]);
        exit();
    }

    $result = $stmt->get_result();
    $merch = $result->fetch_assoc();

    // If no merchandise exists, return an error message
    if (!$merch) {
        echo json_encode(["success" => false, "message" => "No merchandise found."]);
        exit();
    }

    echo json_encode(["success" => true, "merchandise" => $merch]);
    exit();
}
?>
