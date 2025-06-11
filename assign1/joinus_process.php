<?php
// Prevent direct access to this file
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: joinus_form.php");
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
            $firstname      = trim($_POST['firstname'] ?? '');
            $lastname       = trim($_POST['lastname'] ?? '');
            $email          = trim($_POST['email'] ?? '');
            $phonenumber    = trim($_POST['phonenumber'] ?? '');
            $streetaddress  = trim($_POST['streetaddress'] ?? '');
            $citytown       = trim($_POST['citytown'] ?? '');
            $state          = trim($_POST['state'] ?? '');
            $postcode       = trim($_POST['postcode'] ?? '');

            $_SESSION['form_data'] = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'phonenumber' => $phonenumber,
                'streetaddress' => $streetaddress,
                'citytown' => $citytown,
                'state' => $state,
                'postcode' => $postcode,
            ];

            $cvfile = '';
            $photofile = '';
            $uploadOk = true;
            $uploadDir = "uploads/";

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (isset($_FILES['CVFile']) && $_FILES['CVFile']['error'] == 0) {
                $cvTarget = $uploadDir . basename($_FILES['CVFile']['name']);
                if (move_uploaded_file($_FILES['CVFile']['tmp_name'], $cvTarget)) {
                    $cvfile = $cvTarget;
                } else {
                    $uploadOk = false;
                }
            } else {
                $uploadOk = false;
            }

            // if (isset($_FILES['FilePhoto']) && $_FILES['FilePhoto']['error'] == 0) {
            //     if ($_FILES['FilePhoto']['size'] <= 200 * 1024) {
            //         $photoTarget = $uploadDir . basename($_FILES['FilePhoto']['name']);
            //         if (move_uploaded_file($_FILES['FilePhoto']['tmp_name'], $photoTarget)) {
            //             $photofile = $photoTarget;
            //         } else {
            //             $uploadOk = false;
            //         }
            //     } else {
            //         $uploadOk = false;
            //     }
            // } else {
            //     $uploadOk = false;
            // }

            if (isset($_FILES['PhotoFile']) && $_FILES['PhotoFile']['error'] === UPLOAD_ERR_OK) {
                // 1) check PHP’s own limits
                if ($_FILES['PhotoFile']['size'] > 200 * 1024) {
                    $errors['photofile'] = 'Photo exceeds 200 KB limit.';
                    $uploadOk = false;
                } else {
                    $photoName   = basename($_FILES['PhotoFile']['name']);
                    $photoTarget = $uploadDir . DIRECTORY_SEPARATOR . $photoName;

                    // 2) ensure the folder is ready
                    if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
                        $errors['photofile'] = 'Server error: upload folder not writable.';
                        $uploadOk = false;
                    }
                    // 3) attempt the move
                    elseif (move_uploaded_file($_FILES['PhotoFile']['tmp_name'], $photoTarget)) {
                        $photofile = $photoTarget;
                    } else {
                        $errors['photofile'] = 'Failed to move uploaded file.';
                        $uploadOk = false;
                    }
                }
            } else {
                $code = $_FILES['PhotoFile']['error'] ?? 'no key';
                $errors['photofile'] = "Upload error (code {$code}).";
                $uploadOk = false;
            }

            $errors = [];

            if (!$firstname) $errors['firstname'] = "First name is required.";
            if (!$lastname) $errors['lastname'] = "Last name is required.";
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "A valid email is required.";
            if (!$phonenumber) $errors['phonenumber'] = "Phone number is required.";
            if (!$streetaddress) $errors['streetaddress'] = "Street address is required.";
            if (!$citytown) $errors['citytown'] = "City/Town is required.";
            if (!$state) $errors['state'] = "State is required.";
            if (!$postcode || !preg_match('/^\d{4,5}$/', $postcode)) $errors['postcode'] = "Valid postcode is required.";
            if (!$cvfile) $errors['cvfile'] = "CV file upload failed.";
            if (!$photofile) $errors['photofile'] = "Photo file upload failed or too large.";

            if (!empty($errors)) {
                echo '<div class="notification error">';
                echo '<h3>Please correct the following issues:</h3><ul>';
                foreach ($errors as $field => $message) {
                    echo "<li><strong>$field:</strong> $message</li>";
                }
                echo '</ul><p><a href="joinus_form.php">Return to form</a></p></div>';
            } elseif ($uploadOk) {
                $stmt = $conn->prepare("INSERT INTO jobapp (firstname, lastname, email, phonenumber, streetaddress, citytown, state, postcode, cvfile, photofile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssss", $firstname, $lastname, $email, $phonenumber, $streetaddress, $citytown, $state, $postcode, $cvfile, $photofile);

                if ($stmt->execute()) {
                    echo '<div class="notification success">';
                    echo '<h1>Thanks for joining us!</h1>';
                    echo '<p>We appreciate your interest in becoming a member of Brew & Go Coffee. Your application will soon be reviewed by our team.</p>';
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
    <?php $conn->close(); ?>
</body>

</html>