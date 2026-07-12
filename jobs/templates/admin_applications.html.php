<div class="admin-container">
    <h2><?php echo htmlspecialchars($title); ?></h2>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Applicant</th>
                <th>Email</th>
                <th>Job Title</th>
                <th>Status</th>
                <th>Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($applications)): ?>
                <tr><td colspan="7">No applications found</td></tr>
            <?php else: ?>
                <?php foreach ($applications as $app): ?>
                <tr>
                    <td><?php echo $app['id']; ?></td>
                    <td><?php echo htmlspecialchars($app['name']); ?></td>
                    <td><?php echo htmlspecialchars($app['email']); ?></td>
                    <td><?php echo htmlspecialchars($app['job_title']); ?></td>
                    <td>
                        <span class="badge <?php echo $app['status'] === 'received' ? 'badge-active' : 'badge-warning'; ?>">
                            <?php echo htmlspecialchars($app['status'] ?? 'received'); ?>
                        </span>
                    </td>
                    <td><?php echo $app['updatedAt'] ? date('d M Y', strtotime($app['updatedAt'])) : 'N/A'; ?></td>
                    <td>
                        <form method="POST" action="/admin/applications/update" style="display:inline;">
                            <input type="hidden" name="applicantId" value="<?php echo $app['id']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="received" <?php echo ($app['status'] ?? 'received') === 'received' ? 'selected' : ''; ?>>Received</option>
                                <option value="reviewing" <?php echo ($app['status'] ?? '') === 'reviewing' ? 'selected' : ''; ?>>Reviewing</option>
                                <option value="shortlisted" <?php echo ($app['status'] ?? '') === 'shortlisted' ? 'selected' : ''; ?>>Shortlisted</option>
                                <option value="interviewed" <?php echo ($app['status'] ?? '') === 'interviewed' ? 'selected' : ''; ?>>Interviewed</option>
                                <option value="offered" <?php echo ($app['status'] ?? '') === 'offered' ? 'selected' : ''; ?>>Offered</option>
                                <option value="accepted" <?php echo ($app['status'] ?? '') === 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                                <option value="rejected" <?php echo ($app['status'] ?? '') === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                <option value="closed" <?php echo ($app['status'] ?? '') === 'closed' ? 'selected' : ''; ?>>Closed</option>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
.admin-container { padding: 30px; max-width: 1400px; margin: 0 auto; }
.admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.admin-table th { background: #1a3a6e; color: white; padding: 12px; text-align: left; }
.admin-table td { padding: 10px; border-bottom: 1px solid #eee; }
.admin-table tr:hover { background: #f8f9fa; }
.badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; }
.badge-active { background: #27ae60; color: white; }
.badge-warning { background: #f39c12; color: white; }
.alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>