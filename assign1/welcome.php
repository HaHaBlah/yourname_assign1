<!-- Automatically initialise database -->
<?php include("inc/database_connection.inc"); ?>

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<?php
// Redirect to login if not logged in or not a user
// if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
//     header('Location: login.php');
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome - Brew & Go Coffee</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main>
        <section class="login-container" id="antispam-container">
            <div class="login-left">
                <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                <h2>Welcome</h2>
                <p>Welcome to Brew & Go Coffee</p>
            </div>
            <div class="login-right">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p>Thanks for logging into Brew & Go Coffee.</p>
                    <a href="index.php" class="responsive-hover-button button center">Back</a>
            </div>
        </section>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>
</html>