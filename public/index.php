<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/**
 * Front Controller
 * Entry point for all requests
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting based on environment
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Load configuration
$configFile = APP_PATH . '/config/app.php';
if (!file_exists($configFile)) {
    die('Configuration file not found: ' . $configFile);
}

$config = require $configFile;
$GLOBALS['config'] = $config;

// Set timezone
date_default_timezone_set($config['timezone']);

// Load database
require APP_PATH . '/config/database.php';

// Load constants
require APP_PATH . '/config/constants.php';

// Load core classes
require APP_PATH . '/core/Router.php';
require APP_PATH . '/core/Controller.php';
require APP_PATH . '/core/Model.php';
require APP_PATH . '/core/View.php';
require APP_PATH . '/core/Auth.php';

// Load helper functions
require APP_PATH . '/helpers/format.php';
require APP_PATH . '/helpers/security.php';
require APP_PATH . '/helpers/validator.php';
require APP_PATH . '/helpers/response.php';
require APP_PATH . '/helpers/notification.php';

// Initialize authentication
Auth::init();

// ============================================
// PSEUDO-CRON: AUTODEBET ANGSURAN
// ============================================
// Jalankan cron autodebet otomatis satu kali sehari saat ada traffic masuk
$cronLogDir = APP_PATH . '/logs';
if (!is_dir($cronLogDir)) {
    mkdir($cronLogDir, 0755, true);
}
$cronFile = $cronLogDir . '/last_autodebet.txt';
$today = date('Y-m-d');
$lastRun = file_exists($cronFile) ? trim(file_get_contents($cronFile)) : '';

if ($lastRun !== $today) {
    try {
        require_once APP_PATH . '/services/KasService.php';
        require_once APP_PATH . '/services/SimpananService.php';
        require_once APP_PATH . '/services/AngsuranService.php';
        
        $angsuranService = new AngsuranService();
        /*
        * FITUR AUTODEBET DINONAKTIFKAN SEMENTARA
        * $angsuranService->prosesAutodebetHarian(); // Action potong saldo otomatis
        */
        
        file_put_contents($cronFile, $today);
    } catch (Exception $e) {
        error_log("Autodebet Cron failed: " . $e->getMessage());
    }
}

// Create router
$router = new Router();

// ============================================
// ROUTES DEFINITION
// ============================================

// Public routes - LOGIN
$router->get('/', 'AuthController@loginForm');
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Settings & Password management
$router->get('/settings', 'AuthController@settings');
$router->post('/settings/password/update', 'AuthController@updatePassword');

// Profile route
$router->get('/profile', 'ProfileController@index');

// Protected routes - Dashboard
$router->get('/dashboard', 'DashboardController@index');
$router->get('/validator', 'DashboardController@adminDashboard');
$router->get('/bau', 'DashboardController@tellerDashboard');
$router->get('/manager', 'DashboardController@ketuaDashboard');
$router->get('/anggota/dashboard', 'DashboardController@anggotaDashboard');
// Alias lama agar tidak 404 jika ada sesi lama
$router->get('/admin', 'DashboardController@adminDashboard');
$router->get('/teller', 'DashboardController@tellerDashboard');
$router->get('/ketua', 'DashboardController@ketuaDashboard');

// Anggota routes
$router->get('/anggota', 'AnggotaController@index');
$router->get('/anggota/create', 'AnggotaController@create');
$router->post('/anggota/store', 'AnggotaController@store');
$router->get('/anggota/{id}', 'AnggotaController@detail');
$router->get('/anggota/{id}/edit', 'AnggotaController@edit');
$router->post('/anggota/{id}/update', 'AnggotaController@update');
$router->post('/anggota/{id}/delete', 'AnggotaController@delete');

// User Management routes
$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create');
$router->post('/users/store', 'UserController@store');
$router->get('/users/{id}/edit', 'UserController@edit');
$router->post('/users/{id}/update', 'UserController@update');
$router->post('/users/{id}/delete', 'UserController@delete');
$router->post('/users/{id}/toggle-status', 'UserController@toggleStatus');
$router->post('/users/{id}/reset-password', 'UserController@resetPassword');

// Simpanan routes
$router->get('/simpanan', 'SimpananController@index');
$router->get('/simpanan/setor', 'SimpananController@setor');
$router->post('/simpanan/setor/process', 'SimpananController@prosesSetor');
$router->get('/simpanan/tarik', 'SimpananController@tarik');
$router->post('/simpanan/tarik/process', 'SimpananController@prosesTarik');
$router->get('/simpanan/transfer', 'SimpananController@transfer');
$router->post('/simpanan/transfer', 'SimpananController@prosesTransfer');

// Pinjaman routes
$router->get('/pinjaman', 'PinjamanController@index');
$router->get('/pinjaman/ajukan', 'PinjamanController@ajukan');
$router->post('/pinjaman/store', 'PinjamanController@store');

// ============================================
// FIX: Rute Simulasi ditambahkan di sini (Harus di atas rute {id})
// ============================================
$router->get('/pinjaman/simulasi', 'PinjamanController@simulasi');
// ============================================

$router->get('/pinjaman/{id}', 'PinjamanController@detail');
$router->get('/pinjaman/{id}/verifikasi', 'PinjamanController@verifikasi');
$router->post('/pinjaman/{id}/verifikasi', 'PinjamanController@prosesVerifikasi');
$router->get('/pinjaman/{id}/approval', 'PinjamanController@approval');
$router->post('/pinjaman/{id}/approve', 'PinjamanController@approve');
$router->post('/pinjaman/{id}/reject', 'PinjamanController@reject');
$router->get('/pinjaman/{id}/pencairan', 'PinjamanController@pencairan');
$router->post('/pinjaman/{id}/cairkan', 'PinjamanController@cairkan');

// Angsuran routes
$router->get('/angsuran', 'AngsuranController@index');
$router->get('/angsuran/bayar/{id}', 'AngsuranController@bayar');
$router->post('/angsuran/proses', 'AngsuranController@proses');
$router->get('/angsuran/{id}', 'AngsuranController@detail');

// Kas routes
$router->get('/kas', 'KasController@index');
$router->post('/kas/store', 'KasController@store');

// Laporan routes
$router->get('/laporan', 'LaporanController@index');
$router->get('/laporan/simpanan', 'LaporanController@simpanan');
$router->get('/laporan/pinjaman', 'LaporanController@pinjaman');
$router->get('/laporan/angsuran', 'LaporanController@angsuran');
$router->get('/laporan/tunggakan', 'LaporanController@tunggakan');
$router->get('/laporan/kas', 'LaporanController@kas');
$router->get('/laporan/neraca', 'LaporanController@neraca');
$router->get('/laporan/laba-rugi', 'LaporanController@labaRugi');
$router->get('/laporan/shu', 'LaporanController@shu');

// API routes (untuk AJAX)
$router->get('/api/anggota/search', 'AnggotaController@search');
$router->get('/api/anggota/{id}/saldo', 'AnggotaController@getSaldo');
$router->get('/api/pinjaman/{id}/jadwal', 'PinjamanController@getJadwal');
$router->post('/api/notifikasi/read', 'NotifikasiController@markAllAsRead');

// 404 handler
$router->setNotFound(function () {
    http_response_code(404);
    echo "<h1>404 - Page Not Found</h1>";
    echo "<p>The page you are looking for does not exist.</p>";
    echo "<a href='" . url('/') . "'>Go to Home</a>";
});

// Dispatch the router
try {
    $router->dispatch();
} catch (Exception $e) {
    if ($config['debug']) {
        echo "<h1>Error</h1>";
        echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        echo "<h3>Included Files:</h3><pre>";
        print_r(get_included_files());
        echo "</pre>";
    } else {
        echo "<h1>Something went wrong</h1>";
        echo "<p>Please try again later.</p>";
    }
}