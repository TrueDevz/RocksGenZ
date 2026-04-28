<?php
// admin/blog.php
require_once __DIR__ . '/header.php';

$message = '';

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if ($title && $slug && $content) {
        try {
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content) VALUES (?, ?, ?)");
            $stmt->execute([$title, $slug, $content]);
            $message = "Blog post added successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if ($id && $title && $slug && $content) {
        try {
            $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, content = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $content, $id]);
            $message = "Blog post updated successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Post deleted successfully.";
}

// Fetch single post for Edit mode
$editPost = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editPost = $stmt->fetch();
}

$posts = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
?>

<div class="admin-header">
    <h1>Manage Blog Posts</h1>
</div>

<?php if ($message): ?>
    <div style="background: #e2e3e5; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <h3><?= $editPost ? 'Edit Post' : 'Add New Post' ?></h3>
    <form method="POST" style="margin-top: 1rem;">
        <input type="hidden" name="action" value="<?= $editPost ? 'edit' : 'add' ?>">
        <?php if ($editPost): ?>
            <input type="hidden" name="id" value="<?= $editPost['id'] ?>">
        <?php endif; ?>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Title</label>
            <input type="text" name="title" required value="<?= htmlspecialchars($editPost['title'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">URL Slug</label>
            <input type="text" name="slug" required value="<?= htmlspecialchars($editPost['slug'] ?? '') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Content</label>
            <textarea name="content" required rows="6" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px; resize: vertical;"><?= htmlspecialchars($editPost['content'] ?? '') ?></textarea>
        </div>
        
        <button type="submit" class="btn"><?= $editPost ? 'Update Post' : 'Publish Post' ?></button>
        <?php if ($editPost): ?>
            <a href="/admin/blog.php" class="btn btn-outline" style="margin-left: 0.5rem;">Cancel</a>
        <?php endif; ?>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= date('M j, Y', strtotime($post['created_at'])) ?></td>
            <td><?= htmlspecialchars($post['title']) ?></td>
            <td>
                <a href="?edit=<?= $post['id'] ?>" style="color: var(--primary-color); margin-right: 10px;">Edit</a>
                <a href="?delete=<?= $post['id'] ?>" style="color: #ff6b6b;" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/footer.php'; ?>
