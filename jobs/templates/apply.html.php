<div class="apply-container">
    <h2>Apply for: <?php echo htmlspecialchars($job['title']); ?></h2>
    <div class="job-summary">
        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
        <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
        <p><strong>Closing Date:</strong> <?php echo date('d M Y', strtotime($job['closingDate'])); ?></p>
    </div>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="/apply" enctype="multipart/form-data" class="apply-form">
        <input type="hidden" name="jobId" value="<?php echo $job['id']; ?>">
        
        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="details">Cover Letter *</label>
            <textarea id="details" name="details" rows="6" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="cv">Upload CV (PDF, DOC, DOCX) *</label>
            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
        </div>
        
        <button type="submit" class="btn-submit">Submit Application</button>
    </form>
</div>

<style>
.apply-container { max-width: 800px; margin: 0 auto; padding: 30px; }
.job-summary { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 30px; }
.apply-form { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-weight: 600; margin-bottom: 5px; }
.form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
.btn-submit { background: linear-gradient(135deg, #1a3a6e, #c0392b); color: white; padding: 15px 40px; border: none; border-radius: 30px; font-size: 16px; cursor: pointer; z-index: 10; position: relative; }
.btn-submit:hover { transform: scale(1.05); }
.alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>