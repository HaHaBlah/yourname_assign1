<!--One Jaya-->
<!DOCTYPE html>
<html lang="en">

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>One Jaya Location | Brew & Go Coffee</title>
    <meta name="description" content="Visit our One Jaya location for great coffee">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <header class="location-header" id="image-location1">
        <h1>One Jaya</h1>
        <!--<img src="images/location/one jaya.png">-->
    </header>

    <main class="no-margin-top location2">
        <section>
            <h2>Address</h2>
            <p>Ground Floor, G63, Lot, Onejaya Shopping Complex,<br>
                11430, Jalan Song, Tabuan Heights,<br>
                93350 Kuching, Sarawak</p>
            <h2>Opening Hours</h2>
            <p>Monday - Sunday: 9:00 AM - 6:00 PM</p>
        </section>

        <div class="location-container">
            <div class="map-container">
                <a href="https://www.google.com/maps/place/Brew+and+Go/@1.5176329,110.3657563,3a,75y,90t/data=!3m8!1e2!3m6!1sCIHM0ogKEICAgIDD0OrAOw!2e10!3e12!6shttps:%2F%2Flh3.googleusercontent.com%2Fgps-cs-s%2FAB5caB_RUUe7y9HaJsq3XvsqrO3XdlbLtTe0mwHqXw6VQZRXt5JNMa8Bts7xGYGzCv8HhXO7neBDnon8JVZc0FrRFRtqEBensp9h0RekHa3YV6PtzdPAlgNW1bhPCpl6HoXGYaJEzcJW%3Dw203-h270-k-no!7i3000!8i4000!4m7!3m6!1s0x31fba7003da964cb:0xf8d14c19ed1634a4!8m2!3d1.5178431!4d110.3659118!10e5!16s%2Fg%2F11y3sr_fz1?entry=ttu&g_ep=EgoyMDI1MDQwMi4xIKXMDSoASAFQAw%3D%3D"
                    target="_blank" class="map-link">
                    Open in Google Maps →
                </a>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15953.675113405434!2d110.3657563!3d1.5176329!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba7003da964cb%3A0xf8d14c19ed1634a4!2sBrew%20and%20Go!5e0!3m2!1sen!2smy!4v1744122746072!5m2!1sen!2smy"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!--https://codepel.com/carousel/css-carousel-slider-without-javascript/-->
            <section class="carousel" aria-label="Gallery">
                <ol class="carousel__viewport">
                    <li id="carousel__slide1" tabindex="0" class="carousel__slide">
                        <img src="images/location/one_jaya_1.jpg" alt="Brew n go One Jaya">
                        <div class="carousel__snapper">
                            <a href="#carousel__slide4" class="carousel__prev">Go to last slide</a>
                            <a href="#carousel__slide2" class="carousel__next">Go to next slide</a>
                        </div>
                    </li>
                    <li id="carousel__slide2" tabindex="0" class="carousel__slide">
                        <img src="images/location/one_jaya_2.jpg" alt="Brew n go One Jaya">
                        <div class="carousel__snapper"></div>
                        <a href="#carousel__slide1" class="carousel__prev">Go to previous slide</a>
                        <a href="#carousel__slide3" class="carousel__next">Go to next slide</a>
                    </li>
                    <li id="carousel__slide3" tabindex="0" class="carousel__slide">
                        <img src="images/location/one_jaya_3.jpg" alt="Brew n go One Jaya">
                        <div class="carousel__snapper"></div>
                        <a href="#carousel__slide2" class="carousel__prev">Go to previous slide</a>
                        <a href="#carousel__slide4" class="carousel__next">Go to next slide</a>
                    </li>
                    <li id="carousel__slide4" tabindex="0" class="carousel__slide">
                        <img src="images/location/one_jaya_4.jpg" alt="Brew n go One Jaya">
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
                Plaza Merdeka</h2>
            <div class="center">
                <a href="location2.html"><img class="location-other responsive-hover-img"
                        src="images/location/plaza_merdeka.jpg" alt=""></a>
            </div>
        </section>

    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>