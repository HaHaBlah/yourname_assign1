<?php
session_start();
require_once("inc/database_connection.inc");

// Handle form submission
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = trim($_POST['login_id']);
    $email = trim($_POST['email']);
    $amount = floatval($_POST['amount']);

    // Check if member exists
    $stmt = $conn->prepare("SELECT balance FROM members WHERE login_id = ? AND email = ?");
    $stmt->bind_param("ss", $login_id, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($balance);
        $stmt->fetch();

        $new_balance = $balance + $amount;

        // Update balance
        $update = $conn->prepare("UPDATE members SET balance = ? WHERE login_id = ? AND email = ?");
        $update->bind_param("dss", $new_balance, $login_id, $email);

        if ($update->execute()) {
            $message = "✅ Top-up successful! New Balance: RM " . number_format($new_balance, 2);
        } else {
            $message = "❌ Failed to update balance. Error: " . $conn->error;
        }

        $update->close();
    } else {
        $message = "❌ Member not found. Please check your Login ID and Email.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Top-Up</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <h1>Member Top-Up</h1>
        <nav>
            <a href="index.php">Home</a> |
            <a href="registration.php">Register</a> |
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>
        <form method="post" action="member_topup.php">
            <fieldset>
                <legend>Top-Up Form</legend>

                <label for="login_id">Login ID:</label>
                <input type="text" name="login_id" id="login_id" required maxlength="10" pattern="[A-Za-z]+" title="Alphabets only"><br><br>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required><br><br>

                <label for="amount">Top-Up Amount (RM):</label>
                <input type="number" name="amount" id="amount" required min="1" max="1000" step="0.01"><br><br>

                <button type="submit">Submit Top-Up</button>
            </fieldset>
        </form>

        <?php if ($message): ?>
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Brew & Go Coffee</p>
    </footer>
</body>
</html>
