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
    <title>Chinese New Year Specials</title>
    <meta name="description" content="Brew & Go Chinese New Year Promotions">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>
    <main class="current-cny-container">
        <div class="current-cny-banner">
            <h1>新年快乐! Happy Chinese New Year!</h1>
            <p class="current-cny-subtitle">Year of the Dragon 2024</p>
        </div>

        <div class="current-cny-content">
            <section class="current-cny-promo">
                <h2>Special Promotion</h2>
                <div class="current-promo-card">
                    <img src="images/mandarin_oren.png" alt="Mandarin Oranges" class="current-orange-icon">
                    <p>Redeem <strong>FREE Mandarin Oranges</strong> when you purchase 2 drinks or more!</p>
                </div>
            </section>

            <section class="current-cny-hours">
                <h2>Special Operating Hours</h2>
                <div class="current-hours-card">
                    <ul class="current-special-hours">
                        <li><span class="current-date">January 28th:</span> 9am - 3pm (Closed early for CNY celebration)
                        </li>
                        <li><span class="current-date">January 29th:</span> 12pm - 6pm</li>
                        <li><span class="current-date">January 30th:</span> 12pm - 6pm</li>
                        <li><span class="current-date">January 31st:</span> 12pm - 6pm</li>
                    </ul>
                    <div class="current-resume-notice">
                        <p>Business resumes as usual from <strong>February 1st</strong> at 9am-6pm.</p>
                    </div>
                </div>
            </section>

            <section class="current-cny-tradition">
                <h2>CNY Tradition</h2>
                <p>Mandarin oranges symbolize good luck and prosperity. We're sharing this tradition with our valued
                    customers!</p>
            </section>
        </div>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>