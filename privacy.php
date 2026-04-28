<?php
// privacy.php
require_once __DIR__ . '/includes/header.php';
?>

<section class="section" style="max-width: 800px; margin: 0 auto; padding-top: 5rem;">
    <h1 style="margin-bottom: 2rem;">Privacy Policy</h1>
    <p style="margin-bottom: 1rem; color: #555;">Effective Date: <?= date('F j, Y') ?></p>

    <div style="line-height: 1.8; color: #333;">
        <h3 style="margin-top: 2rem;">1. Information We Collect</h3>
        <p>We only collect information you provide directly to us through our contact forms, such as your name, email
            address, phone number, and inquiry details.</p>

        <h3 style="margin-top: 2rem;">2. How We Use Your Information</h3>
        <p>We use the information we collect to respond to your inquiries, provide quotes for bulk orders, and
            communicate with you regarding your orders or shipping logistics.</p>

        <h3 style="margin-top: 2rem;">3. Data Sharing</h3>
        <p>We do not sell or rent your personal data to third parties. We may share necessary information with our
            logistics and shipping partners strictly for fulfilling your orders.</p>

        <h3 style="margin-top: 2rem;">4. Cookies and Tracking</h3>
        <p>Our website uses minimal cookies to ensure basic functionality. We do not use third-party tracking or
            analytics services like Google Analytics.</p>

        <h3 style="margin-top: 2rem;">5. Contact Us</h3>
        <p>If you have any questions about this Privacy Policy, please contact us at
            <?= htmlspecialchars($settings['contact_email'] ?? 'info@Rocks Genz Granites.com') ?>.
        </p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>