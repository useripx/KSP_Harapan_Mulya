<?php
/**
 * App Configuration
 * KSP Harapan Mulya - Koperasi Simpan Pinjam
 */

// Load environment variables
function loadEnv($path) {
    if (!file_exists($path)) {
        die('.env file not found at: ' . $path);
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Lewati komentar atau baris kosong
        if (strpos($line, '#') === 0 || empty($line)) continue;
        
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            // Hapus tanda kutip jika ada (misal: DB_PASS="admin123")
            $value = trim($value, '"\'');
            
            // Paksa update ke semua lokasi global environment
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
            putenv("$name=$value");
        }
    }
}

// Load .env from root
loadEnv(__DIR__ . '/../../.env');

// App Configuration
return [
    'name' => 'KSP Harapan Mulya',
    'version' => '1.0.0',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'timezone' => $_ENV['APP_TIMEZONE'] ?? 'Asia/Jakarta',
    'base_url' => rtrim($_ENV['BASE_URL'] ?? '', '/'),
    
    // Path Configuration
    'paths' => [
        'root' => dirname(__DIR__, 2),
        'app' => dirname(__DIR__),
        'public' => dirname(__DIR__, 2) . '/public',
        'views' => dirname(__DIR__, 2) . '/views',
        'storage' => dirname(__DIR__, 2) . '/storage',
        'uploads' => dirname(__DIR__, 2) . '/public/uploads',
    ],
    
    // Session Configuration
    'session' => [
        'lifetime' => (int)($_ENV['SESSION_LIFETIME'] ?? 7200),
        'name' => $_ENV['SESSION_NAME'] ?? 'KSP_SESSION',
        'secure' => false, // Set true jika pakai HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ],
    
    // Security
    'csrf_token_name' => $_ENV['CSRF_TOKEN_NAME'] ?? 'csrf_token',
    'hash_algo' => (isset($_ENV['HASH_ALGO']) && defined($_ENV['HASH_ALGO'])) ? constant($_ENV['HASH_ALGO']) : PASSWORD_BCRYPT,
    
    // Upload Settings
    'upload' => [
        'max_size' => (int)($_ENV['MAX_UPLOAD_SIZE'] ?? 5242880), // 5MB
        'allowed_extensions' => explode(',', $_ENV['ALLOWED_EXTENSIONS'] ?? 'pdf,jpg,jpeg,png'),
    ],
    
    // Pagination
    'per_page' => (int)($_ENV['PER_PAGE'] ?? 20),

    // AI Configuration
    'groq_api_key' => $_ENV['GROQ_API_KEY'] ?? '',
];