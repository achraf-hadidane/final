<?php
session_start();
include("db.php");


$city_filter = isset($_GET['city']) ? $_GET['city'] : '';


$sql = "SELECT id, username, city FROM users WHERE profession = 'builder'";
if (!empty($city_filter)) {
    $sql .= " AND city = '" . mysqli_real_escape_string($conn, $city_filter) . "'";
}

$result = mysqli_query($conn, $sql);

$electricians = [];
while ($row = mysqli_fetch_assoc($result)) {
    $electricians[] = $row;
}


$cities_sql = "SELECT DISTINCT city FROM users WHERE profession = 'builder' ORDER BY city";
$cities_result = mysqli_query($conn, $cities_sql);
$cities = [];
while ($row = mysqli_fetch_assoc($cities_result)) {
    $cities[] = $row['city'];
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Electricians - KHADAMATI</title>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/builder.css">
</head>
<body>
    <nav>
        <h2>KHADAMATI</h2>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="conect.html">Contact Us</a></li>
        </ul>
    </nav>

    <section>
    <div class="filter-container">
            <form method="GET" action="builder.php">
                <div class="filter-group">
                    <label for="city">Filter by City:</label>
                    <select name="city" id="city" onchange="this.form.submit()">
                        <option value="">All Cities</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= htmlspecialchars($city) ?>" 
                                <?= ($city == $city_filter) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($city) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
        <div class="swiper mySwiper container">
            <div class="swiper-wrapper content">
                <?php foreach ($electricians as $user): ?>
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="image">
                        <img src="imgs/builder.jpg"  />
                        </div>

                        <div class="name-profession">
                            <span class="name"><?php echo htmlspecialchars($user['username']); ?></span>
                            <span class="profession">Builder</span>
                        </div>

                        
                        <div class="button">
                            <button onclick="window.location.href='information.php?id=<?php echo $user['id']; ?>'" class="aboutMe">About Me</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            grabCursor: true,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                0: { slidesPerView: 1 },
                640: { slidesPerView: 2 },
                992: { slidesPerView: 3 }
            }
        });
    </script>
</body>
</html>