<?php
/**
 * View Helper Class
 * Helper functions for views
 */

class View {
    
    /**
     * Escape HTML to prevent XSS
     */
    public static function escape($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Include partial view
     */
    public static function partial($path, $data = []) {
        extract($data);
        $file = $GLOBALS['config']['paths']['views'] . '/partials/' . $path . '.php';
        
        if (file_exists($file)) {
            require $file;
        }
    }
    
    /**
     * Generate CSRF token field
     */
    public static function csrf() {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        $tokenName = $GLOBALS['config']['csrf_token_name'];
        
        if (!isset($_SESSION[$tokenName])) {
            $_SESSION[$tokenName] = bin2hex(random_bytes(32));
        }
        
        $token = $_SESSION[$tokenName];
        
        return "<input type='hidden' name='{$tokenName}' value='{$token}'>";
    }
    
    /**
     * Get CSRF token
     */
    public static function getCsrfToken() {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        $tokenName = $GLOBALS['config']['csrf_token_name'];
        
        if (!isset($_SESSION[$tokenName])) {
            $_SESSION[$tokenName] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION[$tokenName];
    }
    
    /**
     * Display flash message
     */
    public static function flash() {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            $type = $_SESSION['flash_type'] ?? 'info';
            
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            
            $alertClass = [
                'success' => 'alert-success',
                'error' => 'alert-danger',
                'warning' => 'alert-warning',
                'info' => 'alert-info'
            ];
            
            $class = $alertClass[$type] ?? 'alert-info';
            
            echo "<div class='alert {$class} alert-dismissible fade show' role='alert'>";
            echo self::escape($message);
            echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
            echo "</div>";
        }
    }
    
    /**
     * Generate URL
     */
    public static function url($path = '') {
        $baseUrl = rtrim($GLOBALS['config']['base_url'], '/');
        $path = '/' . ltrim($path, '/');
        return $baseUrl . $path;
    }
    
    /**
     * Generate asset URL
     */
    public static function asset($path) {
        return self::url('/assets/' . ltrim($path, '/'));
    }
    
    /**
     * Check if current URL matches path
     */
    public static function isActive($path) {
        $currentPath = $_SERVER['REQUEST_URI'];
        $basePath = parse_url($GLOBALS['config']['base_url'], PHP_URL_PATH) ?? '';
        
        if ($basePath) {
            $currentPath = str_replace($basePath, '', $currentPath);
        }
        
        $currentPath = '/' . trim($currentPath, '/');
        $checkPath = '/' . trim($path, '/');
        
        return strpos($currentPath, $checkPath) === 0 ? 'active' : '';
    }
    
    /**
     * Old input value (for form validation)
     */
    public static function old($key, $default = '') {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        return $_SESSION['old'][$key] ?? $default;
    }
    
    /**
     * Set old input
     */
    public static function setOld($data) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['old'] = $data;
    }
    
    /**
     * Clear old input
     */
    public static function clearOld() {
        if (!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION['old']);
    }
    
    /**
     * Get validation errors
     */
    public static function errors() {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        return $_SESSION['errors'] ?? [];
    }
    
    /**
     * Get specific error
     */
    public static function error($key) {
        $errors = self::errors();
        return $errors[$key] ?? null;
    }
    
    /**
     * Set errors
     */
    public static function setErrors($errors) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['errors'] = $errors;
    }
    
    /**
     * Clear errors
     */
    public static function clearErrors() {
        if (!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION['errors']);
    }
}

// Global helper functions
function e($string) {
    return View::escape($string);
}

function url($path = '') {
    return View::url($path);
}

function asset($path) {
    return View::asset($path);
}

function old($key, $default = '') {
    return View::old($key, $default);
}