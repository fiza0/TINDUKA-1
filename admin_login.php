<?php
require 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = 'admin1@tinduka.com';
    $password = $_POST['password']; // You'll set this special password
    
    // Use a secure admin password (hash this and store in config.php)
    $admin_password_hash = password_hash('YOUR_SECURE_ADMIN_PASSWORD', PASSWORD_BCRYPT);
    
    if ($_POST['email'] === $email && password_verify($password, $admin_password_hash)) {
        $_SESSION['admin_id'] = 1;
        $_SESSION['is_admin'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['admin_error'] = "Invalid admin credentials";
        header("Location: admin_login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - TINDUKA</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="admin-login-container">
        <h2>Admin Portal</h2>
        <?php if (isset($_SESSION['admin_error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['admin_error'] ?></div>
            <?php unset($_SESSION['admin_error']); ?>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="email" value="admin1@tinduka.com">
            <div class="form-group">
                <label>Admin Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login as Admin</button>
        </form>
    </div>
</body>
</html>