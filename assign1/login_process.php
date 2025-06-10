<?php
$antiSpamPath = __DIR__ . '/anti_spam_check.php';
if (! file_exists($antiSpamPath)) {
    die("DEBUG ERROR: Cannot find anti_spam_check.php at path: " . htmlspecialchars($antiSpamPath));
}
require_once __DIR__ . '/anti_spam_check.php';

include("inc/login_status.inc");
require_once("inc/database_connection.inc");
require_once("error_handler.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // --- Admin login from database ---
    if (!empty($username) && !empty($password)) {
        // Check admin table first
        $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($db_password);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'admin';
                header("Location: admin_dashboard.php");
                exit;
            }
        }
        $stmt->close();

        // --- User login ---
        $stmt = $conn->prepare("SELECT password, role FROM members WHERE username = ? AND email_verified=1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($db_password, $role);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['admin_logged_in'] = false;
                header('Location: welcome.php');
                exit;
            } else {
                trigger_error("Login failed for user '{$username}': invalid password", E_USER_WARNING);
                header('Location: login.php?error=invalid_credentials');
                exit;
            }
        } else {
            trigger_error("Login failed: username '{$username}' not found", E_USER_WARNING);
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