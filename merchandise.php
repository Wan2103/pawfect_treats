<?php
session_start();
include 'db_config.php'; // Database connection
header('Content-Type: application/json');

if (!isset($_GET['action'])) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit();
}

if ($_GET['action'] == 'all_merch') {
    $result = $conn->query("SELECT id, item_name AS name, price, images AS image FROM merchandises");

    if ($result) {
        $merchandise = [];
        while ($row = $result->fetch_assoc()) {
            $merchandise[] = $row;
        }

        echo json_encode(["success" => true, "merchandise" => $merchandise]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to retrieve merchandise."]);
    }
    exit();
}
?>
