<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: profile.php");
    exit();
}
include 'db_config.php';

// Fetch users
$result = $conn->query("SELECT id, username, email, role FROM users");

?>
<h1>Manage Users</h1>
<table border='1'>
    <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['role'] ?></td>
        <td>
            <a href="delete_user.php?id=<?= $row['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
