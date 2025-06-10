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
    phonenumber VARCHAR(15),
    streetaddress VARCHAR(40),
    citytown VARCHAR(20),
    state VARCHAR(30),
    postcode VARCHAR(5),
    cvfile VARCHAR(255),
    photofile VARCHAR(255),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(64),
    verification_expires DATETIME,
    role VARCHAR(20) NOT NULL DEFAULT 'member'
)";

if (!$conn->query($sql)) {
    die("Members table creation failed: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS jobapp (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phonenumber VARCHAR(15),
    streetaddress VARCHAR(40),
    citytown VARCHAR(20),
    state VARCHAR(30),
    postcode VARCHAR(5),
    cvfile VARCHAR(255),
    photofile VARCHAR(255),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($sql)) {
    die("Jobapp table creation failed: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS enquiries (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phonenumber VARCHAR(15) NOT NULL,
    streetaddress VARCHAR(40) NOT NULL,
    citytown VARCHAR(20) NOT NULL,
    state VARCHAR(30) NOT NULL,
    postcode VARCHAR(5) NOT NULL,
    enquirytype VARCHAR(30) NOT NULL,
    message TEXT NOT NULL,
    reply_message   TEXT        NULL,
    reply_sent_at   DATETIME    NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
";

if (!$conn->query($sql)) {
    die("Enquiries table creation failed: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS topup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login_id VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255),
    balance DECIMAL(10,2) DEFAULT 0.00
)";

if (!$conn->query($sql)) {
    die("Topup table creation failed: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
    )";

if (!$conn->query($sql)) {
    die("Admin table creation failed: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS `password_resets` (
    `email`      VARCHAR(255) NOT NULL,
    `token`      CHAR(100)    NOT NULL,
    `expires_at` DATETIME     NOT NULL,
    PRIMARY KEY (`email`)
    )"; 

if (!$conn->query($sql)) {
    die("Password resets table creation failed: " . $conn->error);
}


// Insert default admin if not exists
$default_admin_username = 'admin';
$default_admin_password = password_hash('admin', PASSWORD_DEFAULT);

// Check if admin exists
$stmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
$stmt->bind_param("s", $default_admin_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    // Insert default admin
    $insert = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $insert->bind_param("ss", $default_admin_username, $default_admin_password);
    $insert->execute();
    $insert->close();
}
$stmt->close();

// Switch back to the default database
$conn->select_db($database);
?>

<?php //replaces php.ini file in XAMPP
// Source and destination paths
$source = __DIR__ . '/php.ini';  
$destination = 'C:/xampp/php/php.ini';

// Copy and overwrite
if (!copy($source, $destination)) {
    die("Failed to replace php.ini");
} 

$source = __DIR__ . '/sendmail.ini';  
$destination = 'C:/xampp/sendmail/sendmail.ini';

// Copy and overwrite
if (!copy($source, $destination)) {
    die("Failed to replace sendmail.ini");
} 
?>