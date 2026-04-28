<?php
// index.php
require_once __DIR__ . '/includes/header.php';

// Fetch featured products (or just some products for display)
$stmt = $pdo->query("SELECT p.name, p.slug, p.image, c.name as category_name 
                     FROM products p 
                     JOIN categories c ON p.category_id = c.id 
                     WHERE p.is_featured = 1 LIMIT 4");
$featuredProducts = $stmt->fetchAll();

// If no featured products, get some random products
if (empty($featuredProducts)) {
    $stmt = $pdo->query("SELECT p.name, p.slug, p.image, c.name as category_name 
                         FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         LIMIT 4");
    $featuredProducts = $stmt->fetchAll();
}
?>

<section class="hero">
    <div class="hero-content">
        <h1>Premium Indian Rough Granite Blocks for Global Export</h1>
        <p>We export high-quality rough granite blocks directly from Indian quarries to international buyers.</p>
        <a href="/about.php" class="btn">Explore Our Collection</a>
    </div>
</section>

<section class="section">
    <div class="section-title">
        <h2>Building Strength with Every Block</h2>
    </div>
    <div style="text-align: center; max-width: 800px; margin: 0 auto 3rem auto;">
        <p style="font-size: 1.1rem; color: #555; text-align: justify;">
            Built on a foundation of trust, quality, and quarry expertise, Rocks GenZ Granites stands for excellence in every block we deliver.<br><br>
            Our legacy is shaped by years of experience in sourcing premium rough granite blocks from India's finest quarries. We combine traditional stone knowledge with modern export standards to serve global markets with confidence.<br><br>
            Each block reflects our commitment to strength, consistency, and natural quality. From quarry selection to port dispatch, every stage is managed with precision and care.<br><br>
            Our reputation is built on dependable supply, transparent business, and long-term partnerships. We serve international buyers with export-ready granite blocks tailored for large-scale processing needs.<br><br>
            Strict quality checks ensure every shipment meets global expectations. With every container shipped, we reinforce our promise of reliability and value. Our legacy is not just in stone — it is in the trust we build worldwide.
        </p>
        <br>
        <a href="/about.php" class="btn btn-outline">Learn More About Us</a>
    </div>
</section>

<section class="section" style="background-color: var(--bg-secondary);">
    <div class="section-title">
        <h2>Featured Collection</h2>
    </div>
    <div class="grid-4">
        <?php if (!empty($featuredProducts)): ?>
            <?php foreach ($featuredProducts as $product): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($product['image'] ?: '/assets/images/placeholder.jpg') ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>" class="card-img"
                        onerror="this.src='https://placehold.co/400x300/e0e0e0/1a1a1a?text=Product+Image'">
                    <div class="card-content">
                        <span
                            style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color); font-weight: bold;"><?= htmlspecialchars($product['category_name']) ?></span>
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <a href="/product-detail.php?slug=<?= urlencode($product['slug']) ?>"
                            style="font-weight: 600; margin-top: 10px; display: inline-block;">View Details &rarr;</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card">
                <img src="https://placehold.co/400x300/e0e0e0/1a1a1a?text=Alaska+Gold" alt="Sample" class="card-img">
                <div class="card-content">
                    <span
                        style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color); font-weight: bold;">Granite</span>
                    <h3>Alaska Gold Granite</h3>
                    <a href="#" style="font-weight: 600; margin-top: 10px; display: inline-block;">View Details &rarr;</a>
                </div>
            </div>
            <div class="card">
                <img src="https://placehold.co/400x300/e0e0e0/1a1a1a?text=Invisible+Grey" alt="Sample" class="card-img">
                <div class="card-content">
                    <span
                        style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color); font-weight: bold;">Marble</span>
                    <h3>Invisible Grey Marble</h3>
                    <a href="#" style="font-weight: 600; margin-top: 10px; display: inline-block;">View Details &rarr;</a>
                </div>
            </div>
            <div class="card">
                <img src="https://placehold.co/400x300/e0e0e0/1a1a1a?text=R+Black" alt="Sample" class="card-img">
                <div class="card-content">
                    <span
                        style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color); font-weight: bold;">Granite</span>
                    <h3>R Black Granite</h3>
                    <a href="#" style="font-weight: 600; margin-top: 10px; display: inline-block;">View Details &rarr;</a>
                </div>
            </div>
            <div class="card">
                <img src="https://placehold.co/400x300/e0e0e0/1a1a1a?text=Calacatta" alt="Sample" class="card-img">
                <div class="card-content">
                    <span
                        style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color); font-weight: bold;">Quartz</span>
                    <h3>Calacatta Quartz</h3>
                    <a href="#" style="font-weight: 600; margin-top: 10px; display: inline-block;">View Details &rarr;</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div style="text-align: center; margin-top: 3rem;">
        <a href="/category.php?slug=granite" class="btn">View All Products</a>
    </div>
</section>

<section class="section">
    <div class="section-title">
        <h2>Why Choose Rocks GenZ Granites?</h2>
    </div>
    <div class="grid-4" style="text-align: center;">
        <div style="padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🏆</div>
            <h3>Trusted Quality</h3>
            <p>Strict quality standards for every block we export from India.</p>
        </div>
        <div style="padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">✨</div>
            <h3>Unique Designs</h3>
            <p>Exclusive natural stone patterns and textures that add timeless elegance.</p>
        </div>
        <div style="padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🌍</div>
            <h3>Global Reach</h3>
            <p>Supplying premium stones worldwide with reliable logistics network.</p>
        </div>
        <div style="padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🤝</div>
            <h3>Client Focused</h3>
            <p>We build long-term relationships and offer personalized solutions.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>