<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Use an absolute path to ensure it finds db_config.php
$path ="db_config.php";

if (file_exists($path)) {
    include $path;
} else {
    die("Error: db_config.php not found at " . $path);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing
    $role = $_POST['role'];

    // Check if the email already exists
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists, show a popup
        echo "<script>
                alert('User already exists! Please log in.');
                window.location.href = 'login.html';
              </script>";
        exit();
    }

    // Insert the new user
    $insertQuery = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Please log in.');
                window.location.href = 'login.html';
              </script>";
    } else {
        echo "<script>
                alert('Error registering user. Please try again.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
