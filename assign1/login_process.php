<?php
$antiSpamPath = __DIR__ . '/anti_spam_check.php';
if (! file_exists($antiSpamPath)) {
    die("DEBUG ERROR: Cannot find anti_spam_check.php at path: " . htmlspecialchars($antiSpamPath));
}
require_once __DIR__ . '/anti_spam_check.php';
?>

<?php
include("inc/login_status.inc");
require_once("inc/database_connection.inc");    // DB connection file
require_once("error_handler.php");              // Error handler file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded admin
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username']       = 'admin';
        $_SESSION['role']           = 'admin';      // <-- add this
        file_put_contents("testlog.txt", "Logged in as hardcoded admin\n", FILE_APPEND);
        header("Location: admin_dashboard.php");
        exit;
    }

    if (!empty($username) && !empty($password)) {
        // Prepare and execute query
        $stmt = $conn->prepare("SELECT password, role FROM members WHERE username = ? AND email_verified=1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($db_password, $role);
            $stmt->fetch();

            // For now, assume passwords stored in plain text
            if (password_verify($password, $db_password)) {
                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['admin_logged_in'] = false; // Not an admin login
                $_SESSION['username']       = 'user'; // Default user role
                $_SESSION['role']           = 'user'; 

                header('Location: welcome.php');
                exit;
                
            } else {
                // Password mismatch
                trigger_error("Login failed for user '{$username}': invalid password", E_USER_WARNING);
                header('Location: login.php?error=invalid_credentials');
                exit;
            }
        } else {
            // Username not found
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
