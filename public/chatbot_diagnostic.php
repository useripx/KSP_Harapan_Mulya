<?php
/**
 * Chatbot Diagnostic Page
 * Untuk debugging masalah chatbot
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set header sebagai JSON
header('Content-Type: application/json');

$diagnostics = [
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => phpversion(),
    'server_info' => [
        'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'http_host' => $_SERVER['HTTP_HOST'] ?? 'unknown',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
        'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
    ],
    'environment' => [],
    'groq_api' => [],
    'database' => [],
    'files' => []
];

// Check environment variables
$env_file = dirname(__DIR__, 2) . '/.env';
if (file_exists($env_file)) {
    $diagnostics['files']['env_exists'] = true;
    $env_size = filesize($env_file);
    $diagnostics['files']['env_size'] = $env_size;
    
    // Load and check key variables
    $lines = file($env_file);
    foreach ($lines as $line) {
        if (preg_match('/^(DB_|GROQ_|BASE_|APP_)/', $line)) {
            $parts = explode('=', $line, 2);
            $key = trim($parts[0]);
            $value = trim($parts[1] ?? '');
            $diagnostics['environment'][$key] = (strlen($value) > 0) ? '✓ SET' : '✗ EMPTY';
        }
    }
} else {
    $diagnostics['files']['env_exists'] = false;
}

// Check important PHP extensions
$diagnostics['extensions'] = [
    'curl' => extension_loaded('curl') ? '✓' : '✗',
    'json' => extension_loaded('json') ? '✓' : '✗',
    'pdo' => extension_loaded('pdo') ? '✓' : '✗',
    'openssl' => extension_loaded('openssl') ? '✓' : '✗',
];

// Check if config files exist
$config_file = dirname(__DIR__, 2) . '/app/config/app.php';
$diagnostics['files']['app_config_exists'] = file_exists($config_file);

// Check database connection (simulate)
$diagnostics['database']['host_file'] = dirname(__DIR__, 2) . '/app/config/database.php';
$diagnostics['database']['exists'] = file_exists($diagnostics['database']['host_file']);

// Test Groq API endpoint
$diagnostics['groq_api']['endpoint'] = 'https://api.groq.com/openai/v1/chat/completions';
$diagnostics['groq_api']['model'] = 'llama-3.3-70b-versatile';

// Check if chatbot files exist
$chatbot_files = [
    'controller' => dirname(__DIR__) . '/app/controllers/ChatbotController.php',
    'service' => dirname(__DIR__) . '/app/services/GroqService.php',
    'js' => dirname(__DIR__) . '/public/js/chatbot.js',
    'layout' => dirname(__DIR__) . '/views/layout/chatbot.php',
];

foreach ($chatbot_files as $name => $path) {
    $diagnostics['files']['chatbot_' . $name] = file_exists($path) ? 'exists' : 'MISSING';
}

// Test curl connectivity (if curl available)
if (extension_loaded('curl')) {
    $ch = curl_init('https://api.groq.com/openai/v1/models');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_errno($ch);
    curl_close($ch);
    
    $diagnostics['curl'] = [
        'can_reach_groq' => ($curl_error === 0) ? 'yes (CURL error: 0)' : 'no (CURL error: ' . $curl_error . ')',
    ];
}

echo json_encode($diagnostics, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
echo "\n";
?>