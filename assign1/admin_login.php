<?php
session_start();
require_once("inc/database_connection.inc");

// Check if the admin is already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
    exit;
}

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hard-coded admin credentials
    $adminUser = 'admin';
    $adminPass = 'admin';
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check the credentials
    if ($username === $adminUser && $password === $adminPass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Redirect with error
        header("Location: admin_login.php?error=invalid");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>

    <?php
    // Show error if present in URL
    if (isset($_GET['error']) && $_GET['error'] === 'invalid') {
        echo '<p style="color: red;">Invalid username or password.</p>';
    }
    ?>


</body>
</html>
