<?php

/**
 * Functions Helper File
 * Berisi fungsi-fungsi umum yang digunakan di seluruh aplikasi
 */

/**
 * Sanitize input untuk mencegah XSS
 */
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Check apakah user sudah login
 */
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

/**
 * Check session timeout
 */
function check_session_timeout()
{
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        return false;
    }
    $_SESSION['last_activity'] = time();
    return true;
}

/**
 * Redirect dengan message
 */
function redirect($url, $message = '', $type = 'info')
{
    if ($message) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    header("Location: $url");
    exit();
}

/**
 * Get flash message
 */
function get_flash_message()
{
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

/**
 * Format tanggal
 */
function format_date($date)
{
    $datetime = new DateTime($date);
    $now = new DateTime();
    $diff = $now->diff($datetime);

    if ($diff->days == 0) {
        if ($diff->h == 0) {
            if ($diff->i == 0) {
                return 'Baru saja';
            }
            return $diff->i . ' menit yang lalu';
        }
        return $diff->h . ' jam yang lalu';
    } elseif ($diff->days == 1) {
        return 'Kemarin';
    } elseif ($diff->days < 7) {
        return $diff->days . ' hari yang lalu';
    } else {
        return $datetime->format('d M Y');
    }
}

/**
 * Validate email
 */
function is_valid_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Generate CSRF token
 */
function generate_csrf_token()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check if user is admin
 */
function is_admin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Get current user ID
 */
function get_current_user_id()
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current username
 */
function get_current_username()
{
    return $_SESSION['username'] ?? '';
}
