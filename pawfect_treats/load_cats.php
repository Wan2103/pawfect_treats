<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$path ="db_config.php";

if (file_exists($path)) {
    include $path;
} else {
    die("Error: db_config.php not found at " . $path);
}

header('Content-Type: application/json');

$sql = "SELECT * FROM cats";
$result = $conn->query($sql);

$cats = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cats[] = $row;
    }
    echo json_encode($cats);
} else {
    echo json_encode(["error" => "Database query failed"]);
}

$conn->close();
?>
