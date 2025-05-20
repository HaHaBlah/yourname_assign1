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
        $dbname = "JoinUs";

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
            phonenumber VARCHAR(15) NOT NULL,
            streetaddress VARCHAR(40) NOT NULL,
            citytown VARCHAR(20) NOT NULL,
            state VARCHAR(20) NOT NULL,
            postcode VARCHAR(5) NOT NULL,
            cvfile VARCHAR(255) NOT NULL,
            photofile VARCHAR(255) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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

        // Handle file uploads
        $cvfile = '';
        $photofile = '';
        $uploadOk = true;
        $uploadDir = "uploads/";

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // CV upload
        if (isset($_FILES['CVFile']) && $_FILES['CVFile']['error'] == 0) {
            $cvTarget = $uploadDir . basename($_FILES['CVFile']['name']);
            if (move_uploaded_file($_FILES['CVFile']['tmp_name'], $cvTarget)) {
                $cvfile = $cvTarget;
            } else {
                echo "<p>Error uploading CV file.</p>";
                $uploadOk = false;
            }
        } else {
            $uploadOk = false;
        }

        // Photo upload (check size < 200kb)
        if (isset($_FILES['FilePhoto']) && $_FILES['FilePhoto']['error'] == 0) {
            if ($_FILES['FilePhoto']['size'] <= 200 * 1024) {
                $photoTarget = $uploadDir . basename($_FILES['FilePhoto']['name']);
                if (move_uploaded_file($_FILES['FilePhoto']['tmp_name'], $photoTarget)) {
                    $photofile = $photoTarget;
                } else {
                    echo "<p>Error uploading photo file.</p>";
                    $uploadOk = false;
                }
            } else {
                echo "<p>Photo file must be less than 200kb.</p>";
                $uploadOk = false;
            }
        } else {
            $uploadOk = false;
        }

        // Simple validation
        if ($firstname && $lastname && $email && $phonenumber && $streetaddress && $citytown && $state && $postcode && $cvfile && $photofile && $uploadOk) {
            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO members (firstname, lastname, email, phonenumber, streetaddress, citytown, state, postcode, cvfile, photofile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $firstname, $lastname, $email, $phonenumber, $streetaddress, $citytown, $state, $postcode, $cvfile, $photofile);

            if ($stmt->execute()) {
                echo "<p>Registration successful! Welcome, <strong>" . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname) . "</strong>.</p>";
            } else {
                echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Error: Please fill in all required fields and upload valid files.</p>";
        }

        mysqli_close($conn);
        ?>
        <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>
    <?php include("inc/footer.inc"); ?>
</body>

</html>