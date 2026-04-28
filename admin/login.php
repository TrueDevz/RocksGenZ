<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../config/db.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: /admin/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, password_hash FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: /admin/index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login - Rocks Genz Granites</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            background-color: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-box {
            background: #fff;
            padding: 3rem;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2 style="text-align: center; margin-bottom: 2rem; color: var(--primary-color);">Rocks Genz Granites Admin</h2>

        <?php if ($error): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 1rem; border-radius: 4px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Username</label>
                <input type="text" name="username" required
                    style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Password</label>
                <input type="password" name="password" required
                    style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
            </div>
            <button type="submit" class="btn" style="width: 100%;">Login</button>
        </form>
    </div>
</body>

</html>