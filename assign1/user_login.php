<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        header('Location: welcome.php'); //Might change this link
        exit;
    } else {
        header('Location: login.php?error=invalid_credentials');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>