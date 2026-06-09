<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_admin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zone = sanitize_input($_POST['zone']);
    $collection_date = sanitize_input($_POST['collection_date']);
    $collection_time = sanitize_input($_POST['collection_time']);
    $description = sanitize_input($_POST['description']);
    
    if (empty($zone) || empty($collection_date) || empty($collection_time)) {
        $error = 'Zone, date, and time are required.';
    } else {
        $sql = "INSERT INTO schedules (zone, collection_date, collection_time, description) VALUES (?, ?, ?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ssss", $zone, $collection_date, $collection_time, $description);
        
        if ($stmt->execute()) {
            $success = 'Schedule added successfully!';
        } else {
            $error = 'Failed to add schedule.';
        }
    }
}

$schedules = get_all_schedules($link);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Manage Schedules</h2>
            <p class="text-muted">Create and manage waste collection schedules.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Add New Schedule</h5>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="zone" class="form-label">Zone *</label>
                            <input type="text" class="form-control" id="zone" name="zone" required>
                        </div>
                        <div class="mb-3">
                            <label for="collection_date" class="form-label">Collection Date *</label>
                            <input type="date" class="form-control" id="collection_date" name="collection_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="collection_time" class="form-label">Collection Time *</label>
                            <input type="time" class="form-control" id="collection_time" name="collection_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Add Schedule</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Existing Schedules</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Zone</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($schedules, 0, 10) as $schedule): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($schedule['zone']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($schedule['collection_date'])); ?></td>
                                        <td><?php echo date('h:i A', strtotime($schedule['collection_time'])); ?></td>
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
