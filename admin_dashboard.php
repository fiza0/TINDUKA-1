<?php
require 'includes/admin_init.php';

// Get all users
$users = $conn->query("SELECT user_id, firstname, lastname, email, created_at FROM users ORDER BY created_at DESC");

// Get all photos with user info
$photos = $conn->query("
    SELECT p.photo_id, p.caption, p.created_at, u.firstname, u.lastname 
    FROM photos p
    JOIN users u ON p.user_id = u.user_id
    ORDER BY p.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - TINDUKA</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <?php include 'includes/admin_navbar.php'; ?>
    
    <div class="admin-container">
        <h1>Admin Dashboard</h1>
        
        <section class="users-section">
            <h2>Registered Users (<?= $users->num_rows ?>)</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['user_id'] ?></td>
                        <td><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <form action="admin_actions.php" method="POST" class="delete-form">
                                <input type="hidden" name="action" value="delete_user">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
        
        <section class="photos-section">
            <h2>All Photos (<?= $photos->num_rows ?>)</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Caption</th>
                        <th>Author</th>
                        <th>Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($photo = $photos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $photo['photo_id'] ?></td>
                        <td><?= htmlspecialchars($photo['caption']) ?></td>
                        <td><?= htmlspecialchars($photo['firstname'] . ' ' . $photo['lastname']) ?></td>
                        <td><?= date('M j, Y', strtotime($photo['created_at'])) ?></td>
                        <td>
                            <form action="admin_actions.php" method="POST" class="delete-form">
                                <input type="hidden" name="action" value="delete_photo">
                                <input type="hidden" name="photo_id" value="<?= $photo['photo_id'] ?>">
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>