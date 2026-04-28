<?php
// about.php
require_once __DIR__ . '/includes/header.php';
?>

<section class="hero"
    style="height: 50vh; background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/images/about_us.png'); background-position: center; background-size: cover;">
    <div class="hero-content">
        <h1 style="font-size: 3rem;">About Rocks GenZ Granites</h1>
        <p>We are trusted exporters of premium Indian rough granite blocks, delivering naturally crafted stone from India’s finest quarries to global markets with quality, consistency, and reliability.</p>
    </div>
</section>

<section class="section">
    <div class="grid-3" style="align-items: center;">
        <div style="grid-column: span 2; padding-right: 2rem;">
            <h2 style="color: var(--primary-color);">Our Legacy of Excellence</h2>
            <p style="margin-bottom: 1rem; font-size: 1.1rem;">
                Built on a foundation of trust, quality, and quarry expertise, Rocks GenZ Granites stands for excellence in every block we deliver. Our legacy is shaped by years of experience in sourcing premium rough granite blocks from India's finest quarries. We combine traditional stone knowledge with modern export standards to serve global markets with confidence.
            </p>
            <p style="margin-bottom: 1rem; font-size: 1.1rem;">
                Each block reflects our commitment to strength, consistency, and natural quality. From quarry selection to port dispatch, every stage is managed with precision and care. Our reputation is built on dependable supply, transparent business, and long-term partnerships. We serve international buyers with export-ready granite blocks tailored for large-scale processing needs.
            </p>
            <p style="font-size: 1.1rem;">
                Strict quality checks ensure every shipment meets global expectations. With every container shipped, we reinforce our promise of reliability and value. Our legacy is not just in stone — it is in the trust we build worldwide.
            </p>
        </div>
        <div>
            <img src="/assets/images/about_us.png" alt="Quarry Operations"
                style="width: 100%; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        </div>
    </div>
</section>

<section class="section" style="text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        <video width="100%" controls preload="metadata" style="border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <source src="/assets/videos/demo.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</section>

<section class="section" style="background-color: var(--bg-secondary); text-align: center;">
    <div style="max-width: 800px; margin: 0 auto 3rem auto;">
        <h2 style="margin-bottom: 0;">Aryan Mittal</h2>
        <p style="color: #777; margin-bottom: 2rem;">Founder, Loutus Export and Import company</p>
        
        <h3 style="font-size: 1.5rem; text-transform: uppercase; margin-bottom: 1rem;">We don't just provide stone —<br>we create experiences</h3>
        
        <p style="color: #555; line-height: 1.6; text-align: justify;">
            Loutus Export and Import company was built on a simple belief: natural stone is more than a material—it's a story. Our collections reflect precision, sustainability, and artistry. With every marble slab, granite finish, and custom stone solution, we aim to deliver depth, character, and a lasting impression. Our mission is to bring India's finest stones to the world through trust, innovation, and craftsmanship.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 900px; margin: 0 auto;">
        <div class="card" style="padding: 2rem; border: 1px solid var(--border-color); box-shadow: 0 4px 15px rgba(0,0,0,0.05); background-color: #fff;">
            <h3 style="margin-bottom: 1rem;">Our Mission</h3>
            <p style="color: #555;">To deliver premium, ethically sourced marble and granite products that enhance modern spaces. We aim to blend quality, sustainability, and innovation to redefine natural stone experiences around the world.</p>
        </div>
        <div class="card" style="padding: 2rem; border: 1px solid var(--border-color); box-shadow: 0 4px 15px rgba(0,0,0,0.05); background-color: #fff;">
            <h3 style="margin-bottom: 1rem;">Our Vision</h3>
            <p style="color: #555;">To become a globally admired Indian stone brand known for premium marble, granite, and custom stone artistry—while staying rooted in heritage craftsmanship and modern innovation.</p>
        </div>
    </div>
</section>


<section class="section">
    <div class="section-title">
        <h2>Our Core Values</h2>
    </div>
    <div class="grid-3">
        <div class="card" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem; color: var(--primary-color);">💎</div>
            <h3>Uncompromising Quality</h3>
            <p>Every slab undergoes rigorous inspection to ensure it meets international export standards.</p>
        </div>
        <div class="card" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem; color: var(--primary-color);">🌐</div>
            <h3>Global Network</h3>
            <p>Reliable shipping and logistics to deliver bulk orders anywhere in the world on time.</p>
        </div>
        <div class="card" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem; color: var(--primary-color);">🌱</div>
            <h3>Sustainable Sourcing</h3>
            <p>We partner with responsible quarries to minimize environmental impact while maximizing yield.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>