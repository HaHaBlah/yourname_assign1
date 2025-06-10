<?php
// reset_password.php
// ----------------------------------------------------------------

include "inc/database_connection.inc";
session_start();

// 1) Fetch and validate email + token from query
$email = $_GET['email']   ?? '';
$token = $_GET['token']   ?? '';
$error = '';
$info  = '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($token) !== 100) {
    $error = "Invalid password reset link.";
}

// 2) If POST, handle the new password submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'], $_POST['confirm_password'])) {
    $new  = $_POST['new_password'];
    $conf = $_POST['confirm_password'];

    if ($new === '' || $conf === '') {
        $error = "Please fill in both password fields.";
    } elseif ($new !== $conf) {
        $error = "Passwords do not match.";
    } else {
        // re-validate token is still valid
        $stmt = $conn->prepare("
            SELECT expires_at
              FROM password_resets
             WHERE email = ?
               AND token = ?
             LIMIT 1
        ");
        $stmt->bind_param('ss', $email, $token);
        $stmt->execute();
        $stmt->bind_result($expires_at);
        if (! $stmt->fetch() || strtotime($expires_at) < time()) {
            $error = "This reset link has expired or is invalid.";
        }
        $stmt->close();

        if (!$error) {
            // hash and update the user's password
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $up2  = $conn->prepare("UPDATE members SET password = ? WHERE email = ?");
            $up2->bind_param('ss', $hash, $email);
            $up2->execute();
            $up2->close();

            // delete the reset token so it can't be reused
            $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->bind_param('s', $email);
            $del->execute();
            $del->close();

            // redirect to login with a success flag
            header("Location: login.php?reset=success");
            exit;
        }
    }
}

// 3) If no POST or there was an error, check link validity before showing form
if (empty($_POST) && empty($error)) {
    $stmt = $conn->prepare("
        SELECT expires_at
          FROM password_resets
         WHERE email = ?
           AND token = ?
         LIMIT 1
    ");
    $stmt->bind_param('ss', $email, $token);
    $stmt->execute();
    $stmt->bind_result($expires_at);
    if (! $stmt->fetch() || strtotime($expires_at) < time()) {
        $error = "This reset link has expired or is invalid.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Your Password – Brew &amp; Go</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <?php include "inc/top_navigation_bar.inc"; ?>

  <main class="no-margin-top">
    <section class="login-container">
      <h2>Reset Password</h2>

      <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <p><a href="login.php">← Back to Login</a></p>

      <?php else: ?>
        <form method="post" action="">
          <fieldset>
            <input
              type="password"
              name="new_password"
              placeholder="New password"
              required
              minlength="8"
            >
            <input
              type="password"
              name="confirm_password"
              placeholder="Confirm new password"
              required
              minlength="8"
            >
            <button type="submit">Set New Password</button>
          </fieldset>
        </form>

        <p><a href="login.php">← Cancel and return to Login</a></p>
      <?php endif; ?>

    </section>
  </main>

  <?php include "inc/footer.inc"; ?>
</body>
</html>
