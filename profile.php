<?php
session_start();
include 'db_config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, role, images FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $role, $profile_image);
$stmt->fetch();
$stmt->close();

$profile_image = $profile_image ?: ''; // Default image if none set

// Fetch adopted cats
$adopted_cats = [];
$result = $conn->query("SELECT name, image FROM cats WHERE id IN (SELECT cat_id FROM adoptions WHERE user_id = $user_id)");
while ($row = $result->fetch_assoc()) {
    $adopted_cats[] = $row;
}

// Fetch favorite pets
$fav_pets = [];
$result = $conn->query("SELECT name, image FROM cats WHERE id IN (SELECT cat_id FROM favorites WHERE user_id = $user_id)");
while ($row = $result->fetch_assoc()) {
    $fav_pets[] = $row;
}

// Fetch favorite merchandise
$fav_merch = [];
$result = $conn->query("SELECT item_name, images FROM merchandises WHERE id IN (SELECT merch_id FROM favorites WHERE user_id = $user_id)");
while ($row = $result->fetch_assoc()) {
    $fav_merch[] = $row;
}

// Fetch purchase history
$purchases = [];
$result = $conn->query("SELECT item_name, images, price FROM merchandises WHERE id IN (SELECT merch_id FROM purchases WHERE user_id = $user_id)");
while ($row = $result->fetch_assoc()) {
    $purchases[] = $row;
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $new_username, $new_email, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: profile.php");
    exit();
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_password, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: profile.php");
    exit();
}

// Handle profile deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_profile'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Switch for different roles
switch ($role) {
    case 'user':
        $role_content = "User Dashboard";
        break;
    case 'vet':
        $role_content = "Vet Dashboard";
        break;
    case 'fosterer':
        $role_content = "Fosterer Dashboard";
        break;
    case 'admin':
        $role_content = "Admin Dashboard";
        break;
    default:
        $role_content = "Unknown Role";
        break;
}

header('Content-Type: application/json');
echo json_encode([
    "username" => $username,
    "email" => $email,
    "role" => $role,
    "profile_image" => $profile_image,
    "adopted_cats" => $adopted_cats,
    "fav_pets" => $fav_pets,
    "fav_merch" => $fav_merch,
    "purchases" => $purchases,
    "role_content" => $role_content,
    "success" => true
]);
exit();
?>
