<?php
$WINDOW_SECONDS  = 60;   
$MAX_IN_WINDOW   = 5;     
$BLOCK_DURATION  = 300;   

function show_antispam_page($title, $message) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Anti-Spam Protection</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <?php include("inc/top_navigation_bar.inc"); ?>
        <main>
            <section class="login-container" id="antispam-container">
                <div class="login-left">
                    <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                    <h2>Anti-Spam Protection</h2>
                </div>
                <div class="login-right">
                    <h3><?php echo htmlspecialchars($title); ?></h3>
                    <p><?php echo $message; ?></p>
                    <a href="index.php" class="responsive-hover-button button center">Back</a>
                </div>
            </section>
        </main>
        <?php include("inc/scroll_to_top_button.inc"); ?>
        <?php include("inc/footer.inc"); ?>
    </body>
    </html>
    <?php
    exit;
}

$ip  = $_SERVER['REMOTE_ADDR'];
$now = time();

$mysqli = new mysqli('localhost', 'root', '', 'brew&go_db');
if ($mysqli->connect_errno) {
    show_antispam_page(
        "Database connection failed (anti-spam)",
        htmlspecialchars($mysqli->connect_error)
    );
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
    show_antispam_page(
        "Anti-spam table error",
        htmlspecialchars($mysqli->error)
    );
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
    // First time for this IP: insert and treat as first attempt
    $attemptCount = 1;
    $firstAttempt = $now;
    $blockedUntil = 0;

    $ins = $mysqli->prepare("
      INSERT INTO spam_control
        (ip_address, attempt_count, first_attempt, blocked_until)
      VALUES (?, 1, ?, 0)
    ");
    $ins->bind_param('si', $ip, $firstAttempt);
    $ins->execute();
    $ins->close();
} else {
    // If window expired, reset count and window
    if ($now - $firstAttempt > $WINDOW_SECONDS) {
        $attemptCount = 1;
        $firstAttempt = $now;
    } else {
        $attemptCount++;
    }
}

if ($now < $blockedUntil) {
    $secsLeft = $blockedUntil - $now;
    show_antispam_page(
        "Submission Blocked",
        "You are temporarily blocked from submitting.<br>
        Please try again in <strong>" . intval($secsLeft) . " seconds</strong>."
    );
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

    show_antispam_page(
        "Too Many Submissions",
        "Too many submissions in a short period.<br>
        You are blocked for <strong>" . ($BLOCK_DURATION / 60) . " minutes</strong>."
    );
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