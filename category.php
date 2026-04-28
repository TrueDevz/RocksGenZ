<?php
// category.php
require_once __DIR__ . '/includes/header.php';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    die("Category not specified.");
}

// Fetch category details
$stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ?");
$stmt->execute([$slug]);
$category = $stmt->fetch();

if (!$category) {
    die("Category not found.");
}

// Fetch products for this category
$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY created_at DESC");
$stmt->execute([$category['id']]);
$products = $stmt->fetchAll();
?>

<section class="hero"
    style="height: 40vh; background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/images/alaska_gold.png'); background-size: cover; background-position: center;">
    <div class="hero-content">
        <h1 style="font-size: 3rem;"><?= htmlspecialchars($category['name']) ?> Collection</h1>
        <p><?= htmlspecialchars($category['description'] ?? 'Explore our premium range of ' . $category['name']) ?></p>
    </div>
</section>

<section class="section">
    <?php if (empty($products)): ?>
        <div style="text-align: center; padding: 5rem 0;">
            <h3 style="color: #888;">No products found in this category yet.</h3>
        </div>
    <?php else: ?>
        <div class="grid-4">
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($product['image'] ?: '/assets/images/placeholder.jpg') ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>" class="card-img"
                        onerror="this.src='https://placehold.co/400x300/e0e0e0/1a1a1a?text=Product+Image'">
                    <div class="card-content">
                        <span
                            style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color); font-weight: bold;"><?= htmlspecialchars($category['name']) ?></span>
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">
                            <?= htmlspecialchars($product['short_desc']) ?>
                        </p>
                        <a href="/product-detail.php?slug=<?= urlencode($product['slug']) ?>" class="btn btn-outline"
                            style="width: 100%; text-align: center;">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>