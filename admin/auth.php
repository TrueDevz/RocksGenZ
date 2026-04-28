<?php
// admin/auth.php
session_start();
require_once __DIR__ . '/../config/db.php';

// Check if user is logged in
function requireLogin()
{
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: /admin/login.php');
        exit;
    }
}
?>