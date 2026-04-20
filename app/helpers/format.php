<?php
/**
 * Format Helper Functions
 * Functions for formatting data display
 */

/**
 * Format number to Rupiah currency
 */
function formatRupiah($amount, $showCurrency = true) {
    $formatted = number_format($amount, 0, ',', '.');
    return $showCurrency ? 'Rp ' . $formatted : $formatted;
}

/**
 * Format date to Indonesian format
 */
function formatTanggal($date, $showTime = false) {
    if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
        return '-';
    }
    
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = $bulan[(int)date('m', $timestamp)];
    $year = date('Y', $timestamp);
    
    $result = "{$day} {$month} {$year}";
    
    if ($showTime) {
        $time = date('H:i', $timestamp);
        $result .= " {$time}";
    }
    
    return $result;
}

/**
 * Format date to short format
 */
function formatTanggalShort($date) {
    if (empty($date) || $date === '0000-00-00') {
        return '-';
    }
    return date('d/m/Y', strtotime($date));
}

/**
 * Format datetime to readable format
 */
function formatDateTime($datetime) {
    if (empty($datetime) || $datetime === '0000-00-00 00:00:00') {
        return '-';
    }
    return date('d/m/Y H:i', strtotime($datetime));
}

/**
 * Get relative time (e.g., "2 hari yang lalu")
 */
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return 'baru saja';
    }
    
    if ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' menit yang lalu';
    }
    
    if ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' jam yang lalu';
    }
    
    if ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' hari yang lalu';
    }
    
    return formatTanggal($datetime);
}

/**
 * Format phone number
 */
function formatPhone($phone) {
    if (empty($phone)) {
        return '-';
    }
    
    // Remove non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // Format: 0812-3456-7890
    if (strlen($phone) >= 10) {
        return substr($phone, 0, 4) . '-' . substr($phone, 4, 4) . '-' . substr($phone, 8);
    }
    
    return $phone;
}

/**
 * Format percentage
 */
function formatPersen($number, $decimals = 2) {
    return number_format($number, $decimals, ',', '.') . '%';
}

/**
 * Format file size
 */
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    
    return round($bytes, 2) . ' ' . $units[$pow];
}

/**
 * Truncate text
 */
function truncate($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    return substr($text, 0, $length) . $suffix;
}

/**
 * Generate initials from name
 */
function getInitials($name) {
    $words = explode(' ', $name);
    $initials = '';
    
    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper($word[0]);
        }
    }
    
    return substr($initials, 0, 2);
}

/**
 * Format status badge
 */
function statusBadge($status, $type = 'anggota') {
    return getStatusBadge($status, $type);
}

/**
 * Generate random color for avatar
 */
function getAvatarColor($seed) {
    $colors = [
        'bg-primary', 'bg-success', 'bg-info', 'bg-warning',
        'bg-danger', 'bg-secondary', 'bg-dark'
    ];
    
    $index = crc32($seed) % count($colors);
    return $colors[$index];
}

/**
 * Convert number to words (Indonesian)
 */
function terbilang($angka) {
    $angka = abs($angka);
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    
    if ($angka < 12) {
        return $huruf[$angka];
    } elseif ($angka < 20) {
        return terbilang($angka - 10) . " Belas";
    } elseif ($angka < 100) {
        return terbilang($angka / 10) . " Puluh " . terbilang($angka % 10);
    } elseif ($angka < 200) {
        return "Seratus " . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return terbilang($angka / 100) . " Ratus " . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return "Seribu " . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang($angka / 1000) . " Ribu " . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang($angka / 1000000) . " Juta " . terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        return terbilang($angka / 1000000000) . " Miliar " . terbilang($angka % 1000000000);
    }
    
    return "Angka terlalu besar";
}

/**
 * Format rupiah to words
 */
function rupiahTerbilang($angka) {
    if ($angka == 0) {
        return "Nol Rupiah";
    }
    
    return terbilang($angka) . " Rupiah";
}