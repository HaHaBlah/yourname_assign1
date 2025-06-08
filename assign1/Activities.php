<!DOCTYPE html>
<html lang="en">

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Activities</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="activity-body">
    <?php include("inc/top_navigation_bar.inc"); ?>

    <header class="location-header" id="image-Coffee_Beans_Bg">
        <img src="images/Coffee_Beans_Bg.png" alt="Coffee Beans Background">
    </header>
    <main class="no-margin-top">

        <section class="activity-header">
            <h1>☕ Coffee Club Activities</h1>
            <p>Explore what's brewing at our coffee community</p>
        </section>
        
        <section class="activities-section">
            <h2>🔥 Current Activities</h2>
            <div class="activities-activity">
                <span>☕ Latte Art Workshop</span><br>
                Learn to pour like a pro! Every Saturday, 4PM.
            </div>
            <div class="activities-activity">
                <span>🎶 Acoustic Evenings</span><br>
                Live local music every Friday night.
            </div>
        </section>

        <section class="activities-section">
            <h2>⏪ Past Highlights</h2>
            <div class="activities-activity">
                <span>🎉 Coffee Carnival</span><br>
                Thank you for joining our tasting event in March!
            </div>
            <div class="activities-activity">
                <span>📸 Brew & Shoot</span><br>
                Photography + Coffee meetup – what a vibe!
            </div>
        </section>

        <section class="activities-section">
            <h2>⏳ Coming Soon</h2>
            <div class="activities-activity activities-coming-soon">
                ☀️ Sunrise Brew Hike — May 10
            </div>
            <div class="activities-activity activities-coming-soon">
                🎨 Beans & Brushes: Coffee + Painting — June
            </div>
        </section>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>

</body>

</html>