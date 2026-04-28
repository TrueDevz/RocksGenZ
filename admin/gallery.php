<?php
// admin/gallery.php
require_once __DIR__ . '/header.php';

$message = '';

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $image_path = $_POST['image_path'] ?? '';
    
    if ($title && $image_path) {
        try {
            $stmt = $pdo->prepare("INSERT INTO gallery (title, category, image_path) VALUES (?, ?, ?)");
            $stmt->execute([$title, $category, $image_path]);
            $message = "Gallery image added successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $image_path = $_POST['image_path'] ?? '';
    
    if ($id && $title && $image_path) {
        try {
            $stmt = $pdo->prepare("UPDATE gallery SET title = ?, category = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$title, $category, $image_path, $id]);
            $message = "Gallery image updated successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Image deleted successfully.";
}

// Fetch single image for Edit mode
$editImage = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editImage = $stmt->fetch();
}

$images = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();
?>

<div class="admin-header">
    <h1>Manage Gallery</h1>
</div>

<?php if ($message): ?>
    <div style="background: #e2e3e5; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <h3><?= $editImage ? 'Edit Image' : 'Add New Image' ?></h3>
    <form method="POST" style="margin-top: 1rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <input type="hidden" name="action" value="<?= $editImage ? 'edit' : 'add' ?>">
        <?php if ($editImage): ?>
            <input type="hidden" name="id" value="<?= $editImage['id'] ?>">
        <?php endif; ?>
        
        <div>
            <label style="display: block; margin-bottom: 0.5rem;">Title</label>
            <input type="text" name="title" required value="<?= htmlspecialchars($editImage['title'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 0.5rem;">Category</label>
            <input type="text" name="category" required value="<?= htmlspecialchars($editImage['category'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="grid-column: span 2;">
            <label style="display: block; margin-bottom: 0.5rem;">Image URL</label>
            <input type="url" name="image_path" required value="<?= htmlspecialchars($editImage['image_path'] ?? '') ?>" placeholder="https://..." style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="grid-column: span 2;">
            <button type="submit" class="btn"><?= $editImage ? 'Update Image' : 'Add Image' ?></button>
            <?php if ($editImage): ?>
                <a href="/admin/gallery.php" class="btn btn-outline" style="margin-left: 0.5rem;">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="grid-4">
    <?php foreach ($images as $img): ?>
    <div class="card">
        <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="Gallery" class="card-img" style="height: 150px; object-fit: cover;">
        <div class="card-content" style="padding: 1rem;">
            <h4 style="margin-bottom: 0.5rem;"><?= htmlspecialchars($img['title']) ?></h4>
            <span style="font-size: 0.8rem; display: block; margin-bottom: 1rem; color: #666;"><?= htmlspecialchars($img['category']) ?></span>
            
            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <a href="?edit=<?= $img['id'] ?>" class="btn" style="flex: 1; text-align: center; padding: 0.5rem; font-size: 0.9rem;">Edit</a>
                <a href="?delete=<?= $img['id'] ?>" class="btn" style="flex: 1; text-align: center; padding: 0.5rem; font-size: 0.9rem; background: #ff6b6b; border-color: #ff6b6b;" onclick="return confirm('Delete this image?');">Delete</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
