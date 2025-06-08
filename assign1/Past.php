<!DOCTYPE html>
<html lang="en">

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gawai Holidays</title>
    <meta name="description" content="Brew & Go Gawai Celebration 2024">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main class="past-gawai-container">
        <section class="past-gawai-banner">
            <h1>Gawai Holidays</h1>
            <p class="past-gawai-subtitle">1st–4th June 2024</p>
            <p class="past-gawai-hours">Open as usual from <strong>9am–6pm</strong></p>
        </section>

        <section class="past-tart-section">
            <h2>Tarts of the Day</h2>
            <ul class="past-tart-list">
                <li><span class="past-date">1st June:</span> Egg Tarts</li>
                <li><span class="past-date">2nd June:</span> Chicken Mushroom Tarts</li>
                <li><span class="past-date">3rd June:</span> Chocolate Almond Tarts</li>
                <li><span class="past-date">4th June:</span> Mango Tarts</li>
            </ul>
        </section>

        <footer class="past-gawai-footer">
            <p>Gayu Guru Gerai Nyamai!</p>
            <p class="brand-tag">— Brew & Go —</p>
        </footer>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>