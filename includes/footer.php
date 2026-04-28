<?php
// includes/footer.php
?>
</main>
<footer class="site-footer">
    <div class="footer-grid">
        <div class="footer-col">
            <a href="index.php" class="logo" style="color:var(--bg-light)">Next<span>Genz</span></a>
            <p style="margin-top: 1rem; opacity: 0.8;">
                <?= htmlspecialchars($settings['about_summary'] ?? 'Premium natural stone and granite export.') ?>
            </p>
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
                    <li><a href="category.php?slug=<?= urlencode($cat['slug']) ?>"><?= htmlspecialchars($cat['name']) ?> Collection</a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Contact Info</h4>
            <ul>
                <li>📧 <?= htmlspecialchars($settings['contact_email'] ?? 'info@Rocks GenZ Granites.com') ?></li>
                <li>📞 <?= htmlspecialchars($settings['contact_phone'] ?? '+86 123 456 7890') ?></li>
                <li>📍 <?= htmlspecialchars($settings['contact_address'] ?? 'Guangdong, China') ?></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Rocks GenZ Granites. All rights reserved.</p>
        <p style="margin-top: 0.5rem;">
            <a href="privacy.php">Privacy Policy</a> |
            <a href="terms.php">Terms of Services</a>
        </p>
    </div>
</footer>

<!-- No Google Analytics or External Scripts as per requirements -->
</body>

</html>