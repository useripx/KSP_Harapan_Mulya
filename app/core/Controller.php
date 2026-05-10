<?php
/**
 * Base Controller Class
 * All controllers should extend this class
 */

class Controller {
    protected $config;
    
    public function __construct() {
        $this->config = $GLOBALS['config'];
        
        // Force password change check
        if (Auth::check() && isset($_SESSION['must_change_password']) && $_SESSION['must_change_password'] === true) {
            $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $baseUrl = parse_url($this->config['base_url'], PHP_URL_PATH);
            $relativePath = str_replace($baseUrl, '', $currentPath);
            $relativePath = '/' . ltrim($relativePath, '/');
            
            $excluded = ['/force-password', '/logout'];
            if (!in_array($relativePath, $excluded)) {
                $this->redirect('/force-password');
            }
        }
    }
    
    /**
     * Render view with layout
     */
    protected function view($viewPath, $data = [], $layout = 'main') {
        extract($data);
        
        $viewFile = $this->config['paths']['views'] . '/' . $viewPath . '.php';
        
        if (!file_exists($viewFile)) {
            die("View not found: {$viewPath}");
        }
        
        // Start output buffering
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        
        // Load layout if specified
        if ($layout) {
            $layoutFile = $this->config['paths']['views'] . '/layout/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }
    
    /**
     * Render view without layout (for AJAX)
     */
    protected function viewOnly($viewPath, $data = []) {
        return $this->view($viewPath, $data, false);
    }
    
    /**
     * Redirect to another URL
     */
    protected function redirect($path, $message = null, $type = 'info') {
        if ($message) {
            $this->setFlash($message, $type);
        }
        
        $url = $this->url($path);
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Redirect back to previous page
     */
    protected function redirectBack($message = null, $type = 'info') {
        $referer = $_SERVER['HTTP_REFERER'] ?? $this->url('/');
        
        if ($message) {
            $this->setFlash($message, $type);
        }
        
        header("Location: {$referer}");
        exit;
    }
    
    /**
     * Generate URL from path
     */
    protected function url($path = '') {
        $baseUrl = rtrim($this->config['base_url'], '/');
        $path = '/' . ltrim($path, '/');
        return $baseUrl . $path;
    }
    
    /**
     * Get asset URL
     */
    protected function asset($path) {
        return $this->url('/assets/' . ltrim($path, '/'));
    }
    
    /**
     * Set flash message
     */
    protected function setFlash($message, $type = 'info') {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    
    /**
     * Get and clear flash message
     */
    protected function getFlash() {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            $type = $_SESSION['flash_type'] ?? 'info';
            
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            
            return ['message' => $message, 'type' => $type];
        }
        
        return null;
    }
    
    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Get POST data
     */
    protected function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get GET data
     */
    protected function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Validate CSRF token
     */
    protected function validateCsrf() {
        $token = $this->post($this->config['csrf_token_name']);
        
        if (!isset($_SESSION)) {
            session_start();
        }
        
        $sessionToken = $_SESSION[$this->config['csrf_token_name']] ?? '';
        
        if (!hash_equals($sessionToken, $token ?? '')) {
            $this->json(['success' => false, 'message' => 'Invalid CSRF token'], 403);
        }
    }
    
    /**
     * Check if request is AJAX
     */
    protected function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Check if request is POST
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Validate required fields
     */
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $ruleArray = explode('|', $rule);
            
            foreach ($ruleArray as $r) {
                if ($r === 'required' && empty($data[$field])) {
                    $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
                    break;
                }
                
                if (strpos($r, 'min:') === 0 && isset($data[$field])) {
                    $min = (int)substr($r, 4);
                    if (strlen($data[$field]) < $min) {
                        $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " must be at least {$min} characters";
                    }
                }
                
                if ($r === 'email' && isset($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = 'Invalid email format';
                }
                
                if ($r === 'numeric' && isset($data[$field]) && !is_numeric($data[$field])) {
                    $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' must be numeric';
                }
            }
        }
        
        return $errors;
    }
}