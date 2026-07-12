<div class="admin-container">
    <h2><?php echo htmlspecialchars($title); ?></h2>
    
    <div class="back-link">
        <a href="/client/jobs">&larr; Back to My Jobs</a>
    </div>
    
    <?php if (empty($applicants)): ?>
        <p class="no-applicants">No applicants have applied for this job yet.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Cover Letter</th>
                    <th>CV</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applicants as $applicant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($applicant['name']); ?></td>
                    <td><a href="mailto:<?php echo htmlspecialchars($applicant['email']); ?>"><?php echo htmlspecialchars($applicant['email']); ?></a></td>
                    <td><?php echo nl2br(htmlspecialchars(substr($applicant['details'], 0, 100))); ?>...</td>
                    <td>
                        <?php if ($applicant['cv']): ?>
                            <a href="/cvs/<?php echo htmlspecialchars($applicant['cv']); ?>" target="_blank" class="btn btn-sm btn-info">Download CV</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.admin-container { padding: 30px; max-width: 1400px; margin: 0 auto; }
.back-link { margin: 20px 0; }
.back-link a { color: #1a3a6e; text-decoration: none; font-weight: 600; }
.no-applicants { text-align: center; padding: 50px; color: #666; font-size: 18px; }
.admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.admin-table th { background: #1a3a6e; color: white; padding: 12px; text-align: left; }
.admin-table td { padding: 10px; border-bottom: 1px solid #eee; }
.admin-table tr:hover { background: #f8f9fa; }
.btn { padding: 6px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 13px; z-index: 10; position: relative; }
.btn-sm { padding: 4px 10px; font-size: 12px; }
.btn-info { background: #3498db; color: white; }
</style>