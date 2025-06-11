<?php
include("inc/login_status.inc");
include("inc/database_connection.inc");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?error=not_authorized");
    exit;
}

$edit   = false;
$member = [
  'firstname'=>'',
  'lastname'=>'',
  'email'=>'',
  'username'=>''
];

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $edit = true;
    $id   = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT firstname, lastname, email, username FROM members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($member['firstname'], $member['lastname'], $member['email'], $member['username']);
    $stmt->fetch();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= $edit ? "Edit" : "Add" ?> Member</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <?php include("inc/top_navigation_bar.inc"); ?>

  <main>
    <section class="login-container" id="member-form">
      <h2><?= $edit ? "Edit Member" : "Add New Member" ?></h2>

      <form action="member_save.php" method="post" class="member-form">
        <?php if ($edit): ?>
          <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <label>
          First Name
          <input type="text" name="firstname" required
                 value="<?= htmlspecialchars($member['firstname']) ?>">
        </label>

        <label>
          Last Name
          <input type="text" name="lastname" required
                 value="<?= htmlspecialchars($member['lastname']) ?>">
        </label>

        <label>
          Email
          <input type="email" name="email" required
                 value="<?= htmlspecialchars($member['email']) ?>">
        </label>

        <label>
          Username
          <input type="text" name="username" required
                 value="<?= htmlspecialchars($member['username']) ?>">
        </label>

        <label>
          Password
          <input type="password" name="password" required>
          <small><?= $edit ? "(enter new password to change)" : "" ?></small>
        </label>

        <button type="submit" class="responsive-hover-button"><?= $edit ? "Update" : "Create" ?></button>
      </form>

      <p><a href="view_membership.php">← Back to Memberships</a></p>
    </section>
  </main>

  <?php include("inc/footer.inc"); ?>
</body>
</html>