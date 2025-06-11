<?php
// Prevent direct access to this file
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$antiSpamPath = __DIR__ . '/anti_spam_check.php';
if (! file_exists($antiSpamPath)) {
    die("DEBUG ERROR: Cannot find anti_spam_check.php at path: " . htmlspecialchars($antiSpamPath));
}
require_once __DIR__ . '/anti_spam_check.php';
?>

<?php session_start(); ?>
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
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "brew&go_db";

        // Create connection -> For SQL
        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create database if it doesn't exist
        $sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
        if (!$conn->query($sql)) {
            die("Database creation failed: " . $conn->error);
        }
        $conn->select_db($dbname);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $update_message      = trim($_POST['update_message'] ?? '');

            $_SESSION['form_data'] = [
                'update_message' => $update_message,
            ];

            $photofile = '';
            $uploadOk = true;
            $uploadDir = "uploads/updates/";

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }


            if (isset($_FILES['FilePhoto']) && $_FILES['FilePhoto']['error'] == 0) {
                $photoTarget = $uploadDir . basename($_FILES['FilePhoto']['name']);
                if (move_uploaded_file($_FILES['FilePhoto']['tmp_name'], $photoTarget)) {
                    $photofile = $photoTarget;
                } else {
                    $uploadOk = false;
                }
            } else {
                $uploadOk = true;
                $photofile = '';
            }

            $errors = [];

            if (!$update_message) $errors['update_message'] = "update_message is required.";
            if (isset($_FILES['FilePhoto']) && $_FILES['FilePhoto']['error'] == 1) {
                $errors['photofile'] = "Photo file upload failed or too large.";
            }

            if (!empty($errors)) {
                echo '<div class="notification error">';
                echo '<h3>Please correct the following issues:</h3><ul>';
                foreach ($errors as $field => $message) {
                    echo "<li><strong>$field:</strong> $message</li>";
                }
                echo '</ul><p><a href="index.php">Return to form</a></p></div>';
            } elseif ($uploadOk) {
                $stmt = $conn->prepare("INSERT INTO updates (update_message, photofile) VALUES (?, ?)");
                $stmt->bind_param("ss", $update_message, $photofile);

                if ($stmt->execute()) {
                    echo '<div class="notification success">';
                    echo '<p>News Updated.</p>';
                    echo '</div>';
                    unset($_SESSION['form_data']);
                } else {
                    echo '<div class="notification error">';
                    echo "<p>Error saving data: " . htmlspecialchars($stmt->error) . "</p></div>";
                }

                $stmt->close();
            }
        } else {
            echo '<p>Invalid request method.</p>';
        }


        ?>
        <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>
    <?php include("inc/footer.inc"); ?>
    $conn->close();
</body>

</html>