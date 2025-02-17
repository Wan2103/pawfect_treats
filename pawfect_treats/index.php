<?php
include 'db_config.php'; // Include database connection

// Fetch "Cat of the Day"
$cat_query = "SELECT * FROM cats WHERE available = 1 ORDER BY RAND() LIMIT 1";
$cat_result = mysqli_query($conn, $cat_query);
$cat = mysqli_fetch_assoc($cat_result);

// Fetch "Guide of the Day"
$guide_query = "SELECT * FROM guides ORDER BY RAND() LIMIT 1";
$guide_result = mysqli_query($conn, $guide_query);
$guide = mysqli_fetch_assoc($guide_result);

// Fetch "Merchandise of the Day"
$merch_query = "SELECT * FROM merchandises ORDER BY RAND() LIMIT 1";
$merch_result = mysqli_query($conn, $merch_query);
$merch = mysqli_fetch_assoc($merch_result);

// Fetch "Fosterer of the Day"
$foster_query = "SELECT * FROM fosterers ORDER BY RAND() LIMIT 1";
$foster_result = mysqli_query($conn, $foster_query);
$foster = mysqli_fetch_assoc($foster_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawfect Treats</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to Pawfect Treats</h1>
        <div class="header-icons">
            <a href="profile.html" class="profile-icon">
                <img src="IMAGES/profile 2.jpeg" alt="Profile">
            </a>
        </div>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="adoption.php">Adopt a Cat</a>
        <a href="guide.html">Care Guide</a>
        <a href="merchandise.php">Merchandise</a>
        <a href="login.html">Login</a>
        <a href="signup.html">Sign Up</a>
        <a href="profile.html">Profile</a>
    </nav>

    <main>
        <!-- Cat of the Day -->
        <section class="feature">
            <h2>🐱 Cat of the Day</h2>
            <?php if ($cat): ?>
                <img src="IMAGES/<?php echo $cat['image']; ?>" alt="<?php echo $cat['name']; ?>">
                <p><strong><?php echo $cat['name']; ?></strong> - <?php echo $cat['description']; ?></p>
                <a href="adoption.php" class="btn">Adopt Me</a>
            <?php else: ?>
                <p>No cats available today.</p>
            <?php endif; ?>
        </section>

        <!-- Guide of the Day -->
        <section class="feature">
            <h2>📖 Guide of the Day</h2>
            <?php if ($guide): ?>
                <p><strong><?php echo $guide['title']; ?></strong></p>
                <p><?php echo substr($guide['description'], 0, 100); ?>...</p>
                <a href="guide.html" class="btn">Read More</a>
            <?php else: ?>
                <p>No guide available today.</p>
            <?php endif; ?>
        </section>

        <!-- Merchandise of the Day -->
        <section class="feature">
            <h2>🛍 Merchandise of the Day</h2>
            <?php if ($merch): ?>
                <img src="IMAGES/<?php echo $merch['images']; ?>" alt="<?php echo $merch['item_name']; ?>">
                <p><strong><?php echo $merch['item_name']; ?></strong> - $<?php echo $merch['price']; ?></p>
                <a href="merchandise.php" class="btn">Buy Now</a>
            <?php else: ?>
                <p>No merchandise available today.</p>
            <?php endif; ?>
        </section>

        <!-- Fosterer of the Day -->
        <section class="feature">
            <h2>🏡 Fosterer of the Day</h2>
            <?php if ($foster): ?>
                <img src="IMAGES/<?php echo $foster['images']; ?>" alt="<?php echo $foster['fosterer_name']; ?>">
                <p><strong><?php echo $foster['fosterer_name']; ?></strong></p>
                <a href="adoption.php" class="btn">View Listings</a>
            <?php else: ?>
                <p>No fosterers featured today.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Pawfect Treats. All Rights Reserved.</p>
    </footer>
</body>
</html>
