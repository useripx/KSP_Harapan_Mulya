<?php
/**
 * Security Helper Functions
 * Functions for security and data sanitization
 */

/**
 * Clean input data
 */
function clean($data) {
    if (is_array($data)) {
        return array_map('clean', $data);
    }
    
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize string
 */
function sanitize($string) {
    return filter_var($string, FILTER_SANITIZE_STRING);
}

/**
 * Sanitize email
 */
function sanitizeEmail($email) {
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}

/**
 * Sanitize URL
 */
function sanitizeUrl($url) {
    return filter_var($url, FILTER_SANITIZE_URL);
}

/**
 * Escape HTML output
 */
function escape($data) {
    if (is_array($data)) {
        return array_map('escape', $data);
    }
    
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF token
 */
function generateCsrfToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $tokenName = $GLOBALS['config']['csrf_token_name'];
    
    if (!isset($_SESSION[$tokenName])) {
        $_SESSION[$tokenName] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION[$tokenName];
}

/**
 * Validate CSRF token
 */
function validateCsrfToken($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $tokenName = $GLOBALS['config']['csrf_token_name'];
    $sessionToken = $_SESSION[$tokenName] ?? '';
    
    return hash_equals($sessionToken, $token ?? '');
}

/**
 * Get CSRF token input field
 */
function csrfField() {
    $tokenName = $GLOBALS['config']['csrf_token_name'];
    $token = generateCsrfToken();
    
    return "<input type='hidden' name='{$tokenName}' value='{$token}'>";
}

/**
 * Get CSRF token meta tag
 */
function csrfMeta() {
    $token = generateCsrfToken();
    return "<meta name='csrf-token' content='{$token}'>";
}

/**
 * Prevent SQL Injection (use with PDO prepared statements)
 */
function preventSqlInjection($string) {
    return addslashes($string);
}

/**
 * Generate random string
 */
function generateRandomString($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Generate secure password
 */
function generatePassword($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    $password = '';
    $charsLength = strlen($chars);
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $charsLength - 1)];
    }
    
    return $password;
}

/**
 * Hash password
 */
function hashPassword($password) {
    return password_hash($password, $GLOBALS['config']['hash_algo']);
}

/**
 * Verify password
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Encrypt data
 */
function encryptData($data, $key = null) {
    $key = $key ?? $_ENV['APP_KEY'] ?? 'default-key-change-this';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    
    return base64_encode($encrypted . '::' . $iv);
}

/**
 * Decrypt data
 */
function decryptData($data, $key = null) {
    $key = $key ?? $_ENV['APP_KEY'] ?? 'default-key-change-this';
    list($encrypted, $iv) = explode('::', base64_decode($data), 2);
    
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}

/**
 * Check if request is from same origin
 */
function isSameOrigin() {
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    
    return strpos($origin, $host) !== false;
}

/**
 * Prevent XSS attacks
 */
function xssClean($data) {
    if (is_array($data)) {
        return array_map('xssClean', $data);
    }
    
    // Remove null bytes
    $data = str_replace(chr(0), '', $data);
    
    // Fix for &entity\n;
    $data = str_replace(['&amp;', '&lt;', '&gt;'], ['&amp;amp;', '&amp;lt;', '&amp;gt;'], $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
    
    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
    
    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    
    // Remove namespaced elements
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
    
    return $data;
}

/**
 * Log security event
 */
function logSecurityEvent($event, $details = []) {
    $logFile = $GLOBALS['config']['paths']['storage'] . '/logs/security.log';
    $logDir = dirname($logFile);
    
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $userId = Auth::id() ?? 'Guest';
    
    $logData = [
        'timestamp' => $timestamp,
        'event' => $event,
        'user_id' => $userId,
        'ip' => $ip,
        'user_agent' => $userAgent,
        'details' => $details
    ];
    
    $logEntry = json_encode($logData) . "\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}