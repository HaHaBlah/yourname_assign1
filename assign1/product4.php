<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hot Beverages</title>
    <meta name="description" content="Brew & Go Coffee Products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/latte_2.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main>
        <h1 class="product-product-title">Hot Beverages</h1>
        <div class="product-gallery">
            <!-- Mint Latte -->
            <section class="product-content">
                <img src="images/Coffee/Butterscotch_latte_1.jpeg" alt="Hot Butterscotch Latte">
                <h3>Hot Butterscotch Latte</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM12.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM14.90</span></p>
                <a href="https://food.grab.com/my/en/restaurant/brew-go-coffee-plaza-merdeka-delivery/1-C7AKV63CAU6TV6?"
                    target="_blank"><button class="product-buy-4">Buy Now</button></a>
            </section>

            <!-- Matcha Latte -->
            <section class="product-content">
                <img src="images/Coffee/Cappuccino_Cold_foam.jpeg" alt="Hot Cappuccino">
                <h3>Hot Cappuccino</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM12.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM14.90</span></p>
                <a href="https://food.grab.com/my/en/restaurant/brew-go-coffee-plaza-merdeka-delivery/1-C7AKV63CAU6TV6?"
                    target="_blank"><button class="product-buy-4">Buy Now</button></a>
            </section>

            <!-- Postachio Latte -->
            <section class="product-content">
                <img src="images/Coffee/Hot_Hojicha.jpg" alt="Hot Hojicha">
                <h3>Hot Hojicha</h3>
                <p class="product-price"><span class="product-mp-price">MP: RM14.90</span> <span class="product-divider">|</span> <span
                        class="product-np-price">NP: RM16.90</span></p>
                <a href="https://food.grab.com/my/en/restaurant/brew-go-coffee-plaza-merdeka-delivery/1-C7AKV63CAU6TV6?"
                    target="_blank"><button class="product-buy-4">Buy Now</button></a>
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