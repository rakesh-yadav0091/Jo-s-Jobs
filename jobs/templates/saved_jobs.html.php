<div class="saved-container">
    <h2>Saved Jobs</h2>
    <p>Jobs you have saved for later viewing.</p>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (empty($savedJobs)): ?>
        <p class="no-saved">You have no saved jobs. <a href="/jobs?id=1">Browse jobs</a> to save them.</p>
    <?php else: ?>
        <div class="jobs-grid">
            <?php foreach ($savedJobs as $job): ?>
                <div class="job-card">
                    <div class="saved-date">Saved on: <?php echo date('d M Y', strtotime($job['savedAt'])); ?></div>
                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                    <div class="job-salary"><i class="fas fa-pound-sign"></i> <?php echo htmlspecialchars($job['salary']); ?></div>
                    <div class="job-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($job['location']); ?></div>
                    <p><?php echo substr(htmlspecialchars($job['description']), 0, 120); ?>...</p>
                    <div class="job-actions">
                        <a href="/apply?id=<?php echo (int)$job['id']; ?>" class="btn-apply">Apply Now</a>
                        <form method="POST" action="/jobs/save" style="display:inline;">
                            <input type="hidden" name="jobId" value="<?php echo $job['id']; ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
                            <button type="submit" class="btn-save btn-saved">
                                <i class="fas fa-check"></i> Saved
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.saved-container { max-width: 1200px; margin: 0 auto; padding: 30px; }
.saved-date { font-size: 12px; color: #999; margin-bottom: 10px; }
.no-saved { text-align: center; padding: 50px; color: #666; font-size: 18px; }
.no-saved a { color: #1a3a6e; font-weight: 600; }
</style>