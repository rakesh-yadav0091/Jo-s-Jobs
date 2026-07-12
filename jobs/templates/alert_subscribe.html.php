<div class="alert-container">
    <h2>Job Alerts</h2>
    <p>Subscribe to receive email notifications when new jobs matching your criteria are posted.</p>
    
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="alert-form-wrapper">
        <form method="POST" action="/alert/subscribe" class="alert-form">
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" required placeholder="your@email.com">
            </div>
            
            <div class="form-group">
                <label for="categoryId">Category (Optional)</label>
                <select id="categoryId" name="categoryId">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="keywords">Keywords (Optional)</label>
                    <input type="text" id="keywords" name="keywords" placeholder="e.g. manager, developer">
                </div>
                <div class="form-group">
                    <label for="location">Location (Optional)</label>
                    <input type="text" id="location" name="location" placeholder="e.g. Northampton">
                </div>
            </div>
            
            <div class="form-group">
                <label for="frequency">Frequency</label>
                <select id="frequency" name="frequency">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                </select>
            </div>
            
            <button type="submit" class="btn-subscribe">Subscribe to Alerts</button>
        </form>
    </div>
    
    <div class="alert-info">
        <p><i class="fas fa-info-circle"></i> You can unsubscribe at any time by clicking the link in the email.</p>
    </div>
</div>

<style>
.alert-container { max-width: 700px; margin: 0 auto; padding: 30px; }
.alert-form-wrapper { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 20px; }
.alert-form .form-group { margin-bottom: 20px; }
.alert-form .form-group label { display: block; font-weight: 600; margin-bottom: 5px; }
.alert-form .form-group input, .alert-form .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
.alert-form .form-row { display: flex; gap: 20px; flex-wrap: wrap; }
.alert-form .form-row .form-group { flex: 1; min-width: 150px; }
.btn-subscribe { background: linear-gradient(135deg, #1a3a6e, #c0392b); color: white; padding: 15px 40px; border: none; border-radius: 30px; font-size: 16px; cursor: pointer; width: 100%; }
.btn-subscribe:hover { transform: scale(1.02); }
.alert-info { margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 10px; text-align: center; color: #666; }
.alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>