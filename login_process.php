<?php
session_start();
include 'db_config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form is submitted with email and password
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Prepare and execute SQL query to check if the email exists
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Fetch user data
            $stmt->bind_result($id, $username, $hashed_password, $role);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                echo json_encode(["success" => true, "redirect" => "index.html"]);
            } else {
                echo json_encode(["success" => false, "message" => "Incorrect password. Please try again."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "User not found."]);
        }

        $stmt->close();
    }
}
?>
