<?php
// Prevent direct access to this file
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    exit('No direct access allowed.');
}

// === Database connection settings ===
$host     = 'localhost';
$user     = 'root';
$password = ''; // Default XAMPP password
$database = 'brew&go_db';

// === Connect to MySQL ===
$conn = new mysqli($host, $user, $password);

// === Check connection to MySQL server ===
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === Create database if it does not exist ===
$sql = "CREATE DATABASE IF NOT EXISTS `$database`";
if (!$conn->query($sql)) {
    die("Database creation failed: " . $conn->error);
}

// === Select the database ===
$conn->select_db($database);

// === Set charset ===
$conn->set_charset('utf8mb4');

// === Create members table if not exists ===
$sql = "CREATE TABLE IF NOT EXISTS members (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(50) NOT NULL,
    username VARCHAR(10) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(64),
    verification_expires DATETIME,
    role VARCHAR(20) NOT NULL DEFAULT 'member'
)";
if (!$conn->query($sql)) {
    die("Members table creation failed: " . $conn->error);
}
?>
