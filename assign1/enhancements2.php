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
    <title>Enhancements</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main class="enhancements">

        <!-- User Management Module -->
        <section>
            <h2>User Management Module</h2>
            <p></p>
            <p>Uses: </p>
            <h2>.php</h2>
            <div class="code">
                <span>
                </span>
            </div>
        </section>

        <!-- Promotion and News Update Module -->
        <section>
            <h2>Promotion and News Update Module</h2>
            <p></p>
            <p>Uses: </p>
            <h2>.php</h2>
            <div class="code">
                <span>
                </span>
            </div>
        </section>

        <!-- Job Application Module -->
        <section>
            <h2>Job Application Module</h2>
            <p></p>
            <p>Uses: </p>
            <h2>.php</h2>
            <div class="code">
                <span>
                </span>
            </div>
        </section>

        <!-- Member Top-up Module -->
        <section>
            <h2>Member Top-up Module</h2>
            <p></p>
            <p>Uses: </p>
            <h2>.php</h2>
            <div class="code">
                <span>
                </span>
            </div>
        </section>

        <!-- Product Search Feature -->
        <section>
            <h2>Product Search Feature</h2>
            <p>This feature allows Website users to search products or services offered based on their preference(s), filters or keyword(s) given by user.</p>
            <p>Uses: <a href="product.php">product.php</a></p>
            <img src="images/enhancements/Product_Search.png" alt="Product Search">
            <h2>product.php</h2>
            <div class="code">
                <span>
                    &lt;?php foreach ($results as $product): ?><br>
                        &nbsp;&nbsp;&nbsp;&lt;?php if (!empty($product['image_url'])): ?><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;img src="&lt;?php echo htmlspecialchars($product['image_url']); ?>" alt="&lt;?php echo htmlspecialchars($product['name']); ?>"><br>
                        &nbsp;&nbsp;&nbsp;&lt;?php else: ?><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;p>No image available&lt;/p><br>
                        &nbsp;&nbsp;&nbsp;&lt;?php endif; ?><br>
                    &lt;?php endforeach; ?><br>
                </span>
            </div>
        </section>

        <!-- Anti-Spam Feature -->
        <section>
            <h2>Anti-Spam Feature</h2>
            <p>If someone tries to submit a form too many times in a short period, they will be temporarily blocked.</p>
            <p>Uses: <a href="anti_spam_check.php">anti_spam_check.php</a></p>
            <img src="images/enhancements/Anti_Spam.png" alt="Anti-Spam">
            <h2>anti_spam_check.php</h2>
            <div class="code">
                <span>
                    if ($now - $firstAttempt > $WINDOW_SECONDS) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp$attemptCount = 1;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp$firstAttempt = $now;<br>
                    } else {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp$attemptCount++;<br>
                    }<br>
                    <br>    
                    if ($attemptCount > $MAX_IN_WINDOW) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp$blockedUntil = $now + $BLOCK_DURATION;<br>
                    }
                    <br>
                    if ($now < $blockedUntil) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp$secsLeft = $blockedUntil - $now;<br>
                        &nbsp;&nbsp;&nbsp;&nbspshow_antispam_page();<br>
                    }
                </span>
            </div>
        </section>

        <!-- Email Verification Module -->
        <section>
            <h2>Email Verification Module</h2>
            <p>User emails are verified by sending them an email with a link to click. Only verified users are able to login.</p>
            <p>Uses: <a href="membership_process.php">membership_process.php</a>, <a href="verification_email.php">verification_email.php</a>, <a href="verify_email.php">verify_email.php</a>. This also requires editing xampp's sendmail.ini and php.ini files locally.</p>
            <img src="images/enhancements/Email_Verification.png" alt="Email Verification">
            <img src="images/enhancements/Email_Verification2.png" alt="Email Verification2">
            <h2>membership_process.php</h2>
            <div class="code">
                <span>
                    $sql = "CREATE TABLE IF NOT EXISTS members (<br>
                        &nbsp;&nbsp;&nbsp;firstname VARCHAR(25) NOT NULL,<br>
                        &nbsp;&nbsp;&nbsp;email VARCHAR(50) NOT NULL,<br>
                        &nbsp;&nbsp;&nbsp;reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,<br>
                        &nbsp;&nbsp;&nbsp;email_verified TINYINT(1) DEFAULT 0,<br>
                        &nbsp;&nbsp;&nbsp;verification_token VARCHAR(64),<br>
                        &nbsp;&nbsp;&nbsp;verification_expires DATETIME,<br>
                    )";<br>
                    <br>
                    if ($stmt->execute()) {<br>
                        &nbsp;&nbsp;&nbsp;$verify_link = "http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/verify_email.php?token=$token";<br>
                        &nbsp;&nbsp;&nbsp;$subject = "Verify your Brew & Go Coffee Membership";<br>
                        &nbsp;&nbsp;&nbsp;$message = get_verification_email($firstname, $verify_link);<br>
                        &nbsp;&nbsp;&nbsp;$headers = "MIME-Version: 1.0" . "\r\n";<br>
                        &nbsp;&nbsp;&nbsp;$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";<br>
                        &nbsp;&nbsp;&nbsp;$headers .= "From: brewngo.coffee@gmail.com" . "\r\n";<br>
                        <br>
                        &nbsp;&nbsp;&nbsp;mail($email, $subject, $message, $headers);<br>
                </span>
            </div>
            <h2>verification_email.php</h2>
            <div class="code">
                <span>
                    &lt;a href="$verify_link">Verify Email&lt;/a>
                </span>
            </div>
        </section>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>