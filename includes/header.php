<?php
// includes/header.php
require_once __DIR__ . '/../config/db.php';

// Fetch settings
$stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Fetch menu items for navigation
$stmt = $pdo->query("SELECT title, url FROM menus ORDER BY sort_order ASC");
$menuItems = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['site_name'] ?? 'Rocks GenZ Granites Granite') ?></title>
    <meta name="description" content="<?= htmlspecialchars($settings['about_summary'] ?? '') ?>">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <header class="site-header">
        <div class="nav-container">
            <a href="/index.php" class="logo">Next<span>Genz</span></a>

            <ul class="nav-links">
                <?php foreach ($menuItems as $item): ?>
                    <li><a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['title']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </header>
    <main>