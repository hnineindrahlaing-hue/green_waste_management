<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_admin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $truck_name = sanitize_input($_POST['truck_name']);
    $license_plate = sanitize_input($_POST['license_plate']);
    $latitude = sanitize_input($_POST['latitude']);
    $longitude = sanitize_input($_POST['longitude']);
    $status = sanitize_input($_POST['status']);
    
    if (empty($truck_name) || empty($license_plate)) {
        $error = 'Truck name and license plate are required.';
    } else {
        $sql = "INSERT INTO trucks (truck_name, license_plate, current_latitude, current_longitude, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ssdds", $truck_name, $license_plate, $latitude, $longitude, $status);
        
        if ($stmt->execute()) {
            $success = 'Truck added successfully!';
        } else {
            $error = 'Failed to add truck.';
        }
    }
}

$trucks = $link->query("SELECT * FROM trucks ORDER BY truck_name")->fetch_all(MYSQLI_ASSOC);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Manage Trucks</h2>
            <p class="text-muted">Add and manage garbage trucks.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Add New Truck</h5>
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
                            <label for="truck_name" class="form-label">Truck Name *</label>
                            <input type="text" class="form-control" id="truck_name" name="truck_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="license_plate" class="form-label">License Plate *</label>
                            <input type="text" class="form-control" id="license_plate" name="license_plate" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="number" step="0.0001" class="form-control" id="latitude" name="latitude" value="16.8661">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="number" step="0.0001" class="form-control" id="longitude" name="longitude" value="96.1951">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="inactive">Inactive</option>
                                <option value="active">Active</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Add Truck</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Existing Trucks</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>License Plate</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trucks as $truck): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($truck['truck_name']); ?></td>
                                        <td><?php echo htmlspecialchars($truck['license_plate']); ?></td>
                                        <td><span class="badge bg-<?php echo $truck['status'] === 'active' ? 'success' : 'secondary'; ?>"><?php echo ucfirst($truck['status']); ?></span></td>
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
