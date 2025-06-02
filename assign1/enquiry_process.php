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
    <?php include("inc/top_navigation_bar.inc"); ?>
    <main>
        <h1>Enquiry Confirmation</h1>
        <h2>Thank you for contacting us!</h2>

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "enquiry";

        // Create connection
        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create database if it doesn't exist
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if (!$conn->query($sql)) {
            die("Database creation failed: " . $conn->error);
        }

        // Select the database
        $conn->select_db($dbname);

        // Create members table if it doesn't exist
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
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        if (!$conn->query($sql)) {
            die("Table creation failed: " . $conn->error);
        }

        // Get POST data safely
        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phonenumber = isset($_POST['phonenumber']) ? trim($_POST['phonenumber']) : '';
        $streetaddress = isset($_POST['streetaddress']) ? trim($_POST['streetaddress']) : '';
        $citytown = isset($_POST['citytown']) ? trim($_POST['citytown']) : '';
        $state = isset($_POST['state']) ? trim($_POST['state']) : '';
        $postcode = isset($_POST['postcode']) ? trim($_POST['postcode']) : '';
        $enquirytype = isset($_POST['enquirytype']) ? trim($_POST['enquirytype']) : '';
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';

        // Simple validation

        // if ($firstname && $lastname && $email && $phonenumber && $streetaddress && $citytown && $state && $postcode && $enquirytype && $message) {
        //     // Use prepared statement to prevent SQL injection
        //     $stmt = $conn->prepare("INSERT INTO enquiries (firstname, lastname, email, phonenumber, streetaddress, citytown, state, postcode, enquirytype, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        //     $stmt->bind_param("ssssssssss", $firstname, $lastname, $email, $phonenumber, $streetaddress, $citytown, $state, $postcode, $enquirytype, $message);

        //     if ($stmt->execute()) {
        //         echo "<p>Your enquiry has been submitted successfully. We will get back to you soon, <strong>" . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname) . "</strong>.</p>";
        //     } else {
        //         echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
        //     }

        //     $stmt->close();
        // } else {
        //     echo "<p>Error: Please fill in all required fields.</p>";
        // }

        $errors = [];
        $valid = [];

        // Validate each field
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

        if ($phonenumber) {
            $valid['phonenumber'] = "Phone number is provided.";
        } else {
            $errors['phonenumber'] = "Phone number is required.";
        }

        if ($streetaddress) {
            $valid['streetaddress'] = "Street address looks good.";
        } else {
            $errors['streetaddress'] = "Street address is required.";
        }

        if ($citytown) {
            $valid['citytown'] = "City/Town is provided.";
        } else {
            $errors['citytown'] = "City/Town is required.";
        }

        if ($state) {
            $valid['state'] = "State is provided.";
        } else {
            $errors['state'] = "State is required.";
        }

        if ($postcode) {
            $valid['postcode'] = "Postcode is provided.";
        } else {
            $errors['postcode'] = "Postcode is required.";
        }

        if ($enquirytype) {
            $valid['enquirytype'] = "Enquiry type is provided.";
        } else {
            $errors['enquirytype'] = "Enquiry type is required.";
        }

        if ($message) {
            $valid['message'] = "Message is provided.";
        } else {
            $errors['message'] = "Message is required.";
        }

        // Close the database connection
        $conn->close();
        ?>
    <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>
    <?php include("inc/footer.inc"); ?>
</body>

</html>