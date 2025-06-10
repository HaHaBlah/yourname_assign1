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
    <title>Non-Coffee</title>
    <meta name="description" content="Brew & Go Coffee Products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main>
        <h1 class="product-product-title">Non-Coffee</h1>
        <div class="product-gallery">
            <!-- Mint Latte (if you want to add, id=11) -->
            <!--
            <section class="product-content">
                <img src="images/Coffee/Mint_Latte.jpg" alt="Mint Latte">
                <h3>Mint Latte</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM11.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM13.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="11">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>
            -->

            <!-- Iced Strawberry Matcha -->
            <section class="product-content">
                <img src="images/Coffee/Iced_Strawberry Matcha.jpg" alt="Iced Strawberry Matcha">
                <h3>Iced Strawberry Matcha</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM16.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM18.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="14">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Iced strawberry soda -->
            <section class="product-content">
                <img src="images/Coffee/Iced_Strawberry_Soda.jpg" alt="Iced Strawberry Soda">
                <h3>Iced Strawberry Soda</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM15.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM17.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="15">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- cheese yuzu -->
            <section class="product-content">
                <img src="images/Coffee/Iced_Cheese_Yuzu.jpg" alt="Iced Cheese Yuzu">
                <h3>Iced Cheese Yuzu</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM15.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM17.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="16">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Postachio Latte -->
            <section class="product-content">
                <img src="images/Coffee/Iced_Yuzu_Matcha.jpg" alt="Iced Yuzu Matcha">
                <h3>Iced Yuzu Matcha</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM16.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM18.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="17">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

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