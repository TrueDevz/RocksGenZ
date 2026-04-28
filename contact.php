<?php
// contact.php
require_once __DIR__ . '/includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    $honeypot = $_POST['website'] ?? ''; // Honeypot field
    if (!empty($honeypot)) {
        $error = "Spam detected.";
    } elseif (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all required fields.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO inquiries (name, email, phone, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $message]);
            $success = true;
        } catch (PDOException $e) {
            $error = "An error occurred. Please try again later.";
        }
    }
}

$product_interest = $_GET['product'] ?? '';
?>

<section class="hero"
    style="height: 40vh; background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/images/hero_bg.png'); background-size: cover; background-position: center;">
    <div class="hero-content">
        <h1 style="font-size: 3rem;">Contact Us</h1>
        <p>Connect with us for premium rough granite block supply, bulk export requirements, and reliable global stone
            sourcing.</p>
    </div>
</section>

<section class="section">
    <div class="grid-3">
        <div
            style="grid-column: span 1; background-color: var(--bg-dark); color: var(--text-light); padding: 3rem 2rem; border-radius: 8px;">
            <h3 style="color: var(--primary-color); margin-bottom: 2rem;">Contact Information</h3>
            <div style="margin-bottom: 2rem;">
                <h4 style="font-size: 1rem; opacity: 0.8; margin-bottom: 0.5rem;">Address</h4>
                <p><?= htmlspecialchars($settings['contact_address'] ?? 'Guangdong, China') ?></p>
            </div>
            <div style="margin-bottom: 2rem;">
                <h4 style="font-size: 1rem; opacity: 0.8; margin-bottom: 0.5rem;">Phone</h4>
                <p><?= htmlspecialchars($settings['contact_phone'] ?? '+86 123 456 7890') ?></p>
            </div>
            <div>
                <h4 style="font-size: 1rem; opacity: 0.8; margin-bottom: 0.5rem;">Email</h4>
                <p><?= htmlspecialchars($settings['contact_email'] ?? 'info@Rocks Genz Granites.com') ?></p>
            </div>
        </div>

        <div style="grid-column: span 2; padding: 0 2rem;">
            <h2>Send us a Message</h2>
            <p style="margin-bottom: 2rem; color: #666;">We typically respond to bulk order inquiries within 24 hours.
            </p>

            <?php if ($success): ?>
                <div
                    style="padding: 1rem; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 2rem;">
                    Thank you! Your inquiry has been sent successfully. We will get back to you shortly.
                </div>
            <?php else: ?>
                <?php if ($error): ?>
                    <div
                        style="padding: 1rem; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 2rem;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/contact.php">
                    <!-- Honeypot -->
                    <div style="display:none;">
                        <label>Leave this blank</label>
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Your Name *</label>
                            <input type="text" name="name" required
                                style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px; font-family: inherit;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email Address *</label>
                            <input type="email" name="email" required
                                style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px; font-family: inherit;">
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone Number</label>
                        <input type="text" name="phone"
                            style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px; font-family: inherit;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Message *</label>
                        <textarea name="message" required rows="5"
                            style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 4px; font-family: inherit; resize: vertical;"><?= $product_interest ? "I am interested in bulk orders for " . htmlspecialchars($product_interest) . "." : "" ?></textarea>
                    </div>



                    <button type="submit" class="btn">Send Inquiry</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>