<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<!-- Automatically initialise database -->
<?php include("inc/database_connection.inc"); ?>

<?php // Enable this later
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php?error=not_authorized');
    exit;
}

$adminName = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main>
        <h1>Welcome, Admin</h1>
        <section>
            <ul class="admin-tools">
                <li>
                <a href="view_enquiry.php">
                    <img src="images/Icons/enquiries.svg" alt="Enquiries">
                    <span>View Enquiries</span>
                </a>
                </li>
                <li>
                <a href="view_job.php">
                    <img src="images/Icons/job.svg" alt="Jobs">
                    <span>View Job Applications</span>
                </a>
                </li>
                <li>
                <a href="view_membership.php">
                    <img src="images/Icons/membership.svg" alt="Memberships">
                    <span>View Memberships</span>
                </a>
                </li>
            </ul>
        </section>
</main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>