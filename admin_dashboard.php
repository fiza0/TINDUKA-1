<?php
require 'config.php';
require 'includes/admin_auth.php';
require_admin();

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");

// Fetch all photos with user info
$photos = $conn->query("
    SELECT photos.*, users.firstname, users.lastname 
    FROM photos 
    JOIN users ON photos.user_id = users.user_id
    ORDER BY photos.created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="admin-header">
        <h1>Admin Dashboard</h1>
        <a href="admin_logout.php">Logout</a>
    </div>

    <section>
        <h2>Users (<?= $users->num_rows ?>)</h2>
        <table>
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
                        <form action="admin_delete.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="type" value="user">
                            <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Photos (<?= $photos->num_rows ?>)</h2>
        <table>
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
                        <form action="admin_delete.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="type" value="photo">
                            <input type="hidden" name="id" value="<?= $photo['photo_id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</body>
</html>