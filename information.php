<?php
session_start();
include("db.php");

// Ensure an ID is provided in the URL
$user = null;
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Convert to integer for safety

    // Fetch the user's information
    $sql = "SELECT username, email, phone, city, image FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result); // Fetch the single user
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <!-- Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/information.css">
</head>

<body>
    <nav>
        <h2>KHADAMATI</h2>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="contact.html">Contact Us</a></li>
        </ul>
    </nav>

    <section>
        <div class="card">
            <div class="card-content">
                <?php if ($user): ?>  
                    <div class="profile-header">
                        <div class="image">
                            <?php
                            $fileName = $user["image"];
                            $imageUrl = "upload/" . $fileName;
                            
                            if (!empty($fileName) && file_exists($imageUrl)) {
                                echo "<img src='$imageUrl' alt='Profile Image'>";
                            } else {
                                echo "<img src='imgs/ar.png' alt='Default Profile Image'>";
                            }
                            ?>
                        </div>
                        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                    </div>

                    <div class="profile-details">
                        <div class="text">
                            <h3>Username:</h3>
                            <p><?php echo htmlspecialchars($user['username']); ?></p>

                            <h3>E-mail:</h3>
                            <p><?php echo htmlspecialchars($user['email']); ?></p>
                            
                            <h3>Phone Number:</h3>
                            <p><?php echo htmlspecialchars($user['phone']); ?></p>
                            
                            <h3>City:</h3>
                            <p><?php echo htmlspecialchars($user['city']); ?></p>
                        </div>

                        <div class="user-image">
                            <?php
                            if (!empty($fileName) && file_exists($imageUrl)) {
                                echo "<img src='$imageUrl' alt='User Image'>";
                            } else {
                                echo "<p class='no-image'>No Additional Image Available</p>";
                            }
                            ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-user">
                        <h3>User Not Found</h3>
                        <p>The requested user profile could not be found.</p>
                        <a href="index.html" class="home-link">Return to Home</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>