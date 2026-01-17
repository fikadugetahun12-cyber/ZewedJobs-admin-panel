<?php
// Database configuration
define('DB_PATH', dirname(__DIR__) . '/database/');
define('JOBS_DB', DB_PATH . 'jobs.json');
define('USERS_DB', DB_PATH . 'users.json');
define('COMPANIES_DB', DB_PATH . 'companies.json');

// Admin credentials
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', password_hash('admin123', PASSWORD_DEFAULT));

// Session configuration
session_start();

// Error logging
define('LOG_PATH', dirname(__DIR__) . '/logs/errors.log');

function logError($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] ERROR: $message\n";
    file_put_contents(LOG_PATH, $logMessage, FILE_APPEND);
}

// JSON helper functions
function readJSON($file) {
    if (!file_exists($file)) {
        return [];
    }
    $content = file_get_contents($file);
    return json_decode($content, true) ?: [];
}

function writeJSON($file, $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($file, $json);
}

// Authentication check
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
?>
