<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    empty($_SESSION['admin_logged_in'])
    || empty($_SESSION['role'])
    || $_SESSION['role'] !== 'admin'
) {
    header('Location: ../admin_login.php');
    exit;
}

require_once __DIR__ . '/../../inc/database_connection.inc';
$conn->select_db('brew&go_db');

