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
    <title>Plaza Merdeka Location | Brew & Go Coffee</title>
    <meta name="description" content="Visit our Plaza Merdeka location for great coffee">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="location-page">
    <?php include("inc/top_navigation_bar.inc"); ?>

    <header class="location-header" id="image-location2">
        <h1>Plaza Merdeka</h1>
    </header>

    <main class="no-margin-top location2">
        <section>
            <h2>Address</h2>
            <p>Level 2, Plaza Merdeka,<br>
                Jalan Tun Abang Haji Openg,<br>
                93000 Kuching, Sarawak</p>
            <h2>Opening Hours</h2>
            <p>Monday - Friday: 8:00 AM - 10:00 PM<br>
                Saturday - Sunday: 9:00 AM - 11:00 PM</p>
        </section>

        <div class="location-container">
            <div class="map-container">
                <a href="https://maps.app.goo.gl/NZVsMVxM2MDohCQt5" target="_blank" class="map-link">
                    Open in Google Maps →
                </a>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.34225343413!2d110.3414420749661!3d1.5585741984268633!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba7ee0ea57329%3A0x104e8cca7140a048!2sPlaza%20Merdeka!5e0!3m2!1sen!2smy!4v1744162850777!5m2!1sen!2smy"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!--https://codepel.com/carousel/css-carousel-slider-without-javascript/-->
            <section class="carousel" aria-label="Gallery">
                <ol class="carousel__viewport">
                    <li id="carousel__slide1" tabindex="0" class="carousel__slide">
                        <img src="images/location/plaza_merdeka_1.jpg" alt="Brew n go Plaza Merdeka">
                        <div class="carousel__snapper">
                            <a href="#carousel__slide4" class="carousel__prev">Go to last slide</a>
                            <a href="#carousel__slide2" class="carousel__next">Go to next slide</a>
                        </div>
                    </li>
                    <li id="carousel__slide2" tabindex="0" class="carousel__slide">
                        <img src="images/location/plaza_merdeka_2.jpg" alt="Brew n go Plaza Merdeka">
                        <div class="carousel__snapper"></div>
                        <a href="#carousel__slide1" class="carousel__prev">Go to previous slide</a>
                        <a href="#carousel__slide3" class="carousel__next">Go to next slide</a>
                    </li>
                    <li id="carousel__slide3" tabindex="0" class="carousel__slide">
                        <img src="images/location/plaza_merdeka_3.jpg" alt="Brew n go Plaza Merdeka">
                        <div class="carousel__snapper"></div>
                        <a href="#carousel__slide2" class="carousel__prev">Go to previous slide</a>
                        <a href="#carousel__slide4" class="carousel__next">Go to next slide</a>
                    </li>
                    <li id="carousel__slide4" tabindex="0" class="carousel__slide">
                        <img src="images/location/plaza_merdeka_4.jpg" alt="Brew n go Plaza Merdeka">
                        <div class="carousel__snapper"></div>
                        <a href="#carousel__slide3" class="carousel__prev">Go to previous slide</a>
                        <a href="#carousel__slide1" class="carousel__next">Go to first slide</a>
                    </li>
                </ol>
                <aside class="carousel__navigation">
                    <ol class="carousel__navigation-list">
                        <li class="carousel__navigation-item">
                            <a href="#carousel__slide1" class="carousel__navigation-button">Go to slide 1</a>
                        </li>
                        <li class="carousel__navigation-item">
                            <a href="#carousel__slide2" class="carousel__navigation-button">Go to slide 2</a>
                        </li>
                        <li class="carousel__navigation-item">
                            <a href="#carousel__slide3" class="carousel__navigation-button">Go to slide 3</a>
                        </li>
                        <li class="carousel__navigation-item">
                            <a href="#carousel__slide4" class="carousel__navigation-button">Go to slide 4</a>
                        </li>
                    </ol>
                </aside>
            </section>
        </div>

        <section>
            <h2 class="center">Check Out Our Other Store at<br>
                One Jaya</h2>
            <div class="center">
                <a href="location1.html"><img class="location-other responsive-hover-img"
                        src="images/location/one_jaya.jpg" alt=""></a>
            </div>
        </section>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>