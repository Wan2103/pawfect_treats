<?php
session_start();
if ($_SESSION['role'] !== 'vet') {
    header("Location: profile.php");
    exit();
}
?>
<h1>Medical Records</h1>
<p>List of medical records for foster cats.</p>
<a href="add_medical_record.php" class="btn">Add Medical Record</a>
