<?php
require 'config.php';
require 'includes/admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['email'] === ADMIN_EMAIL && 
        password_verify($_POST['password'], ADMIN_PASSWORD_HASH)) {
        
        $_SESSION['admin_id'] = 1;
        $_SESSION['is_admin'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid admin credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="admin-login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>