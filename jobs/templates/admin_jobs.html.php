<div class="admin-container">
    <h2><?php echo htmlspecialchars($title); ?></h2>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <div class="filter-section">
        <form method="GET" action="/admin/jobs">
            <select name="category">
                <option value="0">All Categories</option>
                <?php foreach ($allCategories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo isset($_GET['category']) && $_GET['category'] == $cat['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <select name="sort">
                <option value="dateReceived" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'dateReceived' ? 'selected' : ''; ?>>Date Received</option>
                <option value="closingDate" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'closingDate' ? 'selected' : ''; ?>>Closing Date</option>
                <option value="title" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'title' ? 'selected' : ''; ?>>Title</option>
            </select>
            
            <select name="dir">
                <option value="desc" <?php echo isset($_GET['dir']) && $_GET['dir'] === 'desc' ? 'selected' : ''; ?>>Latest First</option>
                <option value="asc" <?php echo isset($_GET['dir']) && $_GET['dir'] === 'asc' ? 'selected' : ''; ?>>Oldest First</option>
            </select>
            
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="/admin/jobs" class="btn btn-secondary">Clear</a>
        </form>
    </div>
    
    <?php if (isset($isClient) && $isClient): ?>
    <div class="add-job-section">
        <h3>Post a New Job</h3>
        <form method="POST" action="/client/jobs/add">
            <!-- CSRF Protection -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
            <div class="form-row">
                <input type="text" name="title" placeholder="Job Title" required>
                <input type="text" name="location" placeholder="Location" required>
            </div>
            <div class="form-row">
                <input type="text" name="salary" placeholder="Salary (e.g. £25,000 - £30,000)" required>
                <input type="date" name="closingDate" required>
            </div>
            <div class="form-row">
                <select name="categoryId" required>
                    <option value="">Select Category</option>
                    <?php foreach ($allCategories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-row">
                <textarea name="description" placeholder="Job Description" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Post Job</button>
        </form>
    </div>
    <?php endif; ?>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Location</th>
                <th>Date Received</th>
                <th>Closing Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($jobs)): ?>
                <tr><td colspan="8">No jobs found</td></tr>
            <?php else: ?>
                <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?php echo $job['id']; ?></td>
                    <td><?php echo htmlspecialchars($job['title']); ?></td>
                    <td><?php echo htmlspecialchars($job['category_name'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                    <td><?php echo date('d M Y', strtotime($job['dateReceived'])); ?></td>
                    <td><?php echo date('d M Y', strtotime($job['closingDate'])); ?></td>
                    <td>
                        <?php if ($job['archived']): ?>
                            <span class="badge badge-archived">Archived</span>
                        <?php elseif (strtotime($job['closingDate']) < time()): ?>
                            <span class="badge badge-expired">Expired</span>
                        <?php else: ?>
                            <span class="badge badge-active">Active</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($job['archived']): ?>
                            <form method="POST" action="/admin/jobs/unarchive" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                                <button type="submit" class="btn btn-sm btn-warning">Unarchive</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="/admin/jobs/archive" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                                <button type="submit" class="btn btn-sm btn-secondary">Archive</button>
                            </form>
                        <?php endif; ?>
                        <a href="/apply?id=<?php echo $job['id']; ?>" class="btn btn-sm btn-info" target="_blank">View</a>
                        <?php if (isset($isClient) && $isClient): ?>
                            <a href="/client/applicants?jobId=<?php echo $job['id']; ?>" class="btn btn-sm btn-primary">View Applicants</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
.admin-container { padding: 30px; max-width: 1400px; margin: 0 auto; }
.filter-section { background: #f5f5f5; padding: 20px; border-radius: 10px; margin-bottom: 30px; }
.filter-section form { display: flex; gap: 15px; flex-wrap: wrap; align-items: center; }
.filter-section select, .filter-section input { padding: 8px 15px; border: 1px solid #ddd; border-radius: 5px; min-width: 150px; }
.admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.admin-table th { background: #1a3a6e; color: white; padding: 12px; text-align: left; }
.admin-table td { padding: 10px; border-bottom: 1px solid #eee; }
.admin-table tr:hover { background: #f8f9fa; }
.badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; }
.badge-active { background: #27ae60; color: white; }
.badge-archived { background: #95a5a6; color: white; }
.badge-expired { background: #e74c3c; color: white; }
.btn { padding: 6px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 13px; z-index: 10; position: relative; }
.btn-sm { padding: 4px 10px; font-size: 12px; }
.btn-primary { background: #1a3a6e; color: white; }
.btn-secondary { background: #95a5a6; color: white; }
.btn-success { background: #27ae60; color: white; }
.btn-warning { background: #f39c12; color: white; }
.btn-info { background: #3498db; color: white; }
.alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.add-job-section { background: #f8f9fa; padding: 25px; border-radius: 10px; margin-bottom: 30px; border: 2px dashed #1a3a6e; }
.form-row { margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; }
.form-row input, .form-row select, .form-row textarea { flex: 1; min-width: 200px; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; }
</style>