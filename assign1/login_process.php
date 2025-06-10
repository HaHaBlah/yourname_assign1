<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$antiSpamPath = __DIR__ . '/anti_spam_check.php';
if (!file_exists($antiSpamPath)) {
    die("DEBUG ERROR: Cannot find anti_spam_check.php at path: " . htmlspecialchars($antiSpamPath));
}
require_once $antiSpamPath;

include("inc/login_status.inc");
require_once("inc/database_connection.inc");
require_once("error_handler.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from POST; note that we rename the posted password variable to avoid conflicts
    $username    = isset($_POST['username']) ? trim($_POST['username']) : '';
    $userPassword = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($username) && !empty($userPassword)) {
        // --- Admin login ---
        $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($adminHashedPassword);
            $stmt->fetch();
            if (password_verify($userPassword, $adminHashedPassword)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'admin';
                header("Location: admin_dashboard.php");
                exit;
            }
        }
        $stmt->close();
        
        // --- Member login ---
        $stmt = $conn->prepare("SELECT password, role FROM members WHERE username = ? AND email_verified = 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($memberHashedPassword, $role);
            $stmt->fetch();
            if (password_verify($userPassword, $memberHashedPassword)) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['admin_logged_in'] = false;
                
                if ($role === 'member') {
                    header('Location: welcome.php');
                    exit;
                } else {
                    // header('Location: dashboard.php');
                    exit;
                }
            } else {
                trigger_error("Login failed for user '{$username}': invalid password", E_USER_WARNING);
                header('Location: login.php?error=invalid_credentials');
                exit;
            }
        } else {
            trigger_error("Login failed: username '{$username}' not found or email not verified", E_USER_WARNING);
            header('Location: login.php?error=invalid_credentials');
            exit;
        }
    } else {
        header('Location: login.php?error=empty_fields');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>
