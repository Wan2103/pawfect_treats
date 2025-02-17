<?php
session_start();
if ($_SESSION['role'] !== 'fosterer') {
    header("Location: profile.php");
    exit();
}
?>
<h1>Adoption Requests</h1>
<p>Approve or reject adoption requests.</p>
<a href="approve_request.php" class="btn">Approve Requests</a>
