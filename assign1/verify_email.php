<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brew&go_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$token = $_GET['token'] ?? '';
if (!$token) {
    echo "<h1>Invalid verification link.</h1>";
    exit;
}

$stmt = $conn->prepare("SELECT id, verification_expires, email_verified FROM members WHERE verification_token=?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $expires, $verified);
    $stmt->fetch();
    if ($verified) {
        echo "<h1>Email already verified.</h1>";
    } elseif (strtotime($expires) >= time()) {
        // Mark as verified
        $update = $conn->prepare("UPDATE members SET email_verified=1, verification_token=NULL, verification_expires=NULL WHERE id=?");
        $update->bind_param("i", $id);
        $update->execute();
        echo "<h1>Email verified successfully!</h1><a href='login.php'>Login here</a>";
    } else {
        echo "<h1>Verification link expired. Please register again.</h1>";
    }
} else {
    echo "<h1>Invalid verification link.</h1>";
}
$stmt->close();
$conn->close();
?>