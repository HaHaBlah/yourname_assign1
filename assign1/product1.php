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
    <title>Basic Brew</title>
    <meta name="description" content="Brew & Go Coffee Products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main>
        <h1 class="product-product-title">Basic Brew</h1>
        <div class="product-gallery">
            <section class="product-content">
                <img src="images/Coffee/Cappuccino_Cold_foam.jpeg" alt="Iced Cappuccino">
                <h3>Iced Cappuccino</h3>
                <p class="price"><span class="product-mp-price">MP: RM13.90</span> <span class="divider">|</span> <span
                        class="product-np-price">NP: RM15.90</span></p>
                <!-- Iced Cappuccino -->
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="1">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>

            </section>

            <!-- Cheese Americano -->
            <section class="product-content">
                <img src="images/Coffee/Iced_Americano.png" alt="Iced Americano">
                <h3>Iced Americano</h3>
                <p class="price"><span class="product-mp-price">MP: RM10.90</span> <span class="divider">|</span> <span
                        class="product-np-price">NP: RM12.90</span></p>
                <!-- Iced Americano -->
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="2">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Butterscotch Creme Latte -->
            <section class="product-content">
                <img src="images/Coffee/Iced_Latte.png" alt="Iced Latte">
                <h3>Iced Latte</h3>
                <p class="price"><span class="product-mp-price">MP: RM12.90</span> <span class="divider">|</span> <span
                        class="product-np-price">NP: RM14.90</span></p>
                <!-- Iced Latte -->
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="3">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Sidebar for Store Locations -->
            <aside class="product-sidebar">
                <h2>*Add on RM2 for Oat Milk</h2>
            </aside>
        </div>
    </main>

    <p class="product-price-details"><em>*MP: Member Price NP: Normal Price</em></p>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>