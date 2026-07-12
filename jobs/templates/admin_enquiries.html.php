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
                <th>Name</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Enquiry</th>
                <th>Date</th>
                <th>Status</th>
                <th>Completed By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($enquiries)): ?>
                <tr><td colspan="9">No enquiries found</td></tr>
            <?php else: ?>
                <?php foreach ($enquiries as $enquiry): ?>
                <tr>
                    <td><?php echo $enquiry['id']; ?></td>
                    <td><?php echo htmlspecialchars($enquiry['firstName'] . ' ' . $enquiry['surname']); ?></td>
                    <td><?php echo htmlspecialchars($enquiry['email']); ?></td>
                    <td><?php echo htmlspecialchars($enquiry['telephone'] ?? 'N/A'); ?></td>
                    <td><?php echo substr(htmlspecialchars($enquiry['enquiry']), 0, 50) . '...'; ?></td>
                    <td><?php echo date('d M Y H:i', strtotime($enquiry['createdAt'])); ?></td>
                    <td>
                        <span class="badge <?php echo $enquiry['status'] === 'Open' ? 'badge-active' : 'badge-archived'; ?>">
                            <?php echo $enquiry['status']; ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($enquiry['staff_name'] ?? 'Not assigned'); ?></td>
                    <td>
                        <?php if ($enquiry['status'] === 'Open'): ?>
                            <form method="POST" action="/admin/enquiries/complete" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $enquiry['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-success">Mark Complete</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">✓ Completed</span>
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
.admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.admin-table th { background: #1a3a6e; color: white; padding: 12px; text-align: left; }
.admin-table td { padding: 10px; border-bottom: 1px solid #eee; }
.admin-table tr:hover { background: #f8f9fa; }
.badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; }
.badge-active { background: #27ae60; color: white; }
.badge-archived { background: #95a5a6; color: white; }
.btn { padding: 6px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 13px; z-index: 10; position: relative; }
.btn-sm { padding: 4px 10px; font-size: 12px; }
.btn-success { background: #27ae60; color: white; }
.alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.text-muted { color: #6c757d; font-style: italic; }
</style>