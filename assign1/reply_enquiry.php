<?php
// reply_enquiries.php

// 1) Ensure admin is logged in
include("inc/login_status.inc");
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php?error=not_authorized');
  exit;
}

// 2) Database connection
include("inc/database_connection.inc"); // defines $conn = mysqli_connect(...)
require_once "email_templates.php";

// 3) Show PHP errors while debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 4) Get the enquiry ID
if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
  die("Invalid enquiry ID.");
}
$enq_id = (int)$_GET['id'];

$error   = '';
$success = '';

// 5) Handle the reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $reply_msg = trim($_POST['reply_message'] ?? '');

  if ($reply_msg === '') {
    $error = "Please enter a reply message.";
  } else {
    // 5a) Look up the original enquiry’s email & name
    $stmt = $conn->prepare(
      "SELECT email, firstname
               FROM enquiries
              WHERE id = ?"
    );
    $stmt->bind_param('i', $enq_id);
    $stmt->execute();
    $stmt->bind_result($to_email, $to_name);

    if ($stmt->fetch()) {
      $stmt->close();

      // 5b) Override sendmail to use your Gmail + App Password
      //    Make sure you've created an App Password for taphahablah@gmail.com
      ini_set(
        'sendmail_path',
        '"C:\\xampp\\sendmail\\sendmail.exe" '
          . '-au taphahablah@gmail.com '
          . '-ap jold yfwi jbhv vnra '
          . '-t'
      );

      // 5c) Build and send the mail
      $subject = "Re: Your enquiry at Brew & Go Coffee";
      $body    = get_enquiry_reply_email($to_name, $reply_msg);
      $headers  = "From: Brew & Go <taphahablah@gmail.com>\r\n";
      $headers .= "Reply-To: taphahablah@gmail.com\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

      if (mail($to_email, $subject, $body, $headers)) {
        // 5d) Record the reply in your DB
        $upd = $conn->prepare(
          "UPDATE enquiries
                        SET reply_message = ?,
                            reply_sent_at  = NOW()
                      WHERE id = ?"
        );
        $upd->bind_param('si', $reply_msg, $enq_id);
        $upd->execute();
        $upd->close();

        $success = "Reply sent successfully to {$to_email}.";
      } else {
        $error = "Failed to send email. Check your mail configuration and logs.";
      }
    } else {
      $stmt->close();
      $error = "Enquiry not found.";
    }
  }
}

// 6) Fetch the full enquiry details for display
$stmt = $conn->prepare(
  "SELECT firstname, lastname, email, enquirytype, message, submitted_at, reply_message, reply_sent_at
       FROM enquiries
      WHERE id = ?"
);
$stmt->bind_param('i', $enq_id);
$stmt->execute();
$stmt->bind_result($fn, $ln, $email, $etype, $msg, $submitted, $old_reply, $old_reply_at);

if (! $stmt->fetch()) {
  die("Enquiry #{$enq_id} not found.");
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Reply to Enquiry #<?php echo $enq_id; ?> – Brew &amp; Go</title>
  <link rel="stylesheet" href="styles/style.css">
</head>

<body>
  <?php include("inc/top_navigation_bar.inc"); ?>

  <main>
    <section class="login-container" id="reply-enquiry">
      <h2>Reply to Enquiry #<?php echo $enq_id; ?></h2>

      <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
      <?php elseif ($success): ?>
        <div class="success-msg"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <section class="enquiry-details">
        <h3>Enquiry Details</h3>
        <table class="enquiry-table">
          <tr>
            <th>Name:</th>
            <td><?= htmlspecialchars("{$fn} {$ln}") ?></td>
          </tr>
          <tr>
            <th>Email:</th>
            <td><?= htmlspecialchars($email) ?></td>
          </tr>
          <tr>
            <th>Type:</th>
            <td><?= htmlspecialchars($etype) ?></td>
          </tr>
          <tr>
            <th>Submitted:</th>
            <td><?= htmlspecialchars($submitted) ?></td>
          </tr>
          <tr>
            <th>Message:</th>
            <td><?= nl2br(htmlspecialchars($msg)) ?></td>
          </tr>
          <?php if ($old_reply): ?>
          <tr>
            <th>Already Replied:</th>
            <td><?= nl2br(htmlspecialchars($old_reply)) ?></td>
          </tr>
          <tr>
            <th>Replied At:</th>
            <td><?= htmlspecialchars($old_reply_at) ?></td>
          </tr>
          <?php endif; ?>
        </table>
      </section>

      <section class="reply-form">
        <h3>Your Reply</h3>
        <form method="post">
          <textarea
            name="reply_message"
            rows="6"
            style="width:100%;"
            placeholder="Write your response here…"><?= htmlspecialchars($_POST['reply_message'] ?? '') ?></textarea>
          <button type="submit">Send Reply</button>
        </form>
      </section>

      <p><a href="admin_dashboard.php">← Back to Dashboard</a></p>
    </section>
  </main>

  <?php include("inc/footer.inc"); ?>
</body>

</html>