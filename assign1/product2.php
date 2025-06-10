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
    <title>Artisan Brew</title>
    <meta name="description" content="Brew & Go Coffee Products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main>
        <h1 class="product-product-title">Artisan Brew</h1>
        <div class="product-gallery">
            <!-- Strawberry Latte -->
            <section class="product-content">
                <img src="images/Coffee/strawberry_latte.jpeg" alt="Strawberry Latte">
                <h3>Strawberry Latte</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM14.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM16.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="4">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Cheese Americano -->
            <section class="product-content">
                <img src="images/Coffee/Cheese_Americano.jpeg" alt="Cheese Americano">
                <h3>Cheese Americano</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM13.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM15.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="5">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Butterscotch Creme Latte -->
            <section class="product-content">
                <img src="images/Coffee/Butterscotch_latte_1.jpeg" alt="Butterscotch Creme Latte">
                <h3>Butterscotch Creme Latte</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM11.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM13.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="6">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Vienna Latte -->
            <section class="product-content">
                <img src="images/Coffee/Vienna_latte.jpeg" alt="Vienna Latte">
                <h3>Vienna Latte</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM14.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM16.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="7">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Yuzu Americano -->
            <section class="product-content">
                <img src="images/Coffee/Yuzu_Americano.jpeg" alt="Yuzu Americano">
                <h3>Yuzu Americano</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM13.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM15.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="8">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Mocha -->
            <section class="product-content">
                <img src="images/Coffee/mocha.jpeg" alt="Mocha">
                <h3>Mocha</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM11.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM13.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="9">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Orange Mocha -->
            <section class="product-content">
                <img src="images/Coffee/Orange_mocha.jpeg" alt="Orange Mocha">
                <h3>Orange Mocha</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM12.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM14.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="10">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Mint Latte -->
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

            <!-- Pistachio Latte -->
            <section class="product-content">
                <img src="images/Coffee/Pistachio_Latte.jpeg" alt="Pistachio Latte">
                <h3>Pistachio Latte</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM17.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM19.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="12">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>

            <!-- Orange Americano -->
            <section class="product-content">
                <img src="images/Coffee/Orange_Americano.jpg" alt="Orange Americano">
                <h3>Orange Americano</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM13.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM15.90</span></p>
                <form action="buy_product.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="13">
                    <button type="submit" class="product-buy-4">Buy Now</button>
                </form>
            </section>
        </div>

        <aside class="product-sidebar">
            <h2>*Add on RM2 for Oat Milk</h2>
        </aside>

    </main>
    <p class="product-price-details"><em>*MP: Member Price NP: Normal Price</em></p>

    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>