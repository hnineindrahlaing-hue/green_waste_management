<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

if (!isset($_GET['id'])) {
    header("Location: view_reports.php");
    exit;
}

$report_id = intval($_GET['id']);
$sql = "SELECT * FROM reports WHERE report_id = ? AND user_id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("ii", $report_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: view_reports.php");
    exit;
}

$report = $result->fetch_assoc();
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Report Details</h2>
            <a href="view_reports.php" class="btn btn-secondary mb-3">← Back to Reports</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Report Type</h6>
                            <p><strong><?php echo ucfirst($report['report_type']); ?></strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <p>
                                <span class="badge bg-<?php echo $report['status'] === 'resolved' ? 'success' : ($report['status'] === 'in progress' ? 'warning' : 'secondary'); ?>">
                                    <?php echo ucfirst($report['status']); ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Reported Date</h6>
                            <p><?php echo date('M d, Y h:i A', strtotime($report['reported_at'])); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Location</h6>
                            <p><?php echo $report['latitude'] . ', ' . $report['longitude']; ?></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted">Description</h6>
                        <p><?php echo htmlspecialchars($report['description']); ?></p>
                    </div>

                    <?php if ($report['image_url']): ?>
                        <div class="mb-4">
                            <h6 class="text-muted">Attached Image</h6>
                            <img src="<?php echo htmlspecialchars($report['image_url']); ?>" alt="Report Image" class="img-fluid" style="max-width: 100%; height: auto; border-radius: 5px;">
                        </div>
                    <?php endif; ?>

                    <?php if ($report['resolved_at']): ?>
                        <div class="alert alert-success">
                            <strong>Resolved on:</strong> <?php echo date('M d, Y h:i A', strtotime($report['resolved_at'])); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
