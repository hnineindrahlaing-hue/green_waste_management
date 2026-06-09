<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_type = sanitize_input($_POST['report_type']);
    $description = sanitize_input($_POST['description']);
    $latitude = sanitize_input($_POST['latitude']);
    $longitude = sanitize_input($_POST['longitude']);
    
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_url = upload_file($_FILES['image'], '../uploads/report_images/');
    }
    
    if (empty($report_type) || empty($latitude) || empty($longitude)) {
        $error = 'Report type, latitude, and longitude are required.';
    } else {
        if (create_report($_SESSION['user_id'], $report_type, $description, $latitude, $longitude, $image_url, $link)) {
            $success = 'Report submitted successfully!';
        } else {
            $error = 'Failed to submit report. Please try again.';
        }
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Report Waste Issue</h2>
            <p class="text-muted">Help us keep the city clean by reporting waste-related issues.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="report_type" class="form-label">Report Type *</label>
                            <select class="form-control" id="report_type" name="report_type" required>
                                <option value="">Select a type</option>
                                <option value="overflowing bin">Overflowing Bin</option>
                                <option value="illegal dumping">Illegal Dumping</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the issue in detail..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude *</label>
                                <input type="number" step="0.0001" class="form-control" id="latitude" name="latitude" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude *</label>
                                <input type="number" step="0.0001" class="form-control" id="longitude" name="longitude" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">Max file size: 5MB</small>
                        </div>
                        
                        <div class="mb-3">
                            <button type="button" class="btn btn-info" onclick="getLocation()">📍 Get Current Location</button>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Submit Report</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                alert('Location captured: ' + position.coords.latitude + ', ' + position.coords.longitude);
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    }
</script>

<?php include '../includes/footer.php'; ?>
