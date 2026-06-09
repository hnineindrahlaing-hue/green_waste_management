<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

$user_reports = get_user_reports($_SESSION['user_id'], $link);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>My Reports</h2>
            <p class="text-muted">View all your submitted waste reports.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($user_reports) > 0): ?>
                                    <?php foreach ($user_reports as $report): ?>
                                        <tr>
                                            <td><strong><?php echo ucfirst($report['report_type']); ?></strong></td>
                                            <td><?php echo substr(htmlspecialchars($report['description']), 0, 50); ?>...</td>
                                            <td>
                                                <span class="badge bg-<?php echo $report['status'] === 'resolved' ? 'success' : ($report['status'] === 'in progress' ? 'warning' : 'secondary'); ?>">
                                                    <?php echo ucfirst($report['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($report['reported_at'])); ?></td>
                                            <td>
                                                <a href="view_report_detail.php?id=<?php echo $report['report_id']; ?>" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No reports yet. <a href="report_waste.php">Create one</a></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
