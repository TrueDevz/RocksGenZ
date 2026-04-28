<?php
// admin/products.php
require_once __DIR__ . '/header.php';

$message = '';

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $category_id = $_POST['category_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $short_desc = $_POST['short_desc'] ?? '';
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    if ($name && $slug && $category_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, short_desc, is_featured) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$category_id, $name, $slug, $short_desc, $is_featured]);
            $message = "Product added successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $short_desc = $_POST['short_desc'] ?? '';
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    if ($id && $name && $slug && $category_id) {
        try {
            $stmt = $pdo->prepare("UPDATE products SET category_id = ?, name = ?, slug = ?, short_desc = ?, is_featured = ? WHERE id = ?");
            $stmt->execute([$category_id, $name, $slug, $short_desc, $is_featured, $id]);
            $message = "Product updated successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Product deleted successfully.";
}

// Fetch single product for Edit mode
$editProduct = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editProduct = $stmt->fetch();
}

// Fetch categories for dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

// Fetch products
$products = $pdo->query("SELECT p.*, c.name as cat_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll();
?>

<div class="admin-header">
    <h1>Manage Products</h1>
</div>

<?php if ($message): ?>
    <div style="background: #e2e3e5; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <h3><?= $editProduct ? 'Edit Product' : 'Add New Product' ?></h3>
    <form method="POST" style="margin-top: 1rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <input type="hidden" name="action" value="<?= $editProduct ? 'edit' : 'add' ?>">
        <?php if ($editProduct): ?>
            <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
        <?php endif; ?>
        
        <div style="grid-column: span 2;">
            <label style="display: block; margin-bottom: 0.5rem;">Category</label>
            <select name="category_id" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($editProduct && $editProduct['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 0.5rem;">Product Name</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 0.5rem;">URL Slug (e.g. alaska-gold)</label>
            <input type="text" name="slug" required value="<?= htmlspecialchars($editProduct['slug'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="grid-column: span 2;">
            <label style="display: block; margin-bottom: 0.5rem;">Short Description</label>
            <input type="text" name="short_desc" value="<?= htmlspecialchars($editProduct['short_desc'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="grid-column: span 2;">
            <label style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="is_featured" value="1" <?= ($editProduct && $editProduct['is_featured']) ? 'checked' : '' ?>>
                Featured Product (shows on home page)
            </label>
        </div>
        
        <div style="grid-column: span 2;">
            <button type="submit" class="btn"><?= $editProduct ? 'Update Product' : 'Add Product' ?></button>
            <?php if ($editProduct): ?>
                <a href="/admin/products.php" class="btn btn-outline" style="margin-left: 0.5rem;">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Featured</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $prod): ?>
        <tr>
            <td><?= $prod['id'] ?></td>
            <td><?= htmlspecialchars($prod['name']) ?></td>
            <td><?= htmlspecialchars($prod['cat_name']) ?></td>
            <td><?= $prod['is_featured'] ? 'Yes' : 'No' ?></td>
            <td>
                <a href="?edit=<?= $prod['id'] ?>" style="color: var(--primary-color); margin-right: 10px;">Edit</a>
                <a href="?delete=<?= $prod['id'] ?>" style="color: #ff6b6b;" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/footer.php'; ?>
