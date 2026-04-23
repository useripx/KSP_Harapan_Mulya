<?php
/**
 * Authentication Class
 * Handle user authentication and session management
 */

class Auth {
    
    /**
     * Initialize session
     */
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            $config = $GLOBALS['config']['session'];
            
            session_set_cookie_params([
                'lifetime' => $config['lifetime'],
                'path' => '/',
                'secure' => $config['secure'],
                'httponly' => $config['httponly'],
                'samesite' => $config['samesite']
            ]);
            
            session_name($config['name']);
            session_start();
        }
    }
    
    /**
     * Login user
     */
    public static function login($user) {
        self::init();
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['is_logged_in'] = true;
        $_SESSION['login_time'] = time();
        
        // Update last login
        $db = db();
        $stmt = $db->prepare("UPDATE users SET last_login_at = NOW() WHERE id = ?");
        $stmt->execute([$user['id']]);
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        return true;
    }
    
    /**
     * Logout user
     */
    public static function logout() {
        self::init();
        
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        session_destroy();
    }
    
    /**
     * Check if user is logged in
     */
    public static function check() {
        self::init();
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
    }
    
    /**
     * Get current user data
     */
    public static function user() {
        self::init();
        
        if (!self::check()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['user_username'] ?? null,
            'name' => $_SESSION['user_name'] ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'role' => $_SESSION['user_role'] ?? null,
        ];
    }
    
    /**
     * Get user ID
     */
    public static function id() {
        $user = self::user();
        return $user['id'] ?? null;
    }
    
    /**
     * Get user role
     */
    public static function role() {
        $user = self::user();
        return $user['role'] ?? null;
    }
    
    /**
     * Check if user has specific role
     */
    public static function hasRole($role) {
        return self::role() === $role;
    }
    
    /**
     * Check if user has any of the given roles
     */
    public static function hasAnyRole($roles) {
        $userRole = self::role();
        return in_array($userRole, (array)$roles);
    }
    
    /**
     * Check if user has permission
     */
    public static function can($permission) {
        $role = self::role();
        
        if (!$role) {
            return false;
        }
        
        return hasPermission($role, $permission);
    }
    
    /**
     * Require authentication (redirect if not logged in)
     */
    public static function requireLogin($redirectTo = '/login') {
        if (!self::check()) {
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . url($redirectTo));
            exit;
        }
    }
    
    /**
     * Require specific role
     */
    public static function requireRole($role, $redirectTo = '/dashboard') {
        self::requireLogin();
        
        if (!self::hasRole($role)) {
            header('Location: ' . url($redirectTo));
            exit;
        }
    }
    
    /**
     * Require any of given roles
     */
    public static function requireAnyRole($roles, $redirectTo = '/dashboard') {
        self::requireLogin();
        
        if (!self::hasAnyRole($roles)) {
            header('Location: ' . url($redirectTo));
            exit;
        }
    }
    
    /**
     * Require permission
     */
    public static function requirePermission($permission, $redirectTo = '/') {
        self::requireLogin();
        
        if (!self::can($permission)) {
            header('Location: ' . url($redirectTo));
            exit;
        }
    }
    
    /**
     * Get intended URL after login
     */
    public static function intended($default = '/') {
        self::init();
        
        $url = $_SESSION['intended_url'] ?? $default;
        unset($_SESSION['intended_url']);
        
        return $url;
    }
    
    /**
     * Verify password
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Hash password
     */
    public static function hashPassword($password) {
        return password_hash($password, $GLOBALS['config']['hash_algo']);
    }
    
    /**
     * Attempt login with credentials
     */
    public static function attempt($username, $password) {
        $db = db();
        
        // Try username, email, or no_anggota
        $stmt = $db->prepare("
            SELECT u.* FROM users u
            LEFT JOIN anggota a ON u.id = a.user_id
            WHERE (u.username = ? OR u.email = ? OR a.no_anggota = ?) 
            AND u.is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$username, $username, $username]);
        $user = $stmt->fetch();
        
        if ($user && self::verifyPassword($password, $user['password_hash'])) {
            self::login($user);
            return true;
        }
        
        return false;
    }
}