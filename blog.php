<?php
// blog.php
require_once __DIR__ . '/includes/header.php';

// Fetch all blog posts
$stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<section class="hero"
    style="height: 40vh; background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/images/blog_kitchen.png'); background-size: cover; background-position: center;">
    <div class="hero-content">
        <h1 style="font-size: 3rem;">Industry Insights</h1>
        <p>Stay updated with trends in stone exports, architectural design, and material care.</p>
    </div>
</section>

<section class="section">
    <?php if (empty($posts)): ?>
        <div style="text-align: center; padding: 5rem 0;">
            <h3 style="color: #888;">No articles published yet. Check back soon!</h3>
        </div>
    <?php else: ?>
        <div class="grid-3">
            <?php foreach ($posts as $post): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($post['image'] ?: '/assets/images/placeholder.jpg') ?>"
                        alt="<?= htmlspecialchars($post['title']) ?>" class="card-img"
                        onerror="this.src='https://placehold.co/400x300/e0e0e0/1a1a1a?text=Blog+Image'">
                    <div class="card-content">
                        <span
                            style="font-size: 0.8rem; color: #888; display: block; margin-bottom: 0.5rem;"><?= date('F j, Y', strtotime($post['created_at'])) ?></span>
                        <h3 style="margin-bottom: 1rem; font-size: 1.4rem;">
                            <a
                                href="/blog-detail.php?slug=<?= urlencode($post['slug']) ?>"><?= htmlspecialchars($post['title']) ?></a>
                        </h3>
                        <p style="color: #555; margin-bottom: 1.5rem;">
                            <?= htmlspecialchars(substr(strip_tags($post['content']), 0, 120)) ?>...
                        </p>
                        <a href="/blog-detail.php?slug=<?= urlencode($post['slug']) ?>"
                            style="font-weight: 600; color: var(--primary-color);">Read More &rarr;</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>