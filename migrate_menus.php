<?php
// migrate_menus.php
require_once __DIR__ . '/config/db.php';

try {
    // Create menus table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `menus` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(100) NOT NULL,
        `url` VARCHAR(255) NOT NULL,
        `sort_order` INT DEFAULT 0
    )");

    echo "Menus table created successfully.<br>";

    // Check if table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM `menus`");
    if ($stmt->fetchColumn() == 0) {
        $sort = 1;
        
        // Add static links
        $pdo->exec("INSERT INTO `menus` (`title`, `url`, `sort_order`) VALUES ('Home', '/index.php', " . $sort++ . ")");
        $pdo->exec("INSERT INTO `menus` (`title`, `url`, `sort_order`) VALUES ('About Us', '/about.php', " . $sort++ . ")");
        
        // Fetch categories and add them as links
        $categories = $pdo->query("SELECT name, slug FROM categories ORDER BY sort_order ASC")->fetchAll();
        foreach ($categories as $cat) {
            $title = addslashes($cat['name']);
            $url = "/category.php?slug=" . urlencode($cat['slug']);
            $pdo->exec("INSERT INTO `menus` (`title`, `url`, `sort_order`) VALUES ('$title', '$url', " . $sort++ . ")");
        }
        
        // Add remaining static links
        $pdo->exec("INSERT INTO `menus` (`title`, `url`, `sort_order`) VALUES ('Blog', '/blog.php', " . $sort++ . ")");
        $pdo->exec("INSERT INTO `menus` (`title`, `url`, `sort_order`) VALUES ('Gallery', '/gallery.php', " . $sort++ . ")");
        $pdo->exec("INSERT INTO `menus` (`title`, `url`, `sort_order`) VALUES ('Get Quote', '/contact.php', " . $sort++ . ")");
        
        echo "Default menu items inserted successfully.<br>";
    } else {
        echo "Menus table is already populated.<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
