<?php
session_start();
include 'db_config.php';
header('Content-Type: application/json');

// Ensure action is set
if (!isset($_GET['action'])) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit();
}

// Fetch all available cats (Fix: Removed 'status' column)
if ($_GET['action'] == 'all_cats') {
    $stmt = $conn->prepare("SELECT id, name, gender, age, image FROM cats");
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Database query failed: " . $conn->error]);
        exit();
    }
    
    $result = $stmt->get_result();
    $cats = [];
    while ($row = $result->fetch_assoc()) {
        $cats[] = $row;
    }

    echo json_encode(["success" => true, "cats" => $cats]);
    exit();
}

// Fetch a random "Cat of the Day"
if ($_GET['action'] == 'cat_of_the_day') {
    $stmt = $conn->prepare("SELECT id, name, gender, age, image FROM cats ORDER BY RAND() LIMIT 1");
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Database query failed: " . $conn->error]);
        exit();
    }

    $result = $stmt->get_result();
    $cat = $result->fetch_assoc();

    if (!$cat) {
        echo json_encode(["success" => false, "message" => "No cat found."]);
        exit();
    }

    echo json_encode(["success" => true, "cat" => $cat]);
    exit();
}
?>
