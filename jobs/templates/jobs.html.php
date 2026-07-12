<div class="jobs-container">
    <h2><?php echo htmlspecialchars($title); ?></h2>
    
    <div class="search-section">
        <form method="GET" action="/jobs">
            <input type="hidden" name="id" value="<?php echo $categoryId; ?>">
            <div class="search-row">
                <input type="text" name="title" placeholder="Search by job title..." value="<?php echo htmlspecialchars($searchTitle ?? ''); ?>">
                <input type="text" name="location" placeholder="Search by location..." value="<?php echo htmlspecialchars($searchLocation ?? ''); ?>">
            </div>
            <div class="search-row">
                <input type="number" name="min_salary" placeholder="Min Salary" value="<?php echo htmlspecialchars($minSalary ?? ''); ?>">
                <input type="number" name="max_salary" placeholder="Max Salary" value="<?php echo htmlspecialchars($maxSalary ?? ''); ?>">
                <select name="sort">
                    <option value="dateReceived" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'dateReceived' ? 'selected' : ''; ?>>Latest First</option>
                    <option value="closingDate" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'closingDate' ? 'selected' : ''; ?>>Closing Date</option>
                    <option value="title" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'title' ? 'selected' : ''; ?>>Title</option>
                    <option value="salary" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'salary' ? 'selected' : ''; ?>>Salary</option>
                </select>
                <select name="dir">
                    <option value="desc" <?php echo isset($_GET['dir']) && $_GET['dir'] === 'desc' ? 'selected' : ''; ?>>Descending</option>
                    <option value="asc" <?php echo isset($_GET['dir']) && $_GET['dir'] === 'asc' ? 'selected' : ''; ?>>Ascending</option>
                </select>
            </div>
            <div class="search-row">
                <label><input type="checkbox" name="show_archived" value="1" <?php echo isset($_GET['show_archived']) ? 'checked' : ''; ?>> Show archived jobs</label>
                <button type="submit" class="btn-search"><i class="fas fa-search"></i> Search</button>
                <a href="/jobs?id=<?php echo $categoryId; ?>" class="btn-clear">Clear</a>
            </div>
        </form>
    </div>
    
    <div class="quick-links">
        <a href="/alert/subscribe" class="btn-alert"><i class="fas fa-bell"></i> Job Alerts</a>
        <a href="/jobs/saved" class="btn-saved-link"><i class="fas fa-bookmark"></i> Saved Jobs</a>
    </div>
    
    <?php if (empty($jobs)): ?>
        <p class="no-jobs">No jobs found matching your criteria.</p>
    <?php else: ?>
        <div class="jobs-grid">
            <?php foreach ($jobs as $job): ?>
                <div class="job-card">
                    <?php 
                        $daysToClose = (strtotime($job['closingDate']) - time()) / 86400;
                        if ($daysToClose <= 3 && $daysToClose > 0): 
                    ?>
                        <div class="job-badge urgent">Closing Soon!</div>
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                    <div class="job-salary"><i class="fas fa-pound-sign"></i> <?php echo htmlspecialchars($job['salary']); ?></div>
                    <div class="job-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($job['location']); ?></div>
                    <div class="job-closing"><i class="fas fa-calendar-alt"></i> Closes: <?php echo date('d M Y', strtotime($job['closingDate'])); ?></div>
                    <p><?php echo substr(htmlspecialchars($job['description']), 0, 150); ?>...</p>
                    <div class="job-actions">
                        <a href="/apply?id=<?php echo (int)$job['id']; ?>" class="btn-apply">Apply Now</a>
                        <form method="POST" action="/jobs/save" style="display:inline;">
                            <input type="hidden" name="jobId" value="<?php echo $job['id']; ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['user']['email'] ?? ''); ?>">
                            <button type="submit" class="btn-save <?php echo in_array($job['id'], $savedJobIds) ? 'btn-saved' : ''; ?>">
                                <i class="fas fa-<?php echo in_array($job['id'], $savedJobIds) ? 'check' : 'bookmark'; ?>"></i>
                                <?php echo in_array($job['id'], $savedJobIds) ? 'Saved' : 'Save'; ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.jobs-container { max-width: 1200px; margin: 0 auto; padding: 30px; }
.search-section { background: #f5f5f5; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
.search-row { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 10px; align-items: center; }
.search-row input, .search-row select { flex: 1; min-width: 150px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
.search-row label { display: flex; align-items: center; gap: 5px; cursor: pointer; }
.btn-search { background: #1a3a6e; color: white; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer; }
.btn-clear { background: #95a5a6; color: white; padding: 10px 25px; border-radius: 5px; text-decoration: none; }
.quick-links { display: flex; gap: 15px; margin-bottom: 20px; }
.btn-alert, .btn-saved-link { padding: 10px 20px; border-radius: 30px; text-decoration: none; display: inline-block; }
.btn-alert { background: #e67e22; color: white; }
.btn-saved-link { background: #1a3a6e; color: white; }
.job-actions { display: flex; gap: 10px; align-items: center; margin-top: 15px; flex-wrap: wrap; }
.no-jobs { text-align: center; padding: 50px; color: #666; font-size: 18px; }
</style>