<?php
$WINDOW_SECONDS  = 60;   
$MAX_IN_WINDOW   = 5;     
$BLOCK_DURATION  = 300;   

$ip  = $_SERVER['REMOTE_ADDR'];
$now = time();

$mysqli = new mysqli('localhost', 'root', '', 'brew&go_db');
if ($mysqli->connect_errno) {
    echo '<div style="max-width:500px;margin:2em auto;padding:1.5em;background:#ffeaea;border:1px solid #e57373;color:#b71c1c;font-family:sans-serif;border-radius:8px;text-align:center;">
            <h2>Anti-Spam Error</h2>
            <p>Database connection failed (anti-spam): ' . htmlspecialchars($mysqli->connect_error) . '</p>
          </div>';
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
    echo '<div style="max-width:500px;margin:2em auto;padding:1.5em;background:#ffeaea;border:1px solid #e57373;color:#b71c1c;font-family:sans-serif;border-radius:8px;text-align:center;">
            <h2>Anti-Spam Error</h2>
            <p>Failed to create or verify spam_control table: ' . htmlspecialchars($mysqli->error) . '</p>
          </div>';
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
    echo '<div style="max-width:500px;margin:2em auto;padding:1.5em;background:#fff3cd;border:1px solid #ffe082;color:#795548;font-family:sans-serif;border-radius:8px;text-align:center;">
            <h2>Submission Blocked</h2>
            <p>You are temporarily blocked from submitting.<br>
            Please try again in <strong>' . intval($secsLeft) . ' seconds</strong>.</p>
          </div>';
    $mysqli->close();
    exit;
}

if ($now - $firstAttempt > $WINDOW_SECONDS) {
    $attemptCount = 0;
    $firstAttempt = $now;
}

$attemptCount++;

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

    echo '<div style="max-width:500px;margin:2em auto;padding:1.5em;background:#ffeaea;border:1px solid #e57373;color:#b71c1c;font-family:sans-serif;border-radius:8px;text-align:center;">
            <h2>Too Many Submissions</h2>
            <p>Too many submissions in a short period.<br>
            You are blocked for <strong>' . ($BLOCK_DURATION / 60) . ' minutes</strong>.</p>
          </div>';
    $mysqli->close();
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