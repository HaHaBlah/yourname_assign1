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
        <section class="login-container" id="member-topup-container">
            <div class="login-left">
                <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
                <h2>Member Top-Up</h2>
                <p>Top-up a member's Brew & Go Coffee account</p>
            </div>
            <div class="login-right">
                <form method="post" action="member_topup.php">
                    <fieldset>
                        <input class="responsive-hover" type="text" name="login_id" id="login_id" placeholder="Username" required pattern="[A-Za-z]+" maxlength="10" title="Alphabetical characters only; Maximum 10 characters.">
                        <input class="responsive-hover" type="email" name="email" id="email" placeholder="Email" required>
                        <input class="responsive-hover" type="number" name="amount" id="amount" placeholder="Top-Up Amount (RM)" required min="1" max="1000" step="1">
                        <select class="responsive-hover" name="method" id="method" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="touch_n_go">Touch 'n Go</option>
                            <option value="grab_pay">Grab Pay</option>
                            <option value="srwk_pay">Sarawak Pay</option>
                        </select>
                        <button class="responsive-hover-button" type="submit">Submit Top-Up</button>
                    </fieldset>
                </form>
                <?php if ($message): ?>
                    <div class="login-bottom">
                        <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include("inc/scroll_to_top_button.inc"); ?>
    <?php include("inc/footer.inc"); ?>
</body>
</html>