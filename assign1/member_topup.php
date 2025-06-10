<?php
session_start();

// === Database Connection ===
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brew&go_db";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === Create Database if Not Exists ===
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
$conn->select_db($dbname);

// === Create Table if Not Exists ===
$table_sql = "
CREATE TABLE IF NOT EXISTS topup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login_id VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255),
    balance DECIMAL(10,2) DEFAULT 0.00
)";
if (!$conn->query($table_sql)) {
    die("Table creation failed: " . $conn->error);
}

// === Handle Form Submission ===
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = trim($_POST['login_id']);
    $email    = trim($_POST['email']);
    $amount   = floatval($_POST['amount']);
    $method   = $_POST['method'];

    // Check if member exists
    $stmt = $conn->prepare("SELECT balance FROM topup WHERE login_id = ? AND email = ?");
    $stmt->bind_param("ss", $login_id, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($balance);
        $stmt->fetch();
        $new_balance = $balance + $amount;

        // Update balance
        $update = $conn->prepare("UPDATE topup SET balance = ? WHERE login_id = ? AND email = ?");
        $update->bind_param("dss", $new_balance, $login_id, $email);

        if ($update->execute()) {
            $method_display = ucwords(str_replace('_', ' ', $method));
            $message = "✅ Top-up successful using $method_display. New Balance: RM " . number_format($new_balance, 2);
        } else {
            $message = "❌ Failed to update balance.";
        }

        $update->close();
    } else {
        $message = "❌ Member not found. Please check your Username and Email.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Top-Up</title>
    <meta name="description" content="Top-Up your Brew & Go Coffee account">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>


    <main>
        <header>
            <h1>Member Top-Up</h1>
        </header>
        <form method="post" action="member_topup.php">
            <fieldset>
                <legend>Top-Up Form</legend>

                <label for="login_id">Username:</label>
                <input type="text" name="login_id" id="login_id" required pattern="[A-Za-z]+" maxlength="10"><br><br>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required><br><br>

                <label for="amount">Top-Up Amount (RM):</label>
                <input type="number" name="amount" id="amount" required min="1" max="1000" step="1"><br><br>

                <label for="method">Payment Method:</label>
                <select name="method" id="method" required>
                    <option value="">-- Select --</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="touch_n_go">Touch 'n Go</option>
                    <option value="grab_pay">Grab Pay</option>
                    <option value="srwk_pay">Sarawak Pay</option>
                </select><br><br>

                <button type="submit">Submit Top-Up</button>
            </fieldset>
        </form>

        <?php if ($message): ?>
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>
    <?php include("inc/footer.inc"); ?>
</body>

</html>