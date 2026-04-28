<?php
// product-detail.php
require_once __DIR__ . '/includes/header.php';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    die("Product not specified.");
}

// Fetch product details
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                       FROM products p 
                       JOIN categories c ON p.category_id = c.id 
                       WHERE p.slug = ?");
$stmt->execute([$slug]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}
?>

<div style="background-color: var(--bg-secondary); padding: 2rem 0;">
    <div class="nav-container" style="padding: 0 2rem;">
        <a href="/index.php" style="color: var(--primary-color); font-weight: 600;">Home</a> /
        <a href="/category.php?slug=<?= urlencode($product['category_slug']) ?>"
            style="color: var(--primary-color); font-weight: 600;"><?= htmlspecialchars($product['category_name']) ?></a>
        /
        <span style="color: #666;"><?= htmlspecialchars($product['name']) ?></span>
    </div>
</div>

<section class="section">
    <div class="grid-3">
        <div style="grid-column: span 2;">
            <img src="<?= htmlspecialchars($product['image'] ?: '/assets/images/placeholder.jpg') ?>"
                alt="<?= htmlspecialchars($product['name']) ?>"
                style="width: 100%; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);"
                onerror="this.src='https://placehold.co/800x600/e0e0e0/1a1a1a?text=Product+Image'">
        </div>
        <div style="padding-left: 2rem;">
            <span
                style="display: inline-block; padding: 4px 12px; background-color: var(--primary-color); color: #fff; border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; margin-bottom: 1rem;">
                <?= htmlspecialchars($product['category_name']) ?>
            </span>
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;"><?= htmlspecialchars($product['name']) ?></h1>
            <p
                style="font-size: 1.2rem; color: #555; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 2rem;">
                <?= htmlspecialchars($product['short_desc']) ?>
            </p>

            <div style="margin-bottom: 2rem;">
                <h3>Description</h3>
                <div style="line-height: 1.8; color: #444;">
                    <?= nl2br(htmlspecialchars($product['long_desc'] ?: 'Detailed description for this product is currently unavailable.')) ?>
                </div>
            </div>

            <div
                style="background-color: var(--bg-secondary); padding: 2rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                <h3 style="margin-bottom: 1rem;">Interested in Bulk Orders?</h3>
                <p style="margin-bottom: 1.5rem; font-size: 0.95rem;">Contact us to get a specialized quote for
                    container shipments directly from our Chinese facilities.</p>
                <a href="/contact.php?product=<?= urlencode($product['name']) ?>" class="btn"
                    style="width: 100%; text-align: center;">Request a Quote</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>