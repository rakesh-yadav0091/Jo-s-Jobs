<!-- ============================================ -->
<!-- BANNER CAROUSEL WITH IMAGES                   -->
<!-- ============================================ -->
<div class="banner-container">
    <?php foreach ($banners as $index => $banner): ?>
    <div class="banner-slide" data-slide="<?php echo $index; ?>">
        <!-- Background image with overlay -->
        <div class="banner-image-wrapper">
            <?php 
            // Check if image exists, if not use gradient background
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . $banner['image'];
            if (file_exists($imagePath)): 
            ?>
                <img src="<?php echo $banner['image']; ?>" alt="<?php echo htmlspecialchars($banner['alt']); ?>" class="banner-image">
            <?php else: ?>
                <!-- FALLBACK: Use gradient background if image is missing -->
                <div class="banner-fallback" style="background: <?php echo $banner['gradient']; ?>; width: 100%; height: 100%;">
                    <div class="banner-fallback-pattern" style="
                        width: 100%;
                        height: 100%;
                        background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
                    "></div>
                </div>
            <?php endif; ?>
            <div class="banner-overlay"></div>
        </div>
        
        <!-- Content overlaid on image -->
        <div class="banner-content">
            <div class="banner-icon">
                <?php if ($index === 0): ?>
                    <i class="fas fa-briefcase"></i>
                <?php elseif ($index === 1): ?>
                    <i class="fas fa-building"></i>
                <?php elseif ($index === 2): ?>
                    <i class="fas fa-graduation-cap"></i>
                <?php else: ?>
                    <i class="fas fa-trophy"></i>
                <?php endif; ?>
            </div>
            <h2 class="banner-title"><?php echo htmlspecialchars($banner['title']); ?></h2>
            <p class="banner-subtitle"><?php echo htmlspecialchars($banner['subtitle']); ?></p>
            <a href="<?php echo $banner['button_link']; ?>" class="banner-btn">
                <?php echo htmlspecialchars($banner['button_text']); ?> 
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
    
    <!-- Navigation Dots -->
    <div class="banner-dots">
        <?php for ($i = 0; $i < count($banners); $i++): ?>
        <div class="banner-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
        <?php endfor; ?>
    </div>
    
    <!-- Navigation Arrows -->
    <button class="banner-arrow banner-arrow-left" aria-label="Previous slide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="banner-arrow banner-arrow-right" aria-label="Next slide">
        <i class="fas fa-chevron-right"></i>
    </button>
    
    <!-- Play/Pause Button -->
    <button class="banner-play-toggle" aria-label="Toggle auto-play">
        <i class="fas fa-pause"></i>
    </button>
</div>

<!-- ============================================ -->
<!-- MAIN CONTENT                                -->
<!-- ============================================ -->
<div class="main-container">
    <div class="welcome-section">
    <h2>Find More Than a Job - Find Your Future</h2>
    <p>Welcome to Jo's Jobs, where job seekers and employers connect. We don't just match CVs to roles; we match ambitions to opportunities. Ready to take the next step? Join hundreds of successful candidates and businesses who found their perfect match with us.</p>
        
        <div class="stats-container">
            <div class="stat-box">
                <i class="fas fa-briefcase"></i>
                <span class="stat-number">50+</span>
                <span class="stat-label">Jobs Posted</span>
            </div>
            <div class="stat-box">
                <i class="fas fa-users"></i>
                <span class="stat-number">30+</span>
                <span class="stat-label">Happy Employers</span>
            </div>
            <div class="stat-box">
                <i class="fas fa-check-circle"></i>
                <span class="stat-number">100+</span>
                <span class="stat-label">Placements Made</span>
            </div>
        </div>
    </div>

    <h2 class="section-title">Browse Jobs by Category</h2>
    <ul class="category-grid">
        <?php foreach ($categories as $category): ?>
            <li class="category-card">
                <i class="fas fa-briefcase"></i>
                <a href="/jobs?id=<?php echo (int)$category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (!empty($closingSoon)): ?>
        <h2 class="section-title">Jobs Closing Soon <i class="fas fa-clock"></i></h2>
        <div class="jobs-grid">
        <?php foreach ($closingSoon as $job): ?>
            <div class="job-card">
                <div class="job-badge urgent">Closing Soon!</div>
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <div class="job-salary"><i class="fas fa-pound-sign"></i> <?php echo htmlspecialchars($job['salary']); ?></div>
                <div class="job-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($job['location']); ?></div>
                <p><?php echo substr(htmlspecialchars($job['description']), 0, 120); ?>...</p>
                <a href="/apply?id=<?php echo (int)$job['id']; ?>" class="btn-apply">Apply Now</a>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
/* Fallback styles for missing banner images */
.banner-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.banner-fallback::after {
    content: '📋';
    font-size: 120px;
    opacity: 0.15;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>