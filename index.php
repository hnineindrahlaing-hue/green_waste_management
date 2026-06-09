<?php
require_once 'includes/db_config.php';
require_once 'includes/auth.php';
?>
<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron bg-success text-white p-5 rounded">
                <h1 class="display-4">🌱 Green Waste Management System</h1>
                <p class="lead">Making waste management smarter, cleaner, and more sustainable.</p>
                <hr class="my-4">
                <p>Join our community to track waste collection, report issues, and participate in recycling.</p>
                <?php if (!is_logged_in()): ?>
                    <a class="btn btn-light btn-lg" href="/register.php" role="button">Get Started</a>
                    <a class="btn btn-outline-light btn-lg" href="/login.php" role="button">Login</a>
                <?php else: ?>
                    <a class="btn btn-light btn-lg" href="/user/index.php" role="button">Go to Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📅 Collection Schedules</h5>
                    <p class="card-text">View waste collection schedules for your zone and never miss a pickup.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">🚚 Real-Time Tracking</h5>
                    <p class="card-text">Track garbage trucks in real-time and know exactly when they'll arrive.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📢 Report Issues</h5>
                    <p class="card-text">Report overflowing bins or waste issues with photos and location details.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">♻️ Recycling Marketplace</h5>
                    <p class="card-text">Buy and sell recyclable materials online and support the circular economy.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📊 Admin Dashboard</h5>
                    <p class="card-text">Administrators can monitor operations and manage the waste management system.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">🌍 Smart City Support</h5>
                    <p class="card-text">Support digital transformation in local waste management services.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
