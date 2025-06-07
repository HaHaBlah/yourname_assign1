<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test"; // Use your actual DB name here

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
