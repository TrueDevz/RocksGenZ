<?php
// admin/inquiries.php
require_once __DIR__ . '/header.php';

$message = '';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Inquiry deleted successfully.";
}

// Fetch all inquiries
$inquiries = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC")->fetchAll();
?>

<div class="admin-header">
    <h1>Manage Inquiries</h1>
</div>

<?php if ($message): ?>
    <div style="background: #e2e3e5; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Contact Info</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($inquiries)): ?>
            <tr><td colspan="5" style="text-align: center;">No inquiries yet.</td></tr>
        <?php else: ?>
            <?php foreach ($inquiries as $inq): ?>
            <tr>
                <td style="white-space: nowrap;"><?= date('M j, Y H:i', strtotime($inq['created_at'])) ?></td>
                <td><?= htmlspecialchars($inq['name']) ?></td>
                <td>
                    <a href="mailto:<?= htmlspecialchars($inq['email']) ?>"><?= htmlspecialchars($inq['email']) ?></a><br>
                    <?= htmlspecialchars($inq['phone']) ?>
                </td>
                <td style="max-width: 300px;">
                    <div style="max-height: 100px; overflow-y: auto; padding-right: 10px;">
                        <?= nl2br(htmlspecialchars($inq['message'])) ?>
                    </div>
                </td>
                <td>
                    <a href="?delete=<?= $inq['id'] ?>" style="color: #ff6b6b;" onclick="return confirm('Delete this inquiry?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/footer.php'; ?>
