<?php
session_start();
include 'db_config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "<script>alert('User already exists. Please log in.'); window.location.href='login.html';</script>";
        exit();
    }
    
    $stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
    
    if ($stmt->execute()) {
        echo "<script>alert('Signup successful! Please log in.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Signup failed. Please try again.'); window.location.href='signup.html';</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
