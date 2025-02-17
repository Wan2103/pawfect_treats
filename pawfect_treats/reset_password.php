<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "A password reset link has been sent to your email!";
        // Here, you would typically generate a password reset token and send an email.
    } else {
        echo "Email not found. Please check and try again.";
    }

    $stmt->close();
    $conn->close();
}
?>
