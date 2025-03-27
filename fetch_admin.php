<?php
session_start();
include 'db_config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["success" => false, "message" => "Access Denied."]);
    exit();
}

// Fetch total users, cats, and orders for admin dashboard
$total_users = 0;
$total_cats = 0;
$total_orders = 0;

$stmt = $conn->prepare("SELECT COUNT(*) FROM users");
$stmt->execute();
$stmt->bind_result($total_users);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) FROM cats");
$stmt->execute();
$stmt->bind_result($total_cats);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) FROM purchases");
$stmt->execute();
$stmt->bind_result($total_orders);
$stmt->fetch();
$stmt->close();

echo json_encode([
    "success" => true,
    "total_users" => $total_users,
    "total_cats" => $total_cats,
    "total_orders" => $total_orders
]);
exit();
?>
