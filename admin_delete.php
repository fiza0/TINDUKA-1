<?php
require 'config.php';
require 'includes/admin_auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    $type = $_POST['type'];
    $id = (int)$_POST['id'];

    if ($type === 'user') {
        // Delete user's photos first
        $conn->query("DELETE FROM photos WHERE user_id = $id");
        // Then delete user
        $conn->query("DELETE FROM users WHERE user_id = $id");
    } elseif ($type === 'photo') {
        // Get photo path before deletion
        $photo = $conn->query("SELECT photo_url FROM photos WHERE photo_id = $id")->fetch_assoc();
        // Delete from database
        $conn->query("DELETE FROM photos WHERE photo_id = $id");
        // Delete file
        if ($photo && file_exists($photo['photo_url'])) {
            unlink($photo['photo_url']);
        }
    }

    header("Location: admin_dashboard.php");
    exit();
}