<?php
require_once __DIR__ . '/config/db.php';

try {
    // 1. Update Products
    $pdo->exec("TRUNCATE TABLE products");

    // Get Categories
    $catGranite = $pdo->query("SELECT id FROM categories WHERE slug='granite'")->fetchColumn();
    $catMarble = $pdo->query("SELECT id FROM categories WHERE slug='marble'")->fetchColumn();
    $catQuartz = $pdo->query("SELECT id FROM categories WHERE slug='quartz'")->fetchColumn();

    $products = [
        [$catGranite, 'Alaska Gold Granite', 'alaska-gold', 'Premium golden granite with intricate black veins.', '/assets/images/alaska_gold.png', 1],
        [$catMarble, 'Invisible Grey Marble', 'invisible-grey', 'Striking grey veins on a pure white background.', '/assets/images/invisible_grey.png', 1],
        [$catGranite, 'R Black Granite', 'r-black', 'Deep black granite with subtle crystalline sparkles.', '/assets/images/r_black.png', 1],
        [$catQuartz, 'Calacatta Quartz', 'calacatta-quartz', 'Bold thick grey and gold veining on bright white.', '/assets/images/calacatta_quartz.png', 1],
    ];

    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, short_desc, image, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($products as $p) {
        $stmt->execute($p);
    }

    // 2. Update Gallery
    $pdo->exec("TRUNCATE TABLE gallery");
    $gallery = [
        ['Modern Kitchen Island', 'Quartz', '/assets/images/blog_kitchen.png'],
        ['Luxury Villa Flooring', 'Marble', '/assets/images/blog_floor.png'],
        ['Quarry Operations', 'General', '/assets/images/about_us.png'],
    ];
    $stmt = $pdo->prepare("INSERT INTO gallery (title, category, image_path) VALUES (?, ?, ?)");
    foreach ($gallery as $g) {
        $stmt->execute($g);
    }

    // 3. Update Blog Posts
    $pdo->exec("TRUNCATE TABLE blog_posts");
    $blogs = [
        ['Why Is Super White Granite Trending?', 'super-white-granite', 'Super White Granite is trending because it combines the elegant look of marble with the strength of granite. It is perfect for modern kitchens and luxury islands.', '/assets/images/blog_kitchen.png'],
        ['Luxury Flooring Ideas with Calacatta', 'calacatta-flooring', 'Marble has always been the final choice when it comes to luxury flooring. The bold veining of Calacatta brings unparalleled elegance to living spaces.', '/assets/images/blog_floor.png'],
    ];
    $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content, image) VALUES (?, ?, ?, ?)");
    foreach ($blogs as $b) {
        $stmt->execute($b);
    }

    echo "Database updated with demo images successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
