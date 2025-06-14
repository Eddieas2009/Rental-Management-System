<?php

// Error reporting settings
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to users
ini_set('log_errors', 1); // Log errors to file
ini_set('error_log', __DIR__ . '/error.log'); // Set error log file path

// Set maximum execution time and memory limit
ini_set('max_execution_time', 30); // 30 seconds
ini_set('memory_limit', '128M');

// Set default timezone to Nairobi time zone
date_default_timezone_set('Africa/Nairobi');

// Create error log directory if it doesn't exist
$log_dir = __DIR__ . '/logs';
if (!file_exists($log_dir)) {
    mkdir($log_dir, 0755, true);
}

// Set error log file path
$error_log_file = $log_dir . '/error.log';
ini_set('error_log', $error_log_file);

// Create error log file if it doesn't exist
if (!file_exists($error_log_file)) {
    touch($error_log_file);
    chmod($error_log_file, 0644);
}

// Custom error handler function
function custom_error_handler($errno, $errstr, $errfile, $errline) {
    $timestamp = date('Y-m-d H:i:s');
    $error_message = "[$timestamp] Error ($errno): $errstr in $errfile on line $errline\n";
    error_log($error_message, 3, $GLOBALS['error_log_file']);
    
    // Don't execute PHP internal error handler
    return true;
}

// Set custom error handler
set_error_handler('custom_error_handler');



header("X-Frame-Options: DENY"); // Prevent clickjacking attacks by denying frame embedding
header("X-XSS-Protection: 1; mode=block"); // Enable browser's XSS filtering
header("X-Content-Type-Options: nosniff"); // Prevent MIME type sniffing
header("Referrer-Policy: strict-origin-when-cross-origin"); // Control how much referrer information is sent
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' https:; connect-src 'self' https:;"); // Define which resources can be loaded and from where
header("Permissions-Policy: geolocation=(), microphone=(), camera=()"); // Restrict access to browser features
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Enforce HTTPS connections



// Session security settings for HTTPS only
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
//ini_set('session.cookie_secure', 1); // Forces HTTPS only
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Strict');


// Set session name to something unique
session_name('SECURE_SESSION');

// Set session lifetime (30 minutes)
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'domain' => '',
    //'secure' => true, // HTTPS only
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Force HTTPS
/* if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
} */

// Company Details
define('COMPANY_NAME', 'Rental Management System');
define('COMPANY_ADDRESS', '123 Business Street, City, Country');
define('COMPANY_PHONE', '+1 234 567 8900');
define('COMPANY_EMAIL', 'contact@rentalmanagement.com');
define('COMPANY_WEBSITE', 'www.rentalmanagement.com');
define('COMPANY_DESCRIPTION', 'Professional rental property management system');
define('COMPANY_CURRENCY', 'USD');


define('LOGO_URL','assets/images/logo-icon.png');



// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'rental_management');
define('DB_USER', 'root');
define('DB_PASS', 'allow');

try {
    // Create PDO instance
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    // Log error securely (don't expose details to users)
    error_log("Connection failed: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}

// Security functions
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
generate_csrf_token();



// Regenerate session ID periodically to prevent session fixation
if (!isset($_SESSION['last_regeneration'])) {
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
} else if (time() - $_SESSION['last_regeneration'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
    return true;
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}


