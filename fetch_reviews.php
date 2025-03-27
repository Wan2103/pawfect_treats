<?php
session_start();
include 'db_config.php';
header('Content-Type: application/json');

$stmt = $conn->prepare("SELECT review, review_point FROM reviews ORDER BY created_at DESC LIMIT 5");
if (!$stmt->execute()) {
    echo json_encode(["success" => false, "message" => "Database query failed: " . $conn->error]);
    exit();
}

$result = $stmt->get_result();
$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = [
        "review" => $row["review"],
        "review_point" => $row["review_point"]
    ];
}

if (empty($reviews)) {
    echo json_encode(["success" => false, "message" => "No reviews found."]);
    exit();
}

echo json_encode(["success" => true, "reviews" => $reviews]);
exit();
?>
