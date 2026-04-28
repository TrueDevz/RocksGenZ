<?php
// blog-detail.php
require_once __DIR__ . '/includes/header.php';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    die("Article not specified.");
}

// Fetch blog post details
$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ?");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    die("Article not found.");
}
?>

<div style="background-color: var(--bg-secondary); padding: 2rem 0;">
    <div class="nav-container" style="padding: 0 2rem;">
        <a href="/index.php" style="color: var(--primary-color); font-weight: 600;">Home</a> /
        <a href="/blog.php" style="color: var(--primary-color); font-weight: 600;">Blog</a> /
        <span style="color: #666;">Article</span>
    </div>
</div>

<section class="section" style="max-width: 800px; margin: 0 auto;">
    <span style="font-size: 0.9rem; color: #888; display: block; margin-bottom: 1rem; text-align: center;">Published on
        <?= date('F j, Y', strtotime($post['created_at'])) ?></span>
    <h1 style="text-align: center; font-size: 2.8rem; margin-bottom: 2rem;"><?= htmlspecialchars($post['title']) ?></h1>

    <img src="<?= htmlspecialchars($post['image'] ?: '/assets/images/placeholder.jpg') ?>"
        alt="<?= htmlspecialchars($post['title']) ?>"
        style="width: 100%; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 3rem;"
        onerror="this.src='https://placehold.co/800x400/e0e0e0/1a1a1a?text=Blog+Image'">

    <div style="font-size: 1.15rem; line-height: 1.8; color: #333;">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>

    <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--border-color); text-align: center;">
        <a href="/blog.php" class="btn btn-outline">&larr; Back to all articles</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>