<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<!-- Automatically initialise database -->
<?php include("inc/database_connection.inc"); ?>

<!-- Error Log -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

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

            <h2 class="enquiries-title">Quick Enquiry Overview</h2>
            <?php
                // --- sneak-peek of latest 5 enquiries ---
                $previewSql  = "
                SELECT id,
                        firstname,
                        enquirytype,
                        message
                    FROM enquiries
                ORDER BY submitted_at DESC
                LIMIT 5
                ";
                if ($previewResult = mysqli_query($conn, $previewSql)):
                ?>
                <ul class="enquiries-preview">
                    <?php while ($row = mysqli_fetch_assoc($previewResult)): 
                        $msg     = $row['message'];
                        $words = preg_split('/\s+/', trim($msg));
                        if (count($words) > 30) {
                            $preview = implode(' ', array_slice($words, 0, 30)) . '…';
                        } else {
                            $preview = $msg;
                        }
                    ?>
                    <li>
                        <div class="preview-text">
                        <strong><?= htmlspecialchars($row['firstname']) ?></strong>
                        (<em><?= htmlspecialchars($row['enquirytype']) ?></em>):
                        <?= htmlspecialchars($preview) ?>
                        </div>
                        <a href="reply_enquiry.php?id=<?= $row['id'] ?>" class="reply-btn">Reply</a>
                    </li>
                    <?php endwhile; ?>
                </ul>
                <?php
                mysqli_free_result($previewResult);
                endif;
                ?>


        </section>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>
    <?php include("inc/footer.inc"); ?>
</body>

</html>