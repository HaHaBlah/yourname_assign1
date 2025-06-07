<?php
// Prevent direct access to this file
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    exit('No direct access allowed.');
}

// Database connection settings
$host = 'localhost';
$user = 'root';
$password = '';      // Empty for local XAMPP setup
$database = 'brew&go_db';

// Create connection
$conn = new mysqli($host, $user, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS `$database`";
if (!$conn->query($sql)) {
    die("Database creation failed: " . $conn->error);
}

// Select the default database
$conn->select_db($database);

// Create membership database and members table
$membership_db = 'membership';
$sql = "CREATE DATABASE IF NOT EXISTS `$membership_db`";
if (!$conn->query($sql)) {
    die("Membership database creation failed: " . $conn->error);
}
$conn->select_db($membership_db);

$sql = "CREATE TABLE IF NOT EXISTS members (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(50) NOT NULL,
    username VARCHAR(10) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($sql)) {
    die("Members table creation failed: " . $conn->error);
}

// Switch back to the default database
$conn->select_db($database);
?>
