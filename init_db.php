<?php
// init_db.php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'Rocks Genz Granites';

try {
    // Connect without database selected
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to MySQL server successfully.<br>";

    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database `$dbname` created or already exists.<br>";

    // Select the database
    $pdo->exec("USE `$dbname`");

    // Table: admins
    $pdo->exec("CREATE TABLE IF NOT EXISTS `admins` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `password_hash` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Create default admin user (admin / admin123)
    $stmt = $pdo->prepare("SELECT * FROM `admins` WHERE `username` = 'admin'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO `admins` (`username`, `password_hash`) VALUES ('admin', '$hash')");
        echo "Default admin user created. (admin / admin123)<br>";
    }

    // Table: categories
    $pdo->exec("CREATE TABLE IF NOT EXISTS `categories` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `slug` VARCHAR(100) NOT NULL UNIQUE,
        `description` TEXT,
        `image` VARCHAR(255),
        `sort_order` INT DEFAULT 0
    )");

    // Insert default categories if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM `categories`");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO `categories` (`name`, `slug`, `sort_order`) VALUES 
            ('Granite', 'granite', 1),
            ('Marble', 'marble', 2),
            ('Tiles', 'tiles', 3),
            ('Quartz', 'quartz', 4)
        ");
        echo "Default categories inserted.<br>";
    }

    // Table: products
    $pdo->exec("CREATE TABLE IF NOT EXISTS `products` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `category_id` INT NOT NULL,
        `name` VARCHAR(150) NOT NULL,
        `slug` VARCHAR(150) NOT NULL UNIQUE,
        `short_desc` TEXT,
        `long_desc` LONGTEXT,
        `image` VARCHAR(255),
        `is_featured` TINYINT(1) DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
    )");

    // Table: blog_posts
    $pdo->exec("CREATE TABLE IF NOT EXISTS `blog_posts` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `slug` VARCHAR(255) NOT NULL UNIQUE,
        `content` LONGTEXT NOT NULL,
        `image` VARCHAR(255),
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Table: gallery
    $pdo->exec("CREATE TABLE IF NOT EXISTS `gallery` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(150),
        `image_path` VARCHAR(255) NOT NULL,
        `category` VARCHAR(100),
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Table: site_settings
    $pdo->exec("CREATE TABLE IF NOT EXISTS `site_settings` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `setting_key` VARCHAR(50) NOT NULL UNIQUE,
        `setting_value` TEXT
    )");

    // Insert default settings
    $stmt = $pdo->query("SELECT COUNT(*) FROM `site_settings`");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES 
            ('site_name', 'Rocks Genz Granites Granite'),
            ('contact_email', 'info@Rocks Genz Granites.com'),
            ('contact_phone', '+86 123 456 7890'),
            ('contact_address', 'Guangdong, China'),
            ('about_summary', 'Premium natural stone and granite export from China.')
        ");
        echo "Default site settings inserted.<br>";
    }

    // Table: inquiries
    $pdo->exec("CREATE TABLE IF NOT EXISTS `inquiries` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(100) NOT NULL,
        `phone` VARCHAR(50),
        `message` TEXT NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    echo "<h3 style='color:green;'>Database initialization completed successfully!</h3>";
    echo "<p>You can now delete this file (init_db.php) for security.</p>";

} catch (PDOException $e) {
    die("<h3 style='color:red;'>Initialization failed: " . $e->getMessage() . "</h3>");
}
?>