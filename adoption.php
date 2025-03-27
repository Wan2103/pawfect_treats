<?php
session_start();
include 'db_config.php';
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all cats (removing status filter)
    $stmt = $conn->prepare("SELECT id, name, breed, gender, age, neutered, description, image FROM cats");

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Database query failed: " . $conn->error]);
        exit();
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $cats = [];
    while ($row = $result->fetch_assoc()) {
        $cats[] = $row;
    }

    echo json_encode(["success" => true, "cats" => $cats]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["success" => false, "message" => "User not logged in."]);
        exit();
    }

    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['cat_id'])) {
        echo json_encode(["success" => false, "message" => "Missing cat ID."]);
        exit();
    }

    $cat_id = intval($data['cat_id']);
    $user_id = $_SESSION['user_id'];

    // Ensure the cat exists before processing adoption
    $stmt = $conn->prepare("SELECT id FROM cats WHERE id = ?");
    $stmt->bind_param("i", $cat_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "Cat not found."]);
        exit();
    }

    // Insert adoption request (assuming there's an `adoptions` table)
    $stmt = $conn->prepare("INSERT INTO adoptions (user_id, cat_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $cat_id);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Adoption request successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to process adoption request."]);
    }
    exit();
}

echo json_encode(["success" => false, "message" => "Invalid request."]);
exit();
?>
