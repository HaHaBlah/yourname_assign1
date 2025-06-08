<?php
// session_start();

// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit;
// }
?>

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

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
        <h2>Welcome, Admin</h2>
        
    <section>
        <h3>Admin Tools</h3>
        <ul>
            <li><a href="view_enquiry.php">View Enquiries</a></li>
            <li><a href="view_job.php">View Job Applications</a></li>
            <li><a href="view_membership.php">View Memberships</a></li>
        </ul>
    </section>
</main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>