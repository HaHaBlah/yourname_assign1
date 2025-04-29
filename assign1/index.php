<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Brew & Go.</title>
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>


    <!--Main page starts here-->
    <!--Intro Section-->
    <div class="welcome">
        <h1>Welcome to
            <span>Brew & Go.</span>
        </h1>
        <p>Your one-stop shop for the best coffee in town!</p>
        <div class="scroll-indicator">
            <span>Scroll Down</span>
            <div class="mouse">
                <div class="scroll-wheel"></div>
            </div>
        </div>
    </div>

    <!--Introduction to Company-->
    <div class="introduction">
        <div class="introduction-image">
            <img src="images/location/one_jaya_1.jpg" alt="Brew & Go logo">
        </div>
        <div class="introduction-content">
            <h2>About Brew & Go.</h2>
            <h3>
                Brew & Go. Coffee is a local Kuching-based brand specializing in handcrafted coffee beverages. In
                addition to coffee, their menu also includes non-coffee beverages such as matcha and chocolate.
            </h3>
            <p>
                Established in 2023 as a home-based business, Brew & Go opened its first coffee kiosk at One Jaya Mall
                in
                2024. Recently, they expanded and launched their second kiosk at Plaza Merdeka Shopping Centre and are
                now seeking opportunities for further growth.
            </p>
        </div>
    </div>

    <!--Why choose Brew and Go?-->
    <div class="why-choose">
        <h2>Why choose Brew and Go.</h2>
        <p class="main-description">At Brew and Go, we prioritize quality and customer satisfaction. Our handcrafted
            beverages are made from the finest ingredients, ensuring a delightful experience with every sip.</p>

        <div class="feature-container">
            <div class="feature-box">
                <img src="images/Fast&Convenient.png" alt="Fast & Convenient"> <!--Image might not be relevant-->
                <h3>Fast & Convenient</h3>
            </div>
            <div class="feature-box">
                <img src="images/Consistent_Quality.svg" alt="Consistent Quality">
                <h3>Consistent Quality</h3>
            </div>
            <div class="feature-box">
                <img src="images/Perfect_for_On-the-Go.png" alt="Perfect for On-the-Go">
                <h3>Perfect for On-the-Go</h3>
            </div>
        </div>
    </div>

    <!--Top Product Showcase-->
    <div class="product-showcase">
        <h2>Product Showcase</h2>
        <p>Discover our wide range of handcrafted coffee beverages and non-coffee beverages.</p>
        <div class="explore">
            <a href="products.html" class="btn">Explore</a>
        </div>
    </div>

    <!-- Promotion Section -->
    <div class="promotion-section">
        <div class="latest-promotion">
            <h2>Latest Promotion</h2>
            <p>Check out our special offers and discounts!</p>
        </div>
        <div class="promotion-poster">
            <!-- Promotion Poster 1 -->
            <div class="poster">
                <div class="poster-content">
                    <h3>March Promotions</h3>
                    <p>Get 1 FREE drink and 1 RM10 voucher if you topup with a minimum of RM50! Only available at our
                        <a href="https://www.facebook.com/LovePlazaM">Plaza Merdeka</a> outlet.
                    </p>
                </div>
            </div>
            <!-- Promotion Poster 2 -->
            <div class="poster">
                <div class="poster-content">
                    <h3>FREE ORANGES!!! 🍊🧧🪭</h3>
                    <p>Redeem free oranges from us when you purchase 2 drinks & more. Starting from Saturday 25/1 and
                        while stocks last. Come come!!</p>
                </div>
            </div>
            <!-- Promotion Poster 3 -->
            <div class="poster">
                <div class="poster-content">
                    <h3>Christmas Promotions</h3>
                    <p>Join our membership to get our Christmas gift voucher! 🎄❄️ Perfect for your friends & family in
                        this season of giving 😍</p>
                </div>
            </div>
        </div>
    </div>

    <!--Latest News-->
    <div class="latest-news">
        <h2>Latest News</h2>
        <p>Stay tuned for our upcoming events and news updates!</p>
        <div class="learn-more">
            <a href="activities.html" class="btn">Learn More</a>
        </div>
    </div>

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
                <a href="location1.html" class="btn">Learn more</a>
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
                <a href="location2.html" class="btn">Learn more</a>
            </div>
        </div>
    </div>

    <?php include("inc/scroll_to_top_button.inc"); ?>

    <!--Footer Section-->
    <footer>
        <div class="footer-container">
            <div>
                <a class="our-video responsive-hover-button" href="https://youtu.be/2sI68nrl5yE">Our Video</a>
            </div>
            <?php include("inc/footerbare.inc"); ?>
        </div>
    </footer>
</body>

</html>