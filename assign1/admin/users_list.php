<?php
require_once __DIR__ . '/inc/auth.inc.php';
require_once __DIR__ . '/../inc/database_connection.inc';
$conn->select_db('brew&go_db');

// Fetch all users
$sql = "SELECT id, firstname, lastname, email, username, role, reg_date
        FROM members
        ORDER BY id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Manage users for Brew & Go Coffee">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
  <link rel="stylesheet" href="styles/style.css">
  <title>User Management</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { padding: 8px 12px; border: 1px solid #ccc; text-align: left; }
    th { background: #f4f4f4; }
    a.button { padding: 6px 12px; background: #28a745; color: #fff; text-decoration: none; border-radius: 4px; }
    a.button:hover { background: #218838; }
  </style>
</head>
<body>
  <h1>User Management</h1>

  <!-- Link to Create New User -->
  <p><a class="button" href="user_form.php">➕ Create New User</a></p>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Username</th>
        <th>Role</th>
        <th>Joined</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows === 0): ?>
        <tr><td colspan="7">No users found.</td></tr>
      <?php else: ?>
        <?php while ($u = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($u['id']) ?></td>
            <td><?= htmlspecialchars($u['firstname'] . ' ' . $u['lastname']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['role']) ?></td>
            <td><?= htmlspecialchars($u['reg_date']) ?></td>
            <td>
              <a href="user_form.php?id=<?= $u['id'] ?>">Edit</a> |
              <a href="delete_user.php?id=<?= $u['id'] ?>"
                 onclick="return confirm('Delete <?= addslashes($u['username']) ?>?');">
                Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
