<?php
session_start();
include 'db_config.php'; // Database connection
header('Content-Type: application/json');

$response = ["success" => false];

// Fetch user profile image if logged in
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT images FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($userImage);
    if ($stmt->fetch() && !empty($userImage)) {
        $response['userImage'] = $userImage;
    }
    $stmt->close();
}

// Fetch Cat of the Day (Random Cat)
$result = $conn->query("SELECT id, name, breed, gender, age, image FROM cats ORDER BY RAND() LIMIT 1");
if ($row = $result->fetch_assoc()) {
    $response['cat'] = $row;
}

// Fetch Merchandise of the Day (Random Merchandise)
$result = $conn->query("SELECT id, item_name AS name, price, images AS image FROM merchandises ORDER BY RAND() LIMIT 1");
if ($row = $result->fetch_assoc()) {
    $response['merchandise'] = $row;
}

// Fetch User Reviews (Latest 5 Reviews)
$response['reviews'] = [];
$result = $conn->query("SELECT review FROM reviews ORDER BY created_at DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    $response['reviews'][] = $row['review'];
}

$response['success'] = true;
echo json_encode($response);
exit();
?>
