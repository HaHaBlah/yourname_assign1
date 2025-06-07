<?php
file_put_contents("testlog.txt", "admin_login.php was hit!\n", FILE_APPEND); // Debug

//Temporary debug log
session_unset();
session_destroy();

session_start();
require_once("inc/database_connection.inc");

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
    exit;
} elseif (isset($_SESSION['user_logged_in'])) {
    header("Location: user_dashboard.php");
    exit;
}

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents("testlog.txt", "POST block reached\n", FILE_APPEND); // DEBUG

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hardcoded admin
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = 'admin';
        file_put_contents("testlog.txt", "Logged in as hardcoded admin\n", FILE_APPEND);
        header("Location: admin_dashboard.php");
        exit;
    }

    // Check members database
    $conn->select_db('membership');
    $stmt = $conn->prepare("SELECT * FROM members WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'] ?? 'user';

            file_put_contents("testlog.txt", "Login success for: $username\n", FILE_APPEND);
            header("Location: user_dashboard.php");
            exit;
        } else {
            file_put_contents("testlog.txt", "Password mismatch for: $username\n", FILE_APPEND);
        }
    } else {
        file_put_contents("testlog.txt", "No user found with username: $username\n", FILE_APPEND);
    }

    // Login failed
    file_put_contents("testlog.txt", "Login failed for: $username\n", FILE_APPEND);
    header("Location: login.php?error=invalid_credentials");
    exit;
}
?>