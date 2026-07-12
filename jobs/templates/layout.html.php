<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>Jo's Jobs - <?php echo htmlspecialchars($title ?? 'Home'); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        header { background: linear-gradient(135deg, #1a3a6e, #c0392b, #e67e22); background-size: 200% 200%; color: white; padding: 30px 0; animation: gradientShift 8s ease infinite; position: relative; overflow: hidden; }
        @keyframes gradientShift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .header-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; position: relative; z-index: 2; }
        .office-hours { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 15px 25px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.3); animation: pulseBorder 2s ease-in-out infinite; }
        .office-hours h3 { color: #f39c12; animation: textGlow 2s ease-in-out infinite; }
        @keyframes textGlow { 0%,100% { text-shadow: 0 0 5px #f39c12; } 50% { text-shadow: 0 0 20px #f39c12; } }
        @keyframes pulseBorder { 0%,100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.4); } 50% { box-shadow: 0 0 0 15px rgba(255,255,255,0); } }
        .logo-link { text-decoration: none; display: flex; align-items: center; gap: 15px; transition: transform 0.3s ease; }
        .logo-link:hover { transform: scale(1.05) rotate(-2deg); }
        .logo-text { font-size: 42px; font-weight: 800; background: linear-gradient(135deg, #ffffff, #FFD700); background-size: 200% auto; -webkit-background-clip: text; background-clip: text; color: transparent; animation: shine 3s linear infinite, float3D 4s ease-in-out infinite; }
        @keyframes shine { 0% { background-position: 0% 50%; } 100% { background-position: 200% 50%; } }
        @keyframes float3D { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-5px); } }
        .logo-icon { font-size: 40px; animation: bounce 2s ease-in-out infinite; display: inline-block; }
        @keyframes bounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        nav { background: rgba(0,0,0,0.92); backdrop-filter: blur(15px); position: sticky; top: 0; z-index: 100; }
        .nav-menu { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; list-style: none; flex-wrap: wrap; }
        .nav-menu > li { padding: 18px 25px; position: relative; }
        .nav-menu > li > a { color: white; text-decoration: none; font-weight: 600; transition: color 0.3s; position: relative; }
        .nav-menu > li > a:hover { color: #f39c12; }
        .nav-menu > li > a::after { content: ""; position: absolute; bottom: -5px; left: 0; width: 0; height: 3px; background: linear-gradient(90deg, #f39c12, #e67e22); transition: width 0.3s; }
        .nav-menu > li:hover > a::after { width: 100%; }
        .dropdown { position: relative; }
        .dropdown-menu { position: absolute; top: 100%; left: 0; background: rgba(15,15,20,0.98); min-width: 260px; list-style: none; border-radius: 15px; opacity: 0; visibility: hidden; transform: translateY(-20px); transition: all 0.3s; border: 1px solid rgba(255,255,255,0.15); z-index: 1000; }
        .dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-menu li { padding: 12px 25px; transition: all 0.3s; }
        .dropdown-menu li:hover { background: rgba(243,156,18,0.2); transform: translateX(8px); }
        .dropdown-menu li a { color: white; text-decoration: none; }
        
        /* ============================================
           BANNER CAROUSEL - IMAGE STYLES
           ============================================ */
        .banner-container {
            position: relative;
            width: 100%;
            height: 550px;
            overflow: hidden;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            background: #1a1a2e;
        }
        .banner-image-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .banner-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 8s ease;
        }
        .banner-slide.active .banner-image {
            transform: scale(1.05);
        }
        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.6) 100%);
            z-index: 1;
        }
        .banner-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.8s ease, transform 0.8s ease;
            transform: scale(1.02);
            z-index: 0;
        }
        .banner-slide.active {
            opacity: 1;
            transform: scale(1);
            z-index: 1;
        }
        .banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            padding: 50px 80px;
            max-width: 750px;
            animation: fadeInUp 0.8s ease forwards;
        }
        .banner-slide:not(.active) .banner-content {
            animation: none;
            opacity: 0;
        }
        .banner-icon {
            font-size: 60px;
            margin-bottom: 20px;
            display: inline-block;
            background: rgba(255,255,255,0.12);
            padding: 25px 30px;
            border-radius: 50%;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.1);
            animation: float 3s ease-in-out infinite;
            color: #f39c12;
        }
        .banner-title {
            font-size: 52px;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 0 4px 30px rgba(0,0,0,0.5);
            letter-spacing: -1px;
            line-height: 1.2;
        }
        .banner-subtitle {
            font-size: 22px;
            margin-bottom: 30px;
            opacity: 0.92;
            text-shadow: 0 2px 15px rgba(0,0,0,0.3);
            font-weight: 300;
            line-height: 1.5;
        }
        .banner-btn {
            display: inline-block;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            padding: 16px 50px;
            border-radius: 60px;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 30px rgba(230,126,34,0.4);
            cursor: pointer;
            position: relative;
            z-index: 10;
            border: none;
        }
        .banner-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 45px rgba(230,126,34,0.6);
            background: linear-gradient(135deg, #f1c40f, #e67e22);
        }
        .banner-btn i {
            margin-left: 10px;
            transition: transform 0.3s ease;
        }
        .banner-btn:hover i {
            transform: translateX(8px);
        }
        .banner-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 20;
        }
        .banner-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(255,255,255,0.35);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid rgba(255,255,255,0.15);
            z-index: 20;
        }
        .banner-dot.active {
            background: #f39c12;
            transform: scale(1.3);
            border-color: #f39c12;
            box-shadow: 0 0 20px rgba(243,156,18,0.4);
        }
        .banner-dot:hover {
            background: rgba(255,255,255,0.7);
            transform: scale(1.2);
        }
        .banner-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255,255,255,0.15);
            padding: 18px 22px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 20;
            transition: all 0.3s ease;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 55px;
            min-height: 55px;
        }
        .banner-arrow:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-50%) scale(1.1);
            border-color: rgba(255,255,255,0.4);
        }
        .banner-arrow-left { left: 25px; }
        .banner-arrow-right { right: 25px; }
        .banner-play-toggle {
            position: absolute;
            bottom: 85px;
            right: 30px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255,255,255,0.15);
            padding: 12px 15px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 20;
            transition: all 0.3s ease;
            font-size: 16px;
            min-width: 45px;
            min-height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .banner-play-toggle:hover {
            background: rgba(255,255,255,0.25);
            transform: scale(1.1);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-12px) scale(1.05); }
        }
        
        /* Rest of the page styles */
        .main-container { max-width: 1200px; margin: -40px auto 0; background: white; border-radius: 45px 45px 0 0; padding: 50px; }
        .welcome-section { text-align: center; padding: 45px; background: linear-gradient(135deg, #f8f9fa, #e8f0ff); border-radius: 30px; margin-bottom: 50px; position: relative; overflow: hidden; }
        .welcome-section::before { content: ''; position: absolute; top: -50%; right: -50%; width: 100%; height: 100%; background: radial-gradient(circle, rgba(243,156,18,0.05) 0%, transparent 70%); animation: rotate 20s linear infinite; }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .stats-container { display: flex; justify-content: center; gap: 70px; margin-top: 40px; flex-wrap: wrap; }
        .stat-box { text-align: center; transition: transform 0.3s; }
        .stat-box:hover { transform: translateY(-10px) scale(1.05); }
        .stat-box i { font-size: 55px; color: #e67e22; animation: iconBounce 2s infinite; display: block; }
        @keyframes iconBounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .stat-number { display: block; font-size: 42px; font-weight: 800; color: #1a3a6e; }
        .stat-label { color: #666; font-size: 16px; }
        .section-title { font-size: 34px; margin: 50px 0 30px; color: #1a3a6e; border-left: 7px solid #e67e22; padding-left: 25px; position: relative; }
        .section-title::after { content: ""; position: absolute; bottom: 0; left: 0; width: 0; height: 4px; background: linear-gradient(90deg, #e67e22, transparent); transition: width 0.5s; }
        .section-title:hover::after { width: 100%; }
        .category-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 35px; margin: 40px 0; list-style: none; }
        .category-card { background: white; padding: 40px 25px; text-align: center; border-radius: 25px; border: 2px solid #e8e8e8; transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); cursor: pointer; }
        .category-card:hover { transform: translateY(-15px) scale(1.05); background: linear-gradient(135deg, #1a3a6e, #c0392b); box-shadow: 0 25px 50px rgba(26,58,110,0.3); }
        .category-card i { font-size: 60px; color: #c0392b; display: block; margin-bottom: 20px; transition: all 0.4s; }
        .category-card:hover i { color: white; transform: scale(1.2) rotate(360deg); }
        .category-card a { text-decoration: none; font-size: 20px; font-weight: 700; color: #1a3a6e; }
        .category-card:hover a { color: white; }
        .jobs-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(380px, 1fr)); gap: 35px; margin: 40px 0; }
        .job-card { background: white; border-radius: 25px; padding: 28px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); border: 2px solid #f0f0f0; position: relative; }
        .job-card:hover { transform: translateY(-10px) translateX(5px); box-shadow: 0 25px 50px rgba(0,0,0,0.15); border-left: 5px solid #e67e22; }
        .job-badge { display: inline-block; padding: 6px 15px; border-radius: 30px; font-size: 13px; font-weight: 600; margin-bottom: 18px; }
        .job-badge.urgent { background: #e74c3c; color: white; animation: blink 1s infinite; }
        .job-badge.warning { background: #f39c12; color: white; }
        .job-badge.normal { background: #27ae60; color: white; }
        @keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0.6; transform: scale(1.05); } }
        
        .btn, .btn-apply, .btn-submit, .btn-login, .btn-primary, .btn-secondary, .btn-success, .btn-warning, .btn-info, .btn-danger { cursor: pointer; z-index: 10; position: relative; }
        .btn-apply { display: inline-block; background: linear-gradient(135deg, #1a3a6e, #c0392b); color: white; padding: 12px 30px; border-radius: 40px; text-decoration: none; margin-top: 15px; transition: transform 0.3s; font-weight: 600; }
        .btn-apply:hover { transform: scale(1.08) translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .btn-submit { background: linear-gradient(135deg, #1a3a6e, #c0392b); color: white; padding: 12px 35px; border: none; border-radius: 40px; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
        
        footer { background: linear-gradient(135deg, #1a3a6e, #c0392b); color: white; text-align: center; padding: 50px; margin-top: 70px; }
        
        /* Messages */
        .message-success { background: #d4edda; color: #155724; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; border-left: 5px solid #28a745; }
        .message-error { background: #f8d7da; color: #721c24; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; border-left: 5px solid #dc3545; }
        .message-info { background: #d1ecf1; color: #0c5460; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; border-left: 5px solid #17a2b8; }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .banner-container { height: 450px; }
            .banner-title { font-size: 40px; }
            .banner-subtitle { font-size: 18px; }
            .banner-content { padding: 40px 50px; }
        }
        @media (max-width: 768px) {
            .banner-container { height: 380px; border-radius: 0; }
            .banner-title { font-size: 28px; }
            .banner-subtitle { font-size: 15px; margin-bottom: 20px; }
            .banner-content { padding: 25px 20px; }
            .banner-icon { font-size: 35px; padding: 15px 18px; }
            .banner-btn { padding: 12px 30px; font-size: 14px; }
            .banner-arrow { padding: 12px 15px; font-size: 14px; min-width: 40px; min-height: 40px; }
            .banner-arrow-left { left: 10px; }
            .banner-arrow-right { right: 10px; }
            .banner-dots { bottom: 15px; gap: 10px; }
            .banner-dot { width: 10px; height: 10px; }
            .banner-play-toggle { bottom: 65px; right: 15px; padding: 8px 10px; font-size: 12px; min-width: 35px; min-height: 35px; }
            .jobs-grid { grid-template-columns: 1fr; }
            .category-grid { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); }
            .stats-container { gap: 30px; }
            .header-container { flex-direction: column; text-align: center; gap: 15px; }
            .logo-text { font-size: 32px; }
            .nav-menu > li { padding: 12px 15px; }
            .main-container { padding: 20px; margin: -20px auto 0; border-radius: 25px 25px 0 0; }
        }
        @media (max-width: 480px) {
            .banner-container { height: 320px; }
            .banner-title { font-size: 22px; }
            .banner-subtitle { font-size: 13px; }
            .banner-content { padding: 20px 15px; }
            .banner-btn { padding: 10px 20px; font-size: 12px; }
            .banner-icon { font-size: 28px; padding: 12px 14px; }
            .nav-menu > li { padding: 10px 12px; }
            .nav-menu > li > a { font-size: 14px; }
        }
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <div class="office-hours">
            <h3><i class="fas fa-clock"></i> Office Hours</h3>
            <p>Monday-Friday: 09:00-17:30</p>
            <p>Saturday: 09:00-17:00</p>
            <p>Sunday: Closed</p>
        </div>
        <a href="/" class="logo-link">
            <span class="logo-text">Jo's Jobs</span>
            <span class="logo-icon">&#128188;</span>
        </a>
    </div>
</header>
<nav>
    <ul class="nav-menu">
        <li><a href="/"><i class="fas fa-home"></i> Home</a></li>
        <li class="dropdown">
            <a href="#"><i class="fas fa-briefcase"></i> Jobs &#9660;</a>
            <ul class="dropdown-menu">
                <?php foreach ($navCategories as $cat): ?>
                    <li><a href="/jobs?id=<?php echo (int)$cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li><a href="/about"><i class="fas fa-info-circle"></i> About Us</a></li>
        <li><a href="/careers"><i class="fas fa-graduation-cap"></i> Careers Advice</a></li>
        <li><a href="/contact"><i class="fas fa-envelope"></i> Contact</a></li>
        <li><a href="/alert/subscribe"><i class="fas fa-bell"></i> Job Alerts</a></li>
        <?php 
        // FIX: Use the passed authentication variable
        // In controllers, pass: $auth = $this->authentication;
        $user = (isset($auth) && $auth->isLoggedIn()) ? $auth->getUser() : null;
        ?>
        <?php if ($user): ?>
            <?php if ($user['role'] === 'client'): ?>
                <li><a href="/client/jobs"><i class="fas fa-user-tie"></i> My Jobs</a></li>
            <?php else: ?>
                <li><a href="/admin/jobs"><i class="fas fa-cog"></i> Admin</a></li>
            <?php endif; ?>
            <li><a href="/admin/logout"><i class="fas fa-sign-out-alt"></i> Logout (<?php echo htmlspecialchars($user['name']); ?>)</a></li>
        <?php else: ?>
            <li><a href="/admin/login"><i class="fas fa-lock"></i> Admin Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
<main>
    <?php echo $content; ?>
</main>
<footer>
    <div style="max-width:1200px;margin:0 auto;padding:0 20px;">
        <p>&copy; <?php echo date('Y'); ?> Jo's Jobs - All Rights Reserved</p>
        <p style="font-size:14px;opacity:0.8;margin-top:10px;">
            <i class="fas fa-phone"></i> 01604 123456 &nbsp;|&nbsp;
            <i class="fas fa-envelope"></i> info@josjobs.co.uk
        </p>
    </div>
</footer>

<script>
// ============================================
// ENHANCED BANNER CAROUSEL - IMAGE VERSION
// ============================================

document.addEventListener("DOMContentLoaded", function() {
    var slides = document.querySelectorAll(".banner-slide");
    var dots = document.querySelectorAll(".banner-dot");
    var arrowLeft = document.querySelector(".banner-arrow-left");
    var arrowRight = document.querySelector(".banner-arrow-right");
    var playToggle = document.querySelector(".banner-play-toggle");
    var currentSlide = 0;
    var slideInterval = null;
    var isPlaying = true;
    var autoPlayDelay = 5000;
    
    function showSlide(index) {
        if (index < 0) {
            index = slides.length - 1;
        } else if (index >= slides.length) {
            index = 0;
        }
        
        slides.forEach(function(slide, i) {
            slide.classList.remove("active");
            slide.style.opacity = "0";
            slide.style.transform = "scale(1.02)";
            if (dots[i]) {
                dots[i].classList.remove("active");
            }
        });
        
        slides[index].classList.add("active");
        slides[index].style.opacity = "1";
        slides[index].style.transform = "scale(1)";
        if (dots[index]) {
            dots[index].classList.add("active");
        }
        
        currentSlide = index;
        updatePlayIcon();
    }
    
    function nextSlide() {
        var next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }
    
    function prevSlide() {
        var prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev);
    }
    
    function startAutoPlay() {
        if (slideInterval) {
            clearInterval(slideInterval);
        }
        slideInterval = setInterval(nextSlide, autoPlayDelay);
        isPlaying = true;
        updatePlayIcon();
    }
    
    function stopAutoPlay() {
        if (slideInterval) {
            clearInterval(slideInterval);
            slideInterval = null;
        }
        isPlaying = false;
        updatePlayIcon();
    }
    
    function toggleAutoPlay() {
        if (isPlaying) {
            stopAutoPlay();
        } else {
            startAutoPlay();
        }
    }
    
    function updatePlayIcon() {
        if (playToggle) {
            var icon = playToggle.querySelector("i");
            if (icon) {
                if (isPlaying) {
                    icon.className = "fas fa-pause";
                } else {
                    icon.className = "fas fa-play";
                }
            }
        }
    }
    
    if (slides.length > 0) {
        showSlide(0);
        startAutoPlay();
    }
    
    dots.forEach(function(dot, index) {
        dot.addEventListener("click", function() {
            stopAutoPlay();
            showSlide(index);
            setTimeout(startAutoPlay, 5000);
        });
    });
    
    if (arrowLeft) {
        arrowLeft.addEventListener("click", function() {
            stopAutoPlay();
            prevSlide();
            setTimeout(startAutoPlay, 5000);
        });
    }
    
    if (arrowRight) {
        arrowRight.addEventListener("click", function() {
            stopAutoPlay();
            nextSlide();
            setTimeout(startAutoPlay, 5000);
        });
    }
    
    if (playToggle) {
        playToggle.addEventListener("click", function() {
            toggleAutoPlay();
        });
    }
    
    var container = document.querySelector(".banner-container");
    if (container) {
        container.addEventListener("mouseenter", function() {
            if (isPlaying) {
                stopAutoPlay();
            }
        });
        container.addEventListener("mouseleave", function() {
            if (!isPlaying) {
                startAutoPlay();
            }
        });
    }
    
    // Keyboard navigation
    document.addEventListener("keydown", function(e) {
        if (e.key === "ArrowRight") {
            e.preventDefault();
            stopAutoPlay();
            nextSlide();
            setTimeout(startAutoPlay, 5000);
        } else if (e.key === "ArrowLeft") {
            e.preventDefault();
            stopAutoPlay();
            prevSlide();
            setTimeout(startAutoPlay, 5000);
        } else if (e.key === " " || e.key === "Space") {
            e.preventDefault();
            toggleAutoPlay();
        }
    });
    
    // Touch support for mobile
    var touchStartX = 0;
    var touchEndX = 0;
    var touchStartY = 0;
    var touchEndY = 0;
    
    if (container) {
        container.addEventListener("touchstart", function(e) {
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
        }, { passive: true });
        
        container.addEventListener("touchend", function(e) {
            touchEndX = e.changedTouches[0].screenX;
            touchEndY = e.changedTouches[0].screenY;
            var diffX = touchStartX - touchEndX;
            var diffY = touchStartY - touchEndY;
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 30) {
                stopAutoPlay();
                if (diffX > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
                setTimeout(startAutoPlay, 5000);
            }
        }, { passive: true });
    }
});
</script>
</body>
</html>