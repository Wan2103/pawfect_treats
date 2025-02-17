<?php
session_start();
if ($_SESSION['role'] !== 'vet') {
    header("Location: profile.php");
    exit();
}
?>
<h1>Write a Care Guide</h1>
<form action="save_guide.php" method="POST">
    <label>Title:</label>
    <input type="text" name="title" required>
    <label>Description:</label>
    <textarea name="description" required></textarea>
    <button type="submit">Submit Guide</button>
</form>
