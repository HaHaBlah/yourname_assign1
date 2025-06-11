<?php
include("inc/database_connection.inc");
include("inc/login_status.inc");

// --- 1) Connect & select database ---
$servername = "localhost";
$dbUser     = "root";
$dbPass     = "";
$dbName     = "brew&go_db";

$conn = new mysqli($servername, $dbUser, $dbPass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (! $conn->query("CREATE DATABASE IF NOT EXISTS `$dbName`")) {
    die("DB creation error: " . $conn->error);
}
$conn->select_db($dbName);

// --- 2) Create 'topup' table if it doesn't exist ---
$createTableSql = <<<SQL
CREATE TABLE IF NOT EXISTS topup (
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    login_id           VARCHAR(50)  NOT NULL UNIQUE,
    email              VARCHAR(100) NOT NULL,
    balance            DECIMAL(10,2) NOT NULL DEFAULT 0,
    last_topup_method  VARCHAR(50),
    last_topup_amount  DECIMAL(10,2),
    last_topup_time    DATETIME,
    INDEX(login_id),
    INDEX(email)
)
SQL;
if (! $conn->query($createTableSql)) {
    die("Error creating topup table: " . $conn->error);
}

// --- 3) Bulk-sync all members → topup every refresh ---
$syncSql = <<<SQL
INSERT INTO topup (login_id, email, balance)
SELECT username, email, 0
  FROM members
ON DUPLICATE KEY UPDATE
  email   = VALUES(email)
SQL;
if (! $conn->query($syncSql)) {
    die("Error syncing members: " . $conn->error);
}

// --- 4) Handle form submission ---
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login_id = trim($_POST['login_id']);
    $email    = trim($_POST['email']);
    $amount   = floatval($_POST['amount']);
    $method   = $_POST['method'];

    // fetch current balance
    $stmt = $conn->prepare(
      "SELECT balance
         FROM topup
        WHERE login_id = ? AND email = ?"
    );
    $stmt->bind_param("ss", $login_id, $email);
    $stmt->execute();
    $stmt->bind_result($currentBalance);

    if ($stmt->fetch()) {
        $stmt->close();
        $newBalance = $currentBalance + $amount;

        // update with new balance & method/amount/timestamp
        $update = $conn->prepare(
          "UPDATE topup
              SET balance           = ?,
                  last_topup_method = ?,
                  last_topup_amount = ?,
                  last_topup_time   = NOW()
            WHERE login_id = ? AND email = ?"
        );
        // types: d = double (decimal), s = string
        $update->bind_param("dsdss",
            $newBalance,
            $method,
            $amount,
            $login_id,
            $email
        );
        if ($update->execute()) {
            $message = "✅ Top-Up successful! New balance: RM "
                     . number_format($newBalance, 2);
        } else {
            $message = "❌ Update failed: " . htmlspecialchars($conn->error);
        }
        $update->close();
    } else {
        $message = "❌ Member not found in topup table.";
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Member Top-Up</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <?php include("inc/top_navigation_bar.inc"); ?>

  <main>
    <section class="login-container" id="member-topup-container">
      <div class="login-left">
        <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
        <h2>Member Top-Up</h2>
        <p>Your account details are automatically synced to ensure your top-up balance is current</p>
      </div>
      <div class="login-right">
        <form method="post" action="member_topup.php">
          <fieldset>
            <input type="text"
                   name="login_id"
                   placeholder="Username"
                   required
                   pattern="[A-Za-z]+"
                   maxlength="10"
                   title="Letters only, max 10">
            <input type="email"
                   name="email"
                   placeholder="Email"
                   required>
            <input type="number"
                   name="amount"
                   placeholder="Top-Up Amount (RM)"
                   required
                   min="1"
                   max="1000"
                   step="1">
            <select name="method" required>
              <option value="">-- Payment Method --</option>
              <option value="credit_card">Credit Card</option>
              <option value="touch_n_go">Touch ’n Go</option>
              <option value="grab_pay">Grab Pay</option>
              <option value="srwk_pay">Sarawak Pay</option>
            </select>
            <button type="submit">Submit Top-Up</button>
          </fieldset>
        </form>

        <?php if ($message): ?>
          <div class="login-bottom">
            <p style="font-weight:bold;"><?= htmlspecialchars($message) ?></p>
          </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <?php include("inc/scroll_to_top_button.inc"); ?>
  <?php include("inc/footer.inc"); ?>
</body>
</html>
