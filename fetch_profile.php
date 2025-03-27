<?php
session_start();
include 'db_config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile details
$stmt = $conn->prepare("SELECT username, email, role, images FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $role, $profile_image);
$stmt->fetch();
$stmt->close();

$profile_image = $profile_image ?: 'images/default-profile.jpeg'; // Default image if none set

// Fetch adopted cats
$adopted_cats = [];
$stmt = $conn->prepare("SELECT name, image FROM cats WHERE id IN (SELECT cat_id FROM adoptions WHERE user_id = ?)");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $adopted_cats[] = $row;
}
$stmt->close();

// Fetch purchase history
$purchases = [];
$stmt = $conn->prepare("SELECT item_name, images, price FROM merchandises WHERE id IN (SELECT merch_id FROM purchases WHERE user_id = ?)");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $purchases[] = $row;
}
$stmt->close();

echo json_encode([
    "success" => true,
    "username" => $username,
    "email" => $email,
    "role" => $role,
    "profile_image" => $profile_image,
    "adopted_cats" => $adopted_cats,
    "purchases" => $purchases
]);
exit();
?>
