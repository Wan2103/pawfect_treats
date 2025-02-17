<?php
session_start();
if ($_SESSION['role'] !== 'fosterer') {
    header("Location: profile.php");
    exit();
}
?>
<h1>Manage Foster Cats</h1>
<p>List and manage fostered cats.</p>
<a href="add_cat.php" class="btn">Add Foster Cat</a>
