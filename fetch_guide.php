<?php
session_start();
include 'db_config.php';
header('Content-Type: application/json');

// Ensure action is set
if (!isset($_GET['action'])) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit();
}

// Fetch all guides (Fix: Changed 'guides' to 'care_guides')
if ($_GET['action'] == 'all_guides') {
    $stmt = $conn->prepare("SELECT id, title, content FROM care_guides"); 
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Database query failed: " . $conn->error]);
        exit();
    }

    $result = $stmt->get_result();
    $guides = [];
    while ($row = $result->fetch_assoc()) {
        $guides[] = $row;
    }

    echo json_encode(["success" => true, "guides" => $guides]);
    exit();
}

// Fetch a single guide (Fix: Changed 'guides' to 'care_guides')
if ($_GET['action'] == 'single_guide' && isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT title, content FROM care_guides WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Database query failed: " . $conn->error]);
        exit();
    }

    $result = $stmt->get_result();
    $guide = $result->fetch_assoc();

    if (!$guide) {
        echo json_encode(["success" => false, "message" => "Guide not found."]);
        exit();
    }

    echo json_encode(["success" => true, "guide" => $guide]);
    exit();
}
?>
