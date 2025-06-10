<?php
$antiSpamPath = __DIR__ . '/anti_spam_check.php';
if (! file_exists($antiSpamPath)) {
    die("DEBUG ERROR: Cannot find anti_spam_check.php at path: " . htmlspecialchars($antiSpamPath));
}
require_once __DIR__ . '/anti_spam_check.php';
?>

<?php session_start();
require_once("verification_email.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Members</title>
    <meta name="description" content="Career opportunities at Brew & Go Coffee">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <?php
    // Redirect anyone who tries to open this page directly
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: registration.php');
        exit;
    }

    // Database connection
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "brew&go_db";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
    if (!$conn->query($sql)) {
        die("Database creation failed: " . $conn->error);
    }

    // Select the database
    $conn->select_db($dbname);

    // Create members table if it doesn't exist
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
        die("Table creation failed: " . $conn->error);
    }
    // Get POST data safely
    $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
    $lastname  = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
    $email     = isset($_POST['email']) ? trim($_POST['email']) : '';
    $username  = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password  = isset($_POST['password']) ? $_POST['password'] : '';

    // Store entered values (except password) in session to repopulate form later
    $_SESSION['form_data'] = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'username' => $username
    ];

    // Validate inputs
    $errors = [];
    $valid = [];

    if ($firstname) {
        $valid['firstname'] = "First name looks good.";
    } else {
        $errors['firstname'] = "First name is required.";
    }

    if ($lastname) {
        $valid['lastname'] = "Last name looks good.";
    } else {
        $errors['lastname'] = "Last name is required.";
    }

    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $valid['email'] = "Email is valid.";
    } else {
        $errors['email'] = "A valid email is required.";
    }

    if ($username && preg_match('/^[a-zA-Z0-9]{3,10}$/', $username)) {
        $valid['username'] = "Username is valid.";
    } else {
        $errors['username'] = "Username must be alphanumeric and between 3 and 10 characters long."; //I need to check with this
    }

    if ($password && strlen($password) >= 6) {
        $valid['password'] = "Password is valid.";
    } else {
        $errors['password'] = "Password must be at least 6 characters long."; //I need to check with this
    }
    ?>

    <?php include("inc/top_navigation_bar.inc"); ?>


    <?php
    if (count($errors) === 0) {
        // ✅ Hash the password before saving
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        trigger_error("Plain text password: '" . $password . "'", E_USER_NOTICE);
        trigger_error("Hashed password: '" . $hashed_password . "'", E_USER_NOTICE);

        // Generate verification token and expiry
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 300); // 5 minutes from now

        // ✅ Prepare the INSERT query
        $stmt = $conn->prepare(
            "INSERT INTO members (firstname, lastname, email, username, password, verification_token, verification_expires)
                VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        // ✅ Bind the variables to the query
        $stmt->bind_param(
            "sssssss",
            $firstname,
            $lastname,
            $email,
            $username,
            $hashed_password,
            $token,
            $expires
        );

        // ✅ Execute the query and check if it worked
        if ($stmt->execute()) {
            // Send verification email
            $verify_link = "http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/verify_email.php?token=$token";
            $subject = "Verify your Brew & Go Coffee Membership";
            $message = get_verification_email($firstname, $verify_link);
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: brewngo.coffee@gmail.com" . "\r\n";

            mail($email, $subject, $message, $headers);

            echo "<main>";
            echo "<h1>Membership Registration Confirmation</h1>";
            echo "<h2>Thank you for registering!</h2>";
            echo "<p>Please check your email to verify your account. You must verify within 5 minutes.</p>";
            unset($_SESSION['form_data']); // Clear saved inputs
            echo "</main>";
        } else {
            // Insert failed (e.g. duplicate username)
            echo "<main>";
            echo "<h1>Registration Failed</h1>";
            echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
            echo "<p><a href='registration.php'>Return to registration</a></p>";
            echo "</main>";
        }

        $stmt->close(); //end

    } else {
        // Show error messages
        echo "<main>";
        echo "<h1>Registration Failed</h1>";
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
        echo "<p><a href='registration.php'>Return to registration</a></p>";
        echo "</main>";
    }
    ?>

    <?php include("inc/scroll_to_top_button.inc"); ?>
    <?php include("inc/footer.inc"); ?>
    <?php $conn->close(); ?>
</body>

</html>