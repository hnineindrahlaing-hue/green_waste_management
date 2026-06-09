<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

$schedules = get_all_schedules($link);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Waste Collection Schedules</h2>
            <p class="text-muted">View collection schedules for your zone.</p>
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
                                    <th>Zone</th>
                                    <th>Collection Date</th>
                                    <th>Collection Time</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($schedules) > 0): ?>
                                    <?php foreach ($schedules as $schedule): ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($schedule['zone']); ?></strong></td>
                                            <td><?php echo date('M d, Y', strtotime($schedule['collection_date'])); ?></td>
                                            <td><?php echo date('h:i A', strtotime($schedule['collection_time'])); ?></td>
                                            <td><?php echo htmlspecialchars($schedule['description'] ?? 'N/A'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No schedules available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                <strong>💡 Tip:</strong> Mark your calendar with these collection dates to ensure your waste is ready for pickup!
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
