<?php
// admin/categories.php
require_once __DIR__ . '/header.php';

$message = '';

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $sort_order = $_POST['sort_order'] ?? 0;
    
    if ($name && $slug) {
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name, slug, sort_order) VALUES (?, ?, ?)");
            $stmt->execute([$name, $slug, $sort_order]);
            $message = "Category added successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $sort_order = $_POST['sort_order'] ?? 0;
    
    if ($id && $name && $slug) {
        try {
            $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $sort_order, $id]);
            $message = "Category updated successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Category deleted successfully.";
}

// Fetch single category for Edit mode
$editCategory = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editCategory = $stmt->fetch();
}

// Fetch all categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY sort_order ASC")->fetchAll();
?>

<div class="admin-header">
    <h1>Manage Categories</h1>
</div>

<?php if ($message): ?>
    <div style="background: #e2e3e5; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div style="display: flex; gap: 2rem;">
    <div style="flex: 1;">
        <div class="card" style="padding: 1.5rem;">
            <h3><?= $editCategory ? 'Edit Category' : 'Add New Category' ?></h3>
            <form method="POST" style="margin-top: 1rem;">
                <input type="hidden" name="action" value="<?= $editCategory ? 'edit' : 'add' ?>">
                <?php if ($editCategory): ?>
                    <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
                <?php endif; ?>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Category Name</label>
                    <input type="text" name="name" required value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">URL Slug (e.g. granite-stones)</label>
                    <input type="text" name="slug" required value="<?= htmlspecialchars($editCategory['slug'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Sort Order</label>
                    <input type="number" name="sort_order" value="<?= htmlspecialchars($editCategory['sort_order'] ?? '0') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
                </div>
                <button type="submit" class="btn"><?= $editCategory ? 'Update Category' : 'Add Category' ?></button>
                <?php if ($editCategory): ?>
                    <a href="/admin/categories.php" class="btn btn-outline" style="margin-left: 0.5rem;">Cancel</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    
    <div style="flex: 2;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Sort Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td><?= htmlspecialchars($cat['slug']) ?></td>
                    <td><?= $cat['sort_order'] ?></td>
                    <td>
                        <a href="?edit=<?= $cat['id'] ?>" style="color: var(--primary-color); margin-right: 10px;">Edit</a>
                        <a href="?delete=<?= $cat['id'] ?>" style="color: #ff6b6b;" onclick="return confirm('Are you sure? This will delete all products in this category too.');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
