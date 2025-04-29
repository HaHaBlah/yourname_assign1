<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Locations</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>
    <!-- Video Banner Section -->
    <div class="video-banner">
        <video autoplay loop muted>
            <source src="video/Strawberry_latte.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="title"><span class="cursive-text">Once a Strawberry Latte addict, forever a Strawberry Latte
                addict🍓☕</span></div>
    </div>

    <main>

        <!-- Review Cards Section -->
        <div class="review-cards">
            <!-- Review Card 1 -->
            <div class="review-card">
                <div class="stars">
                    ★ ★ ★ ★ ★
                </div>
                <div class="comment">
                    "The best Strawberry Latte I've ever had! The taste is perfect every time!"
                </div>
                <div class="name">
                    John Doe
                </div>
            </div>

            <!-- Review Card 2 -->
            <div class="review-card">
                <div class="stars">
                    ★ ★ ★ ★ ★
                </div>
                <div class="comment">
                    "Absolutely love it! The creamy texture and the strawberry flavor are just perfect."
                </div>
                <div class="name">
                    Jane Smith
                </div>
            </div>

            <!-- Review Card 3 -->
            <div class="review-card">
                <div class="stars">
                    ★ ★ ★ ★ ★
                </div>
                <div class="comment">
                    "Can't get enough of this drink! It's my go-to whenever I need a pick-me-up."
                </div>
                <div class="name">
                    Alex Johnson
                </div>
            </div>
        </div>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>