<?php
// gallery.php
require_once __DIR__ . '/includes/header.php';

// Fetch gallery images
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
$images = $stmt->fetchAll();
?>

<section class="hero"
    style="height: 40vh; background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/images/blog_floor.png'); background-position: center; background-size: cover;">
    <div class="hero-content">
        <h1 style="font-size: 3rem;">Design Gallery</h1>
        <p>Explore inspiring spaces created with our premium natural stones.</p>
    </div>
</section>

<section class="section">
    <?php if (empty($images)): ?>
        <div style="text-align: center; padding: 5rem 0;">
            <h3 style="color: #888;">Gallery is currently empty. Check back later!</h3>
        </div>
    <?php else: ?>
        <div class="grid-3" style="gap: 1rem;">
            <?php foreach ($images as $img): ?>
                <div
                    style="overflow: hidden; border-radius: 4px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); position: relative; group">
                    <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="<?= htmlspecialchars($img['title']) ?>"
                        style="width: 100%; height: 300px; object-fit: cover; display: block; transition: transform 0.5s ease;"
                        onerror="this.src='https://placehold.co/600x400/e0e0e0/1a1a1a?text=Gallery+Image'" class="gallery-img">
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 2rem 1rem 1rem; color: #fff;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><?= htmlspecialchars($img['title']) ?></h4>
                        <span
                            style="font-size: 0.8rem; text-transform: uppercase; color: var(--primary-color);"><?= htmlspecialchars($img['category']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<style>
    .gallery-img:hover {
        transform: scale(1.1);
    }
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>