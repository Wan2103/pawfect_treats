<?php
include 'db_config.php';
header('Content-Type: application/json');

// Fetch all guides
$query = "SELECT id, title, content FROM care_guides";
$result = mysqli_query($conn, $query);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode(["success" => true, "guides" => $data]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to retrieve guides."]);
}
?>
