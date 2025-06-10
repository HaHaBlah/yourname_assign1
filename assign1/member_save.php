<?php
// member_save.php
include("inc/login_status.inc");
include("inc/database_connection.inc");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?error=not_authorized");
    exit;
}

// collect & validate
$firstname = trim($_POST['firstname'] ?? '');
$lastname  = trim($_POST['lastname']  ?? '');
$email     = trim($_POST['email']     ?? '');
$username  = trim($_POST['username']  ?? '');
$password  = trim($_POST['password']  ?? '');

if (!$firstname || !$lastname || !$email || !$username || !$password) {
    die("All fields are required.");
}

// hash the password
$hashed = password_hash($password, PASSWORD_DEFAULT);

if (isset($_POST['id']) && ctype_digit($_POST['id'])) {
    // --- UPDATE ---
    $id   = (int)$_POST['id'];
    $sql  = "UPDATE members
             SET firstname=?, lastname=?, email=?, username=?, password=?
             WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi",
        $firstname,
        $lastname,
        $email,
        $username,
        $hashed,
        $id
    );
} else {
    // --- INSERT ---
    $sql  = "INSERT INTO members
             (firstname, lastname, email, username, password, reg_date)
             VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss",
        $firstname,
        $lastname,
        $email,
        $username,
        $hashed
    );
}

if ($stmt->execute()) {
    header("Location: view_membership.php?success=1");
    exit;
} else {
    echo "Database error: " . htmlspecialchars($stmt->error);
}
