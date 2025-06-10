<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brew&go_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$token = $_GET['token'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification | Brew & Go Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main>
        <section class="login-container" id="verify-email-container">
            <div class="login-left">
                <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                <h2>Email Verification</h2>
            </div>
            <div class="login-right">
                <?php
                if (!$token) {
                    echo "<h3>Invalid verification link.</h3>";
                } else {
                    $stmt = $conn->prepare("SELECT id, verification_expires, email_verified FROM members WHERE verification_token=?");
                    $stmt->bind_param("s", $token);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows === 1) {
                        $stmt->bind_result($id, $expires, $verified);
                        $stmt->fetch();
                        if ($verified) {
                            echo "<h3>Email already verified.</h3>";
                        } elseif (strtotime($expires) >= time()) {
                            // Mark as verified
                            $update = $conn->prepare("UPDATE members SET email_verified=1, verification_token=NULL, verification_expires=NULL WHERE id=?");
                            $update->bind_param("i", $id);
                            $update->execute();
                            echo "<h3>Email verified successfully!
                            </h3><a href='login.php' class='responsive-hover-button button'>Login here</a>";
                        } else {
                            echo "<h3>Verification link expired. Please register again.</h3>";
                        }
                    } else {
                        echo "<h3>Invalid verification link.</h3>";
                    }
                    $stmt->close();
                }
                ?>
            </div>
        </section>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>
    <?php include("inc/footer.inc"); ?>
    <?php $conn->close(); ?>
</body>

</html>