<?php
// admin/index.php
require_once __DIR__ . '/header.php';

// Fetch stats
$stats = [];
$stats['categories'] = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$stats['products'] = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$stats['blogs'] = $pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
$stats['inquiries'] = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();

// Fetch recent inquiries
$recentInquiries = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="admin-header">
    <h1>Dashboard</h1>
</div>

<div class="grid-4" style="margin-bottom: 3rem;">
    <div class="card" style="padding: 1.5rem; text-align: center;">
        <h3 style="color: var(--primary-color); font-size: 2.5rem; margin-bottom: 0.5rem;"><?= $stats['categories'] ?></h3>
        <p>Categories</p>
    </div>
    <div class="card" style="padding: 1.5rem; text-align: center;">
        <h3 style="color: var(--primary-color); font-size: 2.5rem; margin-bottom: 0.5rem;"><?= $stats['products'] ?></h3>
        <p>Products</p>
    </div>
    <div class="card" style="padding: 1.5rem; text-align: center;">
        <h3 style="color: var(--primary-color); font-size: 2.5rem; margin-bottom: 0.5rem;"><?= $stats['blogs'] ?></h3>
        <p>Blog Posts</p>
    </div>
    <div class="card" style="padding: 1.5rem; text-align: center;">
        <h3 style="color: var(--primary-color); font-size: 2.5rem; margin-bottom: 0.5rem;"><?= $stats['inquiries'] ?></h3>
        <p>Total Inquiries</p>
    </div>
</div>

<h2>Recent Inquiries</h2>
<div style="overflow-x: auto; margin-top: 1rem;">
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message Snippet</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($recentInquiries)): ?>
                <tr><td colspan="4" style="text-align: center;">No inquiries yet.</td></tr>
            <?php else: ?>
                <?php foreach ($recentInquiries as $inq): ?>
                <tr>
                    <td><?= date('M j, Y H:i', strtotime($inq['created_at'])) ?></td>
                    <td><?= htmlspecialchars($inq['name']) ?></td>
                    <td><?= htmlspecialchars($inq['email']) ?></td>
                    <td><?= htmlspecialchars(substr($inq['message'], 0, 50)) ?>...</td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
