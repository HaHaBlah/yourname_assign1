<?php
// member_delete.php
include("inc/login_status.inc");
include("inc/database_connection.inc");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?error=not_authorized");
    exit;
}

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id   = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: view_membership.php?deleted=1");
exit;
?>