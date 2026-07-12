<div class="success-container">
    <div class="success-box">
        <i class="fas fa-check-circle" style="font-size: 80px; color: #27ae60;"></i>
        <h2>Application Submitted Successfully!</h2>
        <p>Thank you for applying for the position of <strong><?php echo htmlspecialchars($job['title']); ?></strong></p>
        <p>We will contact you after the closing date.</p>
        <a href="/jobs?id=<?php echo $job['categoryId']; ?>" class="btn-back">Browse More Jobs</a>
    </div>
</div>

<style>
.success-container { max-width: 600px; margin: 50px auto; text-align: center; }
.success-box { background: white; padding: 50px; border-radius: 20px; box-shadow: 0 5px 30px rgba(0,0,0,0.1); }
.success-box h2 { color: #1a3a6e; margin: 20px 0; }
.btn-back { display: inline-block; background: #1a3a6e; color: white; padding: 12px 30px; border-radius: 30px; text-decoration: none; margin-top: 20px; cursor: pointer; }
.btn-back:hover { transform: scale(1.05); }
</style>