<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_admin();

$reports = get_all_reports($link);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Manage Reports</h2>
            <p class="text-muted">View and respond to waste issue reports.</p>
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
                                    <th>ID</th>
                                    <th>Reporter</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reports as $report): ?>
                                    <tr>
                                        <td><?php echo $report['report_id']; ?></td>
                                        <td><?php echo htmlspecialchars($report['username'] ?? 'Anonymous'); ?></td>
                                        <td><?php echo ucfirst($report['report_type']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $report['status'] === 'resolved' ? 'success' : ($report['status'] === 'in progress' ? 'warning' : 'secondary'); ?>">
                                                <?php echo ucfirst($report['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($report['reported_at'])); ?></td>
                                        <td>
                                            <a href="view_report.php?id=<?php echo $report['report_id']; ?>" class="btn btn-sm btn-info">View</a>
                                            <a href="update_report_status.php?id=<?php echo $report['report_id']; ?>&status=in progress" class="btn btn-sm btn-warning">In Progress</a>
                                            <a href="update_report_status.php?id=<?php echo $report['report_id']; ?>&status=resolved" class="btn btn-sm btn-success">Resolve</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
