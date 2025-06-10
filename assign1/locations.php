<!DOCTYPE html>
<html lang="en">

<!-- Automatically initialise database -->
<?php include("inc/database_connection.inc"); ?>

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Locations</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/icon">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main class="no-margin-top">
        <!--Location Section-->
        <div class="location-section">
            <h2>Our Locations</h2>
            <div class="location-cards">

                <div class="location-card">
                    <div class="flip-container">
                        <div class="location-card-inner">
                            <div class="location-card-front">
                                <img src="images/location/one_jaya.jpg" alt="Location 1 Image">
                            </div>
                            <div class="location-card-back">
                                <a href="https://maps.app.goo.gl/8ap6MykG7yn7rF7A6">
                                    <img src="images/location/Location_1.png" alt="Location 1 Back Image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <h3>One Jaya</h3>
                    <p>G63, Lot, Onejaya Shopping Complex</p>
                    <a href="location1.php" class="btn">Learn more</a>
                </div>

                <div class="location-card">
                    <div class="flip-container">
                        <div class="location-card-inner">
                            <div class="location-card-front">
                                <img src="images/location/plaza_merdeka.jpg" alt="Location 2 Image">
                            </div>
                            <div class="location-card-back">
                                <a href="https://maps.app.goo.gl/kzNmquJ9gRcB5vxL7">
                                    <img src="images/location/Location_2.png" alt="Location 2 Back Image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <h3>Plaza Merdeka</h3>
                    <p>Jalan Tun Abang Haji Openg</p>
                    <a href="location2.php" class="btn">Learn more</a>
                </div>
            </div>
        </div>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>

</html>