<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

if (!isset($_GET['id'])) {
    header("Location: recycling_marketplace.php");
    exit;
}

$listing_id = intval($_GET['id']);
$sql = "SELECT l.*, u.username, u.email FROM listings l LEFT JOIN users u ON l.user_id = u.user_id WHERE l.listing_id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $listing_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: recycling_marketplace.php");
    exit;
}

$listing = $result->fetch_assoc();
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <a href="recycling_marketplace.php" class="btn btn-secondary mb-3">← Back to Marketplace</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($listing['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($listing['image_url']); ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>" class="img-fluid" style="border-radius: 5px;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px; border-radius: 5px;">
                                    <span class="text-muted">No Image Available</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <h2><?php echo htmlspecialchars($listing['title']); ?></h2>
                            
                            <div class="mb-3">
                                <span class="badge bg-success"><?php echo htmlspecialchars($listing['category']); ?></span>
                                <span class="badge bg-<?php echo $listing['status'] === 'sold' ? 'danger' : 'primary'; ?>">
                                    <?php echo ucfirst($listing['status']); ?>
                                </span>
                            </div>

                            <h3 class="text-success mb-3">$<?php echo number_format($listing['price'], 2); ?> per <?php echo htmlspecialchars($listing['unit']); ?></h3>

                            <h6 class="text-muted">Description</h6>
                            <p><?php echo htmlspecialchars($listing['description']); ?></p>

                            <hr>

                            <h6 class="text-muted">Seller Information</h6>
                            <p>
                                <strong>Name:</strong> <?php echo htmlspecialchars($listing['username']); ?><br>
                                <strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($listing['email']); ?>"><?php echo htmlspecialchars($listing['email']); ?></a>
                            </p>

                            <hr>

                            <h6 class="text-muted">Posted</h6>
                            <p><?php echo date('M d, Y', strtotime($listing['posted_at'])); ?></p>

                            <?php if ($listing['status'] === 'available'): ?>
                                <button class="btn btn-success btn-lg w-100" onclick="alert('Contact the seller via email to purchase.')">
                                    Contact Seller
                                </button>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <?php echo ucfirst($listing['status']); ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
