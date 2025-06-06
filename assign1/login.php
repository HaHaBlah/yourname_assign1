<!-- Done -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login to Brew & Go. Coffee</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <header class="location-header" id="image-Coffee_Beans_Bg">
        <img src="images/Coffee_Beans_Bg.png" alt="Coffee Beans Background">
    </header>

    <main class="no-margin-top">

        <section class="login-container">
            <div class="login-left">
                <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                <h2>Login</h2>
                <p>Login to Brew & Go. Coffee</p>
            </div>
            <div class="login-right">
                <form action="user_login.php" method="post">
                    <fieldset>
                        <input class="responsive-hover" type="text" name="username" placeholder="Username" required
                            maxlength="10" pattern="[A-Za-z]+"
                            title="Alphabetical characters only; Maximum 10 characters.">
                        <input class="responsive-hover" type="text" name="password" placeholder="Password" required
                            maxlength="25" pattern="[A-Za-z]+"
                            title="Alphabetical characters only; Maximum 25 characters.">
                        <button class="responsive-hover-button" type="submit">Login</button>
                    </fieldset>
                </form>

                <div class="login-bottom">
                    <a href="registration.html">Don't have an account?</a>
                </div>
            </div>
        </section>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>