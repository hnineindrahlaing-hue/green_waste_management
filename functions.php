<?php

// Get user by ID
function get_user($user_id, $link) {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Get all schedules
function get_all_schedules($link) {
    $sql = "SELECT * FROM schedules ORDER BY collection_date ASC";
    $result = $link->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get schedules by zone
function get_schedules_by_zone($zone, $link) {
    $sql = "SELECT * FROM schedules WHERE zone = ? ORDER BY collection_date ASC";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $zone);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get all active trucks
function get_active_trucks($link) {
    $sql = "SELECT * FROM trucks WHERE status = 'active'";
    $result = $link->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update truck location
function update_truck_location($truck_id, $latitude, $longitude, $link) {
    $sql = "UPDATE trucks SET current_latitude = ?, current_longitude = ? WHERE truck_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ddi", $latitude, $longitude, $truck_id);
    return $stmt->execute();
}

// Get all reports
function get_all_reports($link) {
    $sql = "SELECT r.*, u.username FROM reports r LEFT JOIN users u ON r.user_id = u.user_id ORDER BY r.reported_at DESC";
    $result = $link->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get user reports
function get_user_reports($user_id, $link) {
    $sql = "SELECT * FROM reports WHERE user_id = ? ORDER BY reported_at DESC";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Create report
function create_report($user_id, $report_type, $description, $latitude, $longitude, $image_url, $link) {
    $sql = "INSERT INTO reports (user_id, report_type, description, latitude, longitude, image_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("issdds", $user_id, $report_type, $description, $latitude, $longitude, $image_url);
    return $stmt->execute();
}

// Get all listings
function get_all_listings($link) {
    $sql = "SELECT l.*, u.username FROM listings l LEFT JOIN users u ON l.user_id = u.user_id WHERE l.status = 'available' ORDER BY l.posted_at DESC";
    $result = $link->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get user listings
function get_user_listings($user_id, $link) {
    $sql = "SELECT * FROM listings WHERE user_id = ? ORDER BY posted_at DESC";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Create listing
function create_listing($user_id, $title, $description, $category, $price, $unit, $image_url, $link) {
    $sql = "INSERT INTO listings (user_id, title, description, category, price, unit, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("isssids", $user_id, $title, $description, $category, $price, $unit, $image_url);
    return $stmt->execute();
}

// Sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Upload file
function upload_file($file, $upload_dir) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $file['tmp_name'];
        $name = basename($file['name']);
        $upload_file = $upload_dir . uniqid() . '_' . $name;
        
        if (move_uploaded_file($tmp_name, $upload_file)) {
            return $upload_file;
        }
    }
    return null;
}
?>
