<?php
/**
 * Cron Job: Autodebet Angsuran Simpanan
 * Script ini dirancang untuk dijalankan melalui scheduler server (Cron)
 * atau dijalankan secara manual via Terminal/Command Line.
 */

// Agar bisa dipanggil dari luar web root (CLI)
define('APP_PATH', dirname(__DIR__));

// Load environment manual jika running dari CLI murni
$envFile = dirname(dirname(APP_PATH)) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

require_once APP_PATH . '/config/database.php';
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/services/AngsuranService.php';

echo "=============================================\n";
echo "MULAI PROSES AUTODEBET ANGSURAN (" . date('Y-m-d H:i:s') . ")\n";
echo "=============================================\n";


try {
    $angsuranService = new AngsuranService();
    $hasil = $angsuranService->prosesAutodebetHarian();

    echo "Total Jadwal Jatuh Tempo : " . $hasil['total_diperiksa'] . "\n";
    echo "Berhasil Autodebet       : " . $hasil['berhasil_debet'] . "\n";
    echo "Gagal (Saldo Kurang)     : " . $hasil['gagal_saldo_kurang'] . "\n";

    if (!empty($hasil['errors'])) {
        echo "\n[ERROR] Terdapat masalah teknis:\n";
        foreach ($hasil['errors'] as $err) {
            echo "- " . $err . "\n";
        }
    }

} catch (Exception $e) {
    echo "CRITICAL ERROR: " . $e->getMessage() . "\n";
}

echo "=============================================\n";
echo "SELESAI\n";
