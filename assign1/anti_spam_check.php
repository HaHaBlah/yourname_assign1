<?php
$WINDOW_SECONDS  = 60;   
$MAX_IN_WINDOW   = 5;     
$BLOCK_DURATION  = 300;   

$ip  = $_SERVER['REMOTE_ADDR'];
$now = time();

$mysqli = new mysqli('localhost', 'root', '', 'brew&go_db');
if ($mysqli->connect_errno) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Anti-Spam Error</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <?php include("inc/top_navigation_bar.inc"); ?>
        <main>
            <section class="login-container">
                <div class="login-left">
                    <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                    <h2>Anti-Spam Protection</h2>
                </div>
                <div class="login-right">
                    <h3 style="color:#b71c1c;">Database connection failed (anti-spam)</h3>
                    <p>' . htmlspecialchars($mysqli->connect_error) . '</p>
                    <a href="enquiry.php" class="responsive-hover-button">Back</a>
                </div>
            </section>
        </main>
        <?php include("inc/scroll_to_top_button.inc"); ?>
        <?php include("inc/footer.inc"); ?>
    </body>
    </html>';
    exit;
}

$createTableSql = "
    CREATE TABLE IF NOT EXISTS spam_control (
      ip_address     VARCHAR(45)    NOT NULL PRIMARY KEY,
      attempt_count  INT            NOT NULL DEFAULT 0,
      first_attempt  INT            NOT NULL,
      blocked_until  INT            NOT NULL DEFAULT 0
    ) ENGINE=InnoDB;
";

if (!$mysqli->query($createTableSql)) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Anti-Spam Error</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <?php include("inc/top_navigation_bar.inc"); ?>
        <main>
            <section class="login-container">
                <div class="login-left">
                    <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                    <h2>Anti-Spam Protection</h2>
                </div>
                <div class="login-right">
                    <h3 style="color:#b71c1c;">Anti-spam table error</h3>
                    <p>' . htmlspecialchars($mysqli->error) . '</p>
                    <a href="enquiry.php" class="responsive-hover-button">Back</a>
                </div>
            </section>
        </main>
        <?php include("inc/scroll_to_top_button.inc"); ?>
        <?php include("inc/footer.inc"); ?>
    </body>
    </html>';
    exit;
}

$stmt = $mysqli->prepare("
    SELECT attempt_count, first_attempt, blocked_until
      FROM spam_control
     WHERE ip_address = ?
");
$stmt->bind_param('s', $ip);
$stmt->execute();
$stmt->bind_result($attemptCount, $firstAttempt, $blockedUntil);
$found = $stmt->fetch();
$stmt->close();

if (! $found) {
    $attemptCount = 0;
    $firstAttempt = $now;
    $blockedUntil = 0;

    $ins = $mysqli->prepare("
      INSERT INTO spam_control
        (ip_address, attempt_count, first_attempt, blocked_until)
      VALUES (?, 0, ?, 0)
    ");
    $ins->bind_param('si', $ip, $firstAttempt);
    $ins->execute();
    $ins->close();
}

if ($now < $blockedUntil) {
    $secsLeft = $blockedUntil - $now;
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Submission Blocked</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <?php include("inc/top_navigation_bar.inc"); ?>
        <main>
            <section class="login-container">
                <div class="login-left">
                    <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                    <h2>Anti-Spam Protection</h2>
                </div>
                <div class="login-right">
                    <h3 style="color:#b71c1c;">Submission Blocked</h3>
                    <p>You are temporarily blocked from submitting.<br>
                    Please try again in <strong>' . intval($secsLeft) . ' seconds</strong>.</p>
                    <a href="enquiry.php" class="responsive-hover-button">Back</a>
                </div>
            </section>
        </main>
        <?php include("inc/scroll_to_top_button.inc"); ?>
        <?php include("inc/footer.inc"); ?>
    </body>
    </html>';
    $mysqli->close();
    exit;
}

if ($attemptCount > $MAX_IN_WINDOW) {
    $blockedUntil = $now + $BLOCK_DURATION;

    $update = $mysqli->prepare("
      UPDATE spam_control
         SET attempt_count = ?,
             first_attempt = ?,
             blocked_until = ?
       WHERE ip_address = ?
    ");
    $update->bind_param('iiis', $attemptCount, $firstAttempt, $blockedUntil, $ip);
    $update->execute();
    $update->close();

    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Too Many Submissions</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <?php include("inc/top_navigation_bar.inc"); ?>
        <main>
            <section class="login-container">
                <div class="login-left">
                    <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                    <h2>Anti-Spam Protection</h2>
                </div>
                <div class="login-right">
                    <h3 style="color:#b71c1c;">Too Many Submissions</h3>
                    <p>Too many submissions in a short period.<br>
                    You are blocked for <strong>' . ($BLOCK_DURATION / 60) . ' minutes</strong>.</p>
                    <a href="enquiry.php" class="responsive-hover-button">Back</a>
                </div>
            </section>
        </main>
        <?php include("inc/scroll_to_top_button.inc"); ?>
        <?php include("inc/footer.inc"); ?>
    </body>
    </html>';
    exit;
} else {
    $update = $mysqli->prepare("
      UPDATE spam_control
         SET attempt_count = ?,
             first_attempt = ?,
             blocked_until = 0
       WHERE ip_address = ?
    ");
    $update->bind_param('iis', $attemptCount, $firstAttempt, $ip);
    $update->execute();
    $update->close();
}

$mysqli->close();
?>
