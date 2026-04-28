<?php
// includes/footer.php
?>
</main>
<footer class="site-footer">
    <div class="footer-grid">
        <div class="footer-col">
            <a href="index.php" class="logo" style="display: inline-block;">
                <img src="/assets/images/Main_logoNew.png" alt="Rocks GenZ Granites Logo"
                    style="max-height: 52px; width: auto; object-fit: contain; filter: brightness(0) invert(1);">
            </a>
            <p style="margin-top: 1rem; opacity: 0.8;">
                <?= htmlspecialchars($settings['about_summary'] ?? 'Premium natural stone and granite export.') ?>
            </p>
            <div style="margin-top: 1.5rem; display: flex; gap: 1rem; font-size: 0.9rem;">
                <?php if (!empty($settings['social_facebook'])): ?>
                    <a href="<?= htmlspecialchars($settings['social_facebook']) ?>" target="_blank"
                        style="color: var(--primary-color); text-decoration: none;">Facebook</a>
                <?php endif; ?>
                <?php if (!empty($settings['social_instagram'])): ?>
                    <a href="<?= htmlspecialchars($settings['social_instagram']) ?>" target="_blank"
                        style="color: var(--primary-color); text-decoration: none;">Instagram</a>
                <?php endif; ?>
                <?php if (!empty($settings['social_twitter'])): ?>
                    <a href="<?= htmlspecialchars($settings['social_twitter']) ?>" target="_blank"
                        style="color: var(--primary-color); text-decoration: none;">Twitter</a>
                <?php endif; ?>
                <?php if (!empty($settings['social_linkedin'])): ?>
                    <a href="<?= htmlspecialchars($settings['social_linkedin']) ?>" target="_blank"
                        style="color: var(--primary-color); text-decoration: none;">LinkedIn</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-col" style="display: flex; align-items: center; justify-content: center;">
            <div style="background: #fff; border-radius: 10px; padding: 10px 16px; display: inline-flex; align-items: center; justify-content: center;">
                <img src="/assets/images/logo.jpg" alt="Lotus Export Import Company"
                    style="max-height: 90px; width: auto; object-fit: contain;">
            </div>
        </div>

        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="about.php">About Us</a></li>
                <li><a href="blog.php">Our Blog</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Products</h4>
            <ul>
                <?php
                if (!isset($categories)) {
                    $stmt = $pdo->query("SELECT name, slug FROM categories ORDER BY sort_order ASC");
                    $categories = $stmt->fetchAll();
                }
                foreach ($categories as $cat):
                    ?>
                    <li><a href="category.php?slug=<?= urlencode($cat['slug']) ?>"><?= htmlspecialchars($cat['name']) ?>
                            Collection</a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Contact Info</h4>
            <ul>
                <li>📧 <?= htmlspecialchars($settings['contact_email'] ?? 'info@Rocks Genz Granites.com') ?></li>
                <li>📞 <?= htmlspecialchars($settings['contact_phone'] ?? '+86 123 456 7890') ?></li>
                <li>📍 <?= htmlspecialchars($settings['contact_address'] ?? 'Guangdong, China') ?></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Rocks Genz Granites. All rights reserved.</p>
        <p style="margin-top: 0.5rem;">
            <a href="privacy.php">Privacy Policy</a> |
            <a href="terms.php">Terms of Services</a>
        </p>
    </div>
</footer>

<!-- Local Chat Widget -->
<?php require_once __DIR__ . '/chat.php'; ?>

</body>

</html>