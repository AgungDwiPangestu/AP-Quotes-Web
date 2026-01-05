<?php

/**
 * General Configuration File
 */

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set ke 1 jika menggunakan HTTPS

// Session timeout (15 menit)
define('SESSION_TIMEOUT', 900);

// Site Configuration
define('SITE_NAME', 'Ap Quotes');
define('SITE_URL', 'http://localhost/ApQuotesWeb');

// Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../assets/images/uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Error Reporting (Matikan di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once __DIR__ . '/database.php';
