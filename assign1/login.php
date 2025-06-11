<?php
// ----------------------------------------------------------------
// login.php
// ----------------------------------------------------------------

session_start();
if (!empty($_SESSION['logged_in'])) {
  // If admin, go to admin panel; otherwise go to member welcome
  $dest = ($_SESSION['role'] === 'admin')
        ? 'admin_dashboard.php'
        : 'user_dashboard.php';
  header("Location: $dest");
  exit;
}

include "inc/database_connection.inc";
// include("inc/login_status.inc");
// session_start();

// 1) Ensure password_resets table exists
$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email`      VARCHAR(255) NOT NULL,
  `token`      CHAR(100)    NOT NULL,
  `expires_at` DATETIME     NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
if (! $conn->query($sql)) {
  die("Failed to create password_resets table: " . $conn->error);
}

// 2) Handle “Forgot password” form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_email'])) {
  $email = trim($_POST['forgot_email']);

  // a) Check user exists
  $stmt = $conn->prepare("SELECT id FROM members WHERE email = ?");
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    // b) Generate token + expiry
    $token   = bin2hex(random_bytes(50));
    $expires = date('Y-m-d H:i:s', time() + 3600);

    // c) Upsert into password_resets
    $up = $conn->prepare("
          INSERT INTO password_resets (email, token, expires_at)
          VALUES (?, ?, ?)
          ON DUPLICATE KEY UPDATE
            token       = VALUES(token),
            expires_at  = VALUES(expires_at)
        ");
    $up->bind_param('sss', $email, $token, $expires);
    $up->execute();

    // d) Send the reset email
    $link = "https://{$_SERVER['HTTP_HOST']}"
      . dirname($_SERVER['REQUEST_URI'])
      . "/reset_password.php?email=" . urlencode($email)
      . "&token={$token}";
    $subject = "Reset your Brew & Go password";

    // Fetch user's first name for personalization
    $name_stmt = $conn->prepare("SELECT firstname FROM members WHERE email = ?");
    $name_stmt->bind_param('s', $email);
    $name_stmt->execute();
    $name_stmt->bind_result($firstname);
    $name_stmt->fetch();
    $name_stmt->close();

    // Use the new HTML template
    require_once "email_templates.php"; // or email_templates.php if you put it there
    $body = get_password_reset_email($firstname ?: 'Member', $link);

    @mail(
      $email,
      $subject,
      $body,
      "From: no-reply@yourdomain.com\r\n"
        . "Content-Type: text/html; charset=UTF-8\r\n"
    );

    $info = "A reset link has been sent to your email.";
  } else {
    $error = "No account with that email.";
  }
}

// 3) Decide which view to show
$action = $_GET['action'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login – Brew &amp; Go Coffee</title>
  <link rel="stylesheet" href="styles/style.css">
</head>

<body>
  <?php include "inc/top_navigation_bar.inc"; ?>

  <main>

    <?php if ($action === 'forgot'): ?>
      <!-- ========================= -->
      <!-- FORGOT PASSWORD FORM -->
      <!-- ========================= -->
      <section class="login-container">
        <h2>Forgot Password</h2>

        <?php if (!empty($info)): ?>
          <div class="info-msg"><?= htmlspecialchars($info) ?></div>
        <?php elseif (!empty($error)): ?>
          <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php?action=forgot">
          <fieldset>
            <input
              type="email"
              name="forgot_email"
              placeholder="Enter your email"
              required>
            <button type="submit">Send reset link</button>
          </fieldset>
        </form>

        <p><a href="login.php">← Back to Login</a></p>
      </section>

    <?php else: ?>
      <!-- ========================= -->
      <!-- NORMAL LOGIN FORM -->
      <!-- ========================= -->
      <section class="login-container">
        <div class="login-panel">
          <div class="login-left">
            <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
            <h2>Login</h2>
          </div>

          <div class="login-right">
            <?php
            // Show errors from login_process.php via GET
            if (isset($_GET['error'])) {
              if ($_GET['error'] === 'invalid_credentials') {
                $errorText = 'Invalid username or password.';
              } elseif ($_GET['error'] === 'empty_fields') {
                $errorText = 'Please fill in all fields.';
              }
            }
            ?>
            <form action="login_process.php" method="post">
              <fieldset>
                <input
                  type="text"
                  name="username"
                  placeholder="Username"
                  required>
                <input
                  type="password"
                  name="password"
                  placeholder="Password"
                  required>
                <button type="submit">Login</button>

                <p class="forgot-link">
                  <a href="login.php?action=forgot">Forgot your password?</a>
                </p>
              </fieldset>
            </form>

            <!-- bottom-centered info/error -->
            <?php if (!empty($errorText)): ?>
              <div class="error-msg"><?= htmlspecialchars($errorText) ?></div>
            <?php endif; ?>

            <div class="login-bottom">
              <a href="registration.php">Don't have an account?</a>
            </div>
          </div> <!-- /.login-right -->
        </div> <!-- /.login-panel -->
      </section>
    <?php endif; ?>

  </main>

  <?php include "inc/footer.inc"; ?>
</body>

</html>