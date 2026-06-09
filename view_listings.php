<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

$user_listings = get_user_listings($_SESSION['user_id'], $link);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>My Listings</h2>
            <p class="text-muted">Manage your recycling marketplace listings.</p>
            <a href="create_listing.php" class="btn btn-success mb-3">+ Create New Listing</a>
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
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($user_listings) > 0): ?>
                                    <?php foreach ($user_listings as $listing): ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($listing['title']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($listing['category']); ?></td>
                                            <td>$<?php echo number_format($listing['price'], 2); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $listing['status'] === 'sold' ? 'success' : 'primary'; ?>">
                                                    <?php echo ucfirst($listing['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($listing['posted_at'])); ?></td>
                                            <td>
                                                <a href="view_listing.php?id=<?php echo $listing['listing_id']; ?>" class="btn btn-sm btn-info">View</a>
                                                <a href="edit_listing.php?id=<?php echo $listing['listing_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No listings yet. <a href="create_listing.php">Create one</a></td>
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
