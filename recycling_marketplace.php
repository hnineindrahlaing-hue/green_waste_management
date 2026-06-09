<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

$listings = get_all_listings($link);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>♻️ Recycling Marketplace</h2>
            <p class="text-muted">Buy and sell recyclable materials online.</p>
            <a href="create_listing.php" class="btn btn-success mb-3">+ Create Listing</a>
        </div>
    </div>

    <div class="row mt-4">
        <?php if (count($listings) > 0): ?>
            <?php foreach ($listings as $listing): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if ($listing['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($listing['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($listing['title']); ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span class="text-muted">No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($listing['title']); ?></h5>
                            <p class="card-text text-muted"><?php echo substr(htmlspecialchars($listing['description']), 0, 100); ?>...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success"><?php echo htmlspecialchars($listing['category']); ?></span>
                                <span class="h5 mb-0">$<?php echo number_format($listing['price'], 2); ?></span>
                            </div>
                            <small class="text-muted d-block mt-2">By: <?php echo htmlspecialchars($listing['username']); ?></small>
                            <small class="text-muted d-block">Unit: <?php echo htmlspecialchars($listing['unit']); ?></small>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="view_listing.php?id=<?php echo $listing['listing_id']; ?>" class="btn btn-sm btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <strong>No listings available yet.</strong> Be the first to <a href="create_listing.php">create a listing</a>!
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
