<?php
// admin/menus.php
require_once __DIR__ . '/header.php';

$message = '';

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $url = $_POST['url'] ?? '';
    $sort_order = $_POST['sort_order'] ?? 0;
    
    if ($title && $url) {
        try {
            $stmt = $pdo->prepare("INSERT INTO menus (title, url, sort_order) VALUES (?, ?, ?)");
            $stmt->execute([$title, $url, $sort_order]);
            $message = "Menu item added successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $url = $_POST['url'] ?? '';
    $sort_order = $_POST['sort_order'] ?? 0;
    
    if ($id && $title && $url) {
        try {
            $stmt = $pdo->prepare("UPDATE menus SET title = ?, url = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$title, $url, $sort_order, $id]);
            $message = "Menu item updated successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Update Order (bulk update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_order') {
    if (isset($_POST['sort_order']) && is_array($_POST['sort_order'])) {
        try {
            $stmt = $pdo->prepare("UPDATE menus SET sort_order = ? WHERE id = ?");
            foreach ($_POST['sort_order'] as $id => $order) {
                $stmt->execute([$order, $id]);
            }
            $message = "Menu order updated successfully.";
        } catch (PDOException $e) {
            $message = "Error updating order: " . $e->getMessage();
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM menus WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Menu item deleted successfully.";
}

// Fetch single menu item for Edit mode
$editMenu = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editMenu = $stmt->fetch();
}

// Fetch all menu items
$menus = $pdo->query("SELECT * FROM menus ORDER BY sort_order ASC")->fetchAll();
?>

<div class="admin-header">
    <h1>Menu Builder</h1>
</div>

<?php if ($message): ?>
    <div style="background: #e2e3e5; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div style="display: flex; gap: 2rem;">
    <div style="flex: 1;">
        <div class="card" style="padding: 1.5rem;">
            <h3><?= $editMenu ? 'Edit Link' : 'Add New Link' ?></h3>
            <form method="POST" style="margin-top: 1rem;">
                <input type="hidden" name="action" value="<?= $editMenu ? 'edit' : 'add' ?>">
                <?php if ($editMenu): ?>
                    <input type="hidden" name="id" value="<?= $editMenu['id'] ?>">
                <?php endif; ?>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Link Title</label>
                    <input type="text" name="title" required value="<?= htmlspecialchars($editMenu['title'] ?? '') ?>" placeholder="e.g. Our Process" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">URL</label>
                    <input type="text" name="url" required value="<?= htmlspecialchars($editMenu['url'] ?? '') ?>" placeholder="e.g. /process.php or https://..." style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Sort Order</label>
                    <input type="number" name="sort_order" value="<?= htmlspecialchars($editMenu['sort_order'] ?? '0') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
                </div>
                <button type="submit" class="btn"><?= $editMenu ? 'Update Link' : 'Add Link' ?></button>
                <?php if ($editMenu): ?>
                    <a href="/admin/menus.php" class="btn btn-outline" style="margin-left: 0.5rem;">Cancel</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    
    <div style="flex: 2;">
        <form method="POST">
            <input type="hidden" name="action" value="update_order">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">Order</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $item): ?>
                    <tr>
                        <td>
                            <input type="number" name="sort_order[<?= $item['id'] ?>]" value="<?= $item['sort_order'] ?>" style="width: 60px; padding: 0.4rem;">
                        </td>
                        <td><strong><?= htmlspecialchars($item['title']) ?></strong></td>
                        <td style="color: #666;"><?= htmlspecialchars($item['url']) ?></td>
                        <td>
                            <a href="?edit=<?= $item['id'] ?>" style="color: var(--primary-color); margin-right: 10px;">Edit</a>
                            <a href="?delete=<?= $item['id'] ?>" style="color: #ff6b6b;" onclick="return confirm('Are you sure you want to delete this link?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 1rem; text-align: right;">
                <button type="submit" class="btn btn-outline">Save Order</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
