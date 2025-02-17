<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pawfect Treats</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    </header>
    
    <nav>
        <a href="index.html">Home</a>
        <a href="adoption.html">Adopt a Cat</a>
        <a href="guide.html">Care Guide</a>
        <a href="merchandise.html">Merchandise</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>

    <main>
        <h2>Your Dashboard</h2>

        <?php
        switch ($role) {
            case "user":
                echo "<section class='dashboard'>
                        <h3>User Dashboard</h3>
                        <p>Explore available cats and care guides.</p>
                        <a href='adoption.html' class='btn'>View Adoption Listings</a>
                        <a href='guide.html' class='btn'>Read Care Guides</a>
                      </section>";
                break;

            case "admin":
                echo "<section class='dashboard'>
                        <h3>Admin Dashboard</h3>
                        <p>Manage users, fosterers, and vets.</p>
                        <a href='manage_users.php' class='btn'>Manage Users</a>
                        <a href='manage_admin.php' class='btn'>Manage Admins</a>
                        <a href='manage_fosterers.php' class='btn'>Manage Fosterers</a>
                        <a href='manage_vets.php' class='btn'>Manage Vets</a>
                      </section>";
                break;

            case "vet":
                echo "<section class='dashboard'>
                        <h3>Vet Dashboard</h3>
                        <p>Update medical records and write guides.</p>
                        <a href='vet_records.php' class='btn'>View & Update Medical Records</a>
                        <a href='write_guide.php' class='btn'>Write a Care Guide</a>
                      </section>";
                break;

            case "fosterer":
                echo "<section class='dashboard'>
                        <h3>Fosterer Dashboard</h3>
                        <p>Manage your foster cats and approve adoption requests.</p>
                        <a href='manage_foster_cats.php' class='btn'>Manage Foster Listings</a>
                        <a href='adoption_requests.php' class='btn'>Approve/Reject Adoption Requests</a>
                      </section>";
                break;

            default:
                echo "<p>Unknown role detected. Please contact support.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2025 Pawfect Treats. All Rights Reserved.</p>
    </footer>
</body>
</html>
