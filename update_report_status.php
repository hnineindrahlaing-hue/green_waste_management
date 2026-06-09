<?php
require_once '../includes/db_config.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_admin();

if (isset($_GET['id']) && isset($_GET['status'])) {
    $report_id = intval($_GET['id']);
    $status = sanitize_input($_GET['status']);
    
    $sql = "UPDATE reports SET status = ? WHERE report_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("si", $status, $report_id);
    
    if ($stmt->execute()) {
        header("Location: manage_reports.php?success=Report status updated");
    } else {
        header("Location: manage_reports.php?error=Failed to update report");
    }
} else {
    header("Location: manage_reports.php");
}
?>
