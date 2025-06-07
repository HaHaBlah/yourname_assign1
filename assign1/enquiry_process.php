<?php
$antiSpamPath = __DIR__ . '/anti_spam_check.php';
if (! file_exists($antiSpamPath)) {
    die("DEBUG ERROR: Cannot find anti_spam_check.php at path: " . htmlspecialchars($antiSpamPath));
}
require_once $antiSpamPath;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Members</title>
    <meta name="description" content="Career opportunities at Brew &amp; Go Coffee">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&amp;Go_l ogo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>
    <main>
        <h1>Enquiry Confirmation</h1>
        <h2>Thank you for contacting us!</h2>

        <?php
        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "brew&go_db";

        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if (!$conn->query($sql)) {
            die("Database creation failed: " . $conn->error);
        }

        $conn->select_db($dbname);

        $sql = "
          CREATE TABLE IF NOT EXISTS enquiries (
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
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
          )
        ";
        if (!$conn->query($sql)) {
            die("Table creation failed: " . $conn->error);
        }

        $firstname     = isset($_POST['firstname'])   ? trim($_POST['firstname'])   : '';
        $lastname      = isset($_POST['lastname'])    ? trim($_POST['lastname'])    : '';
        $email         = isset($_POST['email'])       ? trim($_POST['email'])       : '';
        $phonenumber   = isset($_POST['phonenumber']) ? trim($_POST['phonenumber']) : '';
        $streetaddress = isset($_POST['streetaddress']) ? trim($_POST['streetaddress']) : '';
        $citytown      = isset($_POST['citytown'])    ? trim($_POST['citytown'])    : '';
        $state         = isset($_POST['state'])       ? trim($_POST['state'])       : '';
        $postcode      = isset($_POST['postcode'])    ? trim($_POST['postcode'])    : '';
        $enquirytype   = isset($_POST['enquirytype']) ? trim($_POST['enquirytype']) : '';
        $message       = isset($_POST['message'])     ? trim($_POST['message'])     : '';

        $errors = [];

        if ($firstname === '') {
            $errors[] = "First name is required.";
        }
        if ($lastname === '') {
            $errors[] = "Last name is required.";
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email is required.";
        }
        if ($phonenumber === '') {
            $errors[] = "Phone number is required.";
        }
        if ($streetaddress === '') {
            $errors[] = "Street address is required.";
        }
        if ($citytown === '') {
            $errors[] = "City/Town is required.";
        }
        if ($state === '') {
            $errors[] = "State is required.";
        }
        if ($postcode === '') {
            $errors[] = "Postcode is required.";
        }
        if ($enquirytype === '') {
            $errors[] = "Enquiry type is required.";
        }
        if ($message === '') {
            $errors[] = "Message is required.";
        }

        if (!empty($errors)) {
            echo "<div style='color:red;'>";
            foreach ($errors as $err) {
                echo "<p>" . htmlspecialchars($err) . "</p>";
            }
            echo "</div>";
            $conn->close();
            exit; 
        }
        
        $stmt = $conn->prepare("
          INSERT INTO enquiries
            (firstname, lastname, email, phonenumber, streetaddress,
             citytown, state, postcode, enquirytype, message)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssssssssss",
            $firstname,
            $lastname,
            $email,
            $phonenumber,
            $streetaddress,
            $citytown,
            $state,
            $postcode,
            $enquirytype,
            $message
        );

        if ($stmt->execute()) {
            echo "<p>Your enquiry has been submitted successfully. We will get back to you soon, <strong>"
                 . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname) .
                 "</strong>.</p>";
        } else {
            echo "<p style='color:red;'>Error: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
        $conn->close();
        ?>

    <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>
    <?php include("inc/footer.inc"); ?>
</body>

</html>
