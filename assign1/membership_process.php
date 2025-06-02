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
        <h1>Membership Registration Confirmation</h1>
        <h2>Thank you for registering!</h2>

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "membership";

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
            die("Table creation failed: " . $conn->error);
        }
        // Get POST data safely
        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Simple validation

        // if ($firstname && $lastname && $email && $username && $password) {
        //     // Hash the password
        //     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //     // Use prepared statement to prevent SQL injection
        //     $stmt = $conn->prepare("INSERT INTO members (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)");
        //     $stmt->bind_param("sssss", $firstname, $lastname, $email, $username, $hashed_password);

        //     if ($stmt->execute()) {
        //         echo "<p>Registration successful! Welcome, <strong>" . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname) . "</strong>.</p>";
        //     } else {
        //         echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
        //     }

        //     $stmt->close();
        // } else {
        //     echo "<p>Error: Please fill in all required fields.</p>";
        // }

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

        if ($username && preg_match('/^[a-zA-Z0-9]{1,10}$/', $username)) {
            $valid['username'] = "Username is valid.";
        } else {
            $errors['username'] = "Username must be alphanumeric and up to 10 characters long."; //I need to check with this
        }

        if ($password && strlen($password) >= 6) {
            $valid['password'] = "Password is valid.";
        } else {
            $errors['password'] = "Password must be at least 6 characters long."; //I need to check with this
        }

        mysqli_close($conn);
        ?>
    <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>
    <?php include("inc/footer.inc"); ?>
</body>

</html>