<?php
// includes/admin_auth.php
session_start();

// Hardcoded admin credentials (store securely in production)
const ADMIN_EMAIL = 'admin1@tinduka.com';
const ADMIN_PASSWORD_HASH = '$2y$10$tAqfP/PBlSm9z5CmGl8WIugDfA2T2pCmwwXaP4muTrGMG4L0N3q9a'; // Generate with password_hash()

// Check if user is admin
function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

// Redirect if not admin
function require_admin() {
    if (!is_admin()) {
        header("Location: admin_login.php");
        exit();
    }
}

// CSRF protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>