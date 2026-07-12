<div class="admin-container">
    <h2><?php echo htmlspecialchars($title); ?></h2>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <div class="add-user-section">
        <h3>Add New User</h3>
        <form method="POST" action="/admin/users/add">
            <div class="form-row">
                <input type="text" name="username" placeholder="Username" required>
                <input type="text" name="name" placeholder="Full Name" required>
            </div>
            <div class="form-row">
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="staff">Staff</option>
                    <option value="client">Client</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add User</button>
        </form>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><span class="badge <?php echo $user['role'] === 'staff' ? 'badge-active' : 'badge-warning'; ?>"><?php echo ucfirst($user['role']); ?></span></td>
                <td>
                    <span class="badge <?php echo $user['active'] ? 'badge-active' : 'badge-archived'; ?>">
                        <?php echo $user['active'] ? 'Active' : 'Inactive'; ?>
                    </span>
                </td>
                <td>
                    <?php if ($user['active']): ?>
                        <form method="POST" action="/admin/users/delete" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Deactivate</button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">Inactive</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.admin-container { padding: 30px; max-width: 1400px; margin: 0 auto; }
.add-user-section { background: #f8f9fa; padding: 25px; border-radius: 10px; margin-bottom: 30px; border: 2px dashed #1a3a6e; }
.form-row { margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; }
.form-row input, .form-row select { flex: 1; min-width: 150px; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; }
.admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.admin-table th { background: #1a3a6e; color: white; padding: 12px; text-align: left; }
.admin-table td { padding: 10px; border-bottom: 1px solid #eee; }
.admin-table tr:hover { background: #f8f9fa; }
.badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; }
.badge-active { background: #27ae60; color: white; }
.badge-archived { background: #95a5a6; color: white; }
.badge-warning { background: #f39c12; color: white; }
.btn { padding: 6px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 13px; z-index: 10; position: relative; }
.btn-sm { padding: 4px 10px; font-size: 12px; }
.btn-success { background: #27ae60; color: white; }
.btn-danger { background: #e74c3c; color: white; }
.alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.text-muted { color: #6c757d; font-style: italic; }
</style>