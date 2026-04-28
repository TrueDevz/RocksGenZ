<?php
// admin/settings.php
require_once __DIR__ . '/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'site_name' => $_POST['site_name'] ?? '',
        'contact_email' => $_POST['contact_email'] ?? '',
        'contact_phone' => $_POST['contact_phone'] ?? '',
        'contact_address' => $_POST['contact_address'] ?? '',
        'about_summary' => $_POST['about_summary'] ?? ''
    ];
    
    try {
        $stmt = $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
        foreach ($settings as $key => $value) {
            $stmt->execute([$value, $key]);
        }
        $message = "Settings updated successfully.";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch current settings
$stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
$current_settings = [];
while ($row = $stmt->fetch()) {
    $current_settings[$row['setting_key']] = $row['setting_value'];
}
?>

<div class="admin-header">
    <h1>Site Settings</h1>
</div>

<?php if ($message): ?>
    <div style="background: #e2e3e5; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="card" style="padding: 2rem; max-width: 800px;">
    <form method="POST">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Site Name</label>
            <input type="text" name="site_name" value="<?= htmlspecialchars($current_settings['site_name'] ?? '') ?>" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Contact Email</label>
            <input type="email" name="contact_email" value="<?= htmlspecialchars($current_settings['contact_email'] ?? '') ?>" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Contact Phone</label>
            <input type="text" name="contact_phone" value="<?= htmlspecialchars($current_settings['contact_phone'] ?? '') ?>" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Office Address</label>
            <input type="text" name="contact_address" value="<?= htmlspecialchars($current_settings['contact_address'] ?? '') ?>" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Footer About Summary</label>
            <textarea name="about_summary" required rows="4" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px; resize: vertical;"><?= htmlspecialchars($current_settings['about_summary'] ?? '') ?></textarea>
        </div>
        
        <button type="submit" class="btn">Save Settings</button>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
