<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Start session & store user details
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            echo "<script>
                    alert('Login successful! Redirecting to profile...');
                    window.location.href = 'profile.php';
                  </script>";
        } else {
            // Incorrect password
            echo "<script>
                    alert('Incorrect password! Please try again.');
                    window.history.back();
                  </script>";
        }
    } else {
        // Email not found
        echo "<script>
                alert('User does not exist! Please sign up.');
                window.location.href = 'signup.html';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
