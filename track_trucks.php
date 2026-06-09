<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

$trucks = get_active_trucks($link);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Real-Time Truck Tracking</h2>
            <p class="text-muted">Monitor garbage truck locations in real-time.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body p-0">
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Active Trucks</h5>
                </div>
                <div class="card-body">
                    <?php if (count($trucks) > 0): ?>
                        <div class="list-group">
                            <?php foreach ($trucks as $truck): ?>
                                <a href="#" class="list-group-item list-group-item-action" onclick="focusMarker(<?php echo $truck['current_latitude']; ?>, <?php echo $truck['current_longitude']; ?>)">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">🚚 <?php echo htmlspecialchars($truck['truck_name']); ?></h6>
                                    </div>
                                    <p class="mb-1 text-muted small"><?php echo htmlspecialchars($truck['license_plate']); ?></p>
                                    <small class="text-success">Active</small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No active trucks at the moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize map
    var map = L.map('map').setView([16.8661, 96.1951], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Add truck markers
    var markers = [];
    <?php foreach ($trucks as $truck): ?>
        var marker = L.marker([<?php echo $truck['current_latitude']; ?>, <?php echo $truck['current_longitude']; ?>])
            .bindPopup('<strong><?php echo htmlspecialchars($truck['truck_name']); ?></strong><br><?php echo htmlspecialchars($truck['license_plate']); ?>')
            .addTo(map);
        markers.push(marker);
    <?php endforeach; ?>

    function focusMarker(lat, lng) {
        map.setView([lat, lng], 15);
    }
</script>

<?php include '../includes/footer.php'; ?>
