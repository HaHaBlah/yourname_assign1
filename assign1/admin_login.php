<?php
session_start();

// Check if the admin is already logged in
if(isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$error = '';

// Handle the login form submission
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Hard-coded admin credentials
    $adminUser = 'admin';
    $adminPass = 'admin';
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check the credentials
    if($username === $adminUser && $password === $adminPass){
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <!--< ?php if($error) echo "<p>$error</p>"; ?>-->
    <!-- <form method="post">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit">Login</button>
    </form>
</body>
</html> -->