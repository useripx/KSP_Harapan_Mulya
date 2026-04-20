<?php
/**
 * Router Class
 * Simple routing system for the application
 */

class Router {
    private $routes = [];
    private $notFoundCallback;
    
    /**
     * Add GET route
     */
    public function get($path, $callback, $middleware = []) {
        $this->addRoute('GET', $path, $callback, $middleware);
    }
    
    /**
     * Add POST route
     */
    public function post($path, $callback, $middleware = []) {
        $this->addRoute('POST', $path, $callback, $middleware);
    }
    
    /**
     * Add route to routes array
     */
    private function addRoute($method, $path, $callback, $middleware = []) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'middleware' => $middleware
        ];
    }
    
    /**
     * Set 404 callback
     */
    public function setNotFound($callback) {
        $this->notFoundCallback = $callback;
    }
    
    /**
     * Dispatch the request
     */
    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (($pos = strpos($requestUri, '?')) !== false) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        
        // Remove base path if exists
        $basePath = parse_url($GLOBALS['config']['base_url'], PHP_URL_PATH) ?? '';
        if ($basePath && strpos($requestUri, $basePath) === 0) {
            $requestUri = substr($requestUri, strlen($basePath));
        }
        
        $requestUri = '/' . trim($requestUri, '/');
        if ($requestUri !== '/') {
            $requestUri = rtrim($requestUri, '/');
        }
        
        // Find matching route
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            $pattern = $this->buildPattern($route['path']);
            
            if (preg_match($pattern, $requestUri, $matches)) {
                // Keep only numeric keys and remove full match
                $params = array_filter($matches, function($key) {
                    return is_int($key);
                }, ARRAY_FILTER_USE_KEY);
                
                array_shift($params); // Remove full match (index 0)
                
                // Run middleware
                foreach ($route['middleware'] as $middleware) {
                    if (is_callable($middleware)) {
                        $result = call_user_func($middleware);
                        if ($result === false) {
                            return; // Middleware blocked
                        }
                    }
                }
                
                // Execute callback
                return $this->executeCallback($route['callback'], $params);
            }
        }
        
        // No route found - 404
        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }
        
        http_response_code(404);
        echo "404 - Page Not Found";
    }
    
    /**
     * Build regex pattern from route path
     */
    private function buildPattern($path) {
        // Convert :param to named capture group
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
    
    /**
     * Execute callback (Controller@method or closure)
     */
    private function executeCallback($callback, $params = []) {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $params);
        }
        
        if (is_string($callback)) {
            $parts = explode('@', $callback);
            if (count($parts) === 2) {
                list($controllerName, $method) = $parts;
                
                $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    
                    if (class_exists($controllerName)) {
                        $controller = new $controllerName();
                        
                        if (method_exists($controller, $method)) {
                            return call_user_func_array([$controller, $method], $params);
                        } else {
                            throw new Exception("Method $method not found in $controllerName");
                        }
                    } else {
                        throw new Exception("Class $controllerName not found in $controllerFile");
                    }
                } else {
                    throw new Exception("Controller file $controllerFile not found");
                }
            }
        }
        
        throw new Exception("Invalid callback format: " . print_r($callback, true));
    }
}