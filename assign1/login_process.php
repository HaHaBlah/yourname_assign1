<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Anti-spam check
$antiSpamPath = __DIR__ . '/anti_spam_check.php';
if (! file_exists($antiSpamPath)) {
    die("DEBUG ERROR: Cannot find anti_spam_check.php at path: " . htmlspecialchars($antiSpamPath));
}
require_once $antiSpamPath;

// Database & error handler
require_once __DIR__ . '/inc/database_connection.inc';
require_once __DIR__ . '/error_handler.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Collect & validate input
$username     = trim($_POST['username'] ?? '');
$userPassword = $_POST['password']   ?? '';

if ($username === '' || $userPassword === '') {
    header('Location: login.php?error=empty_fields');
    exit;
}

// --- 1) Attempt admin login ---
$stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($hash);
    $stmt->fetch();
    if (password_verify($userPassword, $hash)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username']  = $username;
        $_SESSION['role']      = 'admin';
        $_SESSION['admin_logged_in'] = ($role === 'admin'); // $_SESSION['admin_logged_in'] means anyone who logged in, not only just for admin. Changing the name would take some time.
        header('Location: admin_dashboard.php');
        exit;
    }
}
$stmt->close();

// --- 2) Attempt member login ---
$stmt = $conn->prepare("
    SELECT password, role
      FROM members
     WHERE username = ?
       AND email_verified = 1
");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows !== 1) {
    header('Location: login.php?error=invalid_credentials');
    exit;
}

$stmt->bind_result($hash, $role);
$stmt->fetch();

if (! password_verify($userPassword, $hash)) {
    header('Location: login.php?error=invalid_credentials');
    exit;
}

// --- 3) Success: set session + redirect by role ---
$_SESSION['logged_in'] = true;
$_SESSION['username']  = $username;
$_SESSION['role']      = $role;

// send admin to admin dashboard; all others to user dashboard
$dest = ($role === 'admin')
      ? 'admin_dashboard.php'
      : 'welcome.php';

header("Location: {$dest}");
exit;
