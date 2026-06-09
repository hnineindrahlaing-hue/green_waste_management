<?php
session_start();

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Check user role
function check_role($required_role) {
    if (!is_logged_in()) {
        return false;
    }
    return $_SESSION['role'] === $required_role;
}

// Redirect if not logged in
function require_login() {
    if (!is_logged_in()) {
        header("Location: /login.php");
        exit;
    }
}

// Redirect if not admin
function require_admin() {
    if (!is_logged_in() || $_SESSION['role'] !== 'admin') {
        header("Location: /index.php");
        exit;
    }
}

// Logout function
function logout() {
    session_destroy();
    header("Location: /index.php");
    exit;
}

// Hash password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}
?>
