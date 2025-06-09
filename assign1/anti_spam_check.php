<?php
$WINDOW_SECONDS  = 60;   
$MAX_IN_WINDOW   = 5;     
$BLOCK_DURATION  = 300;   

$ip  = $_SERVER['REMOTE_ADDR'];
$now = time();

$mysqli = new mysqli('localhost', 'root', '', 'brew&go_db');
if ($mysqli->connect_errno) {
    die("Database connection failed (anti-spam): " . $mysqli->connect_error);
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
    die("Failed to create or verify spam_control table: " . $mysqli->error);
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
    die("You are temporarily blocked from submitting. Please try again in {$secsLeft} seconds.");
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

    die("Too many submissions in a short period. You are blocked for " . ($BLOCK_DURATION / 60) . " minutes.");
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
