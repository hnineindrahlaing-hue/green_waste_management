<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_admin();

$listings = $link->query("SELECT l.*, u.username FROM listings l LEFT JOIN users u ON l.user_id = u.user_id ORDER BY l.posted_at DESC")->fetch_all(MYSQLI_ASSOC);
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Manage Listings</h2>
            <p class="text-muted">Moderate recycling marketplace listings.</p>
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
                                    <th>Title</th>
                                    <th>Seller</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listings as $listing): ?>
                                    <tr>
                                        <td><?php echo $listing['listing_id']; ?></td>
                                        <td><?php echo htmlspecialchars($listing['title']); ?></td>
                                        <td><?php echo htmlspecialchars($listing['username']); ?></td>
                                        <td>$<?php echo number_format($listing['price'], 2); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $listing['status'] === 'sold' ? 'success' : 'primary'; ?>">
                                                <?php echo ucfirst($listing['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($listing['posted_at'])); ?></td>
                                        <td>
                                            <a href="view_listing.php?id=<?php echo $listing['listing_id']; ?>" class="btn btn-sm btn-info">View</a>
                                            <a href="delete_listing.php?id=<?php echo $listing['listing_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
