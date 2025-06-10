<?php
// inc/footerbare.inc

// 1. Safely include the DB connection only once
if (!isset($conn)) {
    require_once __DIR__ . '/database_connection.inc';
}

// 2. Get the 5 latest updates
$sql = "SELECT id, title FROM updates ORDER BY created_at DESC LIMIT 5";
$res = $conn->query($sql);
?>

<footer>
  <div class="footer-container">
    <div class="row">
      <!-- other columns omitted for brevity -->

      <!-- Column 6: Latest Updates -->
      <div class="footer-col">
        <h4>Latest Updates</h4>
        <?php if ($res && $res->num_rows): ?>
          <ul>
            <?php while ($u = $res->fetch_assoc()): ?>
              <li>
                <a href="update_detail.php?id=<?= $u['id'] ?>">
                  <?= htmlspecialchars($u['title'], ENT_QUOTES) ?>
                </a>
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                  <a class="edit-link" href="edit_update.php?id=<?= $u['id'] ?>">Edit</a>
                <?php endif; ?>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <p>No updates at the moment.</p>
        <?php endif; ?>
      </div>

      <!-- Footer Copyright -->
      <div class="footer-col">
        <small>&copy; 2025 Brew & Go Coffee</small>
      </div>
    </div>
  </div>
</footer>


<?php
// edit_update.php
require_once __DIR__ . '/inc/auth.inc';      // Protect: admin only
require_once __DIR__ . '/inc/database_connection.inc';

$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = (int) $_POST['id'];
    $title = trim($_POST['title']);

    if ($title === '') {
        $error = 'Title cannot be empty.';
    } else {
        $stmt = $conn->prepare("UPDATE updates SET title = ? WHERE id = ?");
        $stmt->bind_param('si', $title, $id);
        $stmt->execute();
        // Redirect back to the page that loaded this, typically the footer's page
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }
}

// If GET or error in POST, fetch the record
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare("SELECT id, title FROM updates WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$update = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Update</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <div class="edit-update-form">
    <h1>Edit Update</h1>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="post" action="edit_update.php">
      <input type="hidden" name="id" value="<?= $update['id'] ?>">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title" value="<?= htmlspecialchars($update['title'], ENT_QUOTES) ?>" required>
      <button type="submit">Save</button>
    </form>
  </div>
</body>
</html>

<!-- /* Add this to your CSS: */
.edit-link {
    margin-left: 8px;
    font-size: 0.9em;
    color: #0066cc;
    text-decoration: underline;
}
.edit-link:hover {
    color: #004999;
} -->
