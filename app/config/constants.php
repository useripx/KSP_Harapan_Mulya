<?php
/**
 * Application Constants
 * Define all constants used in the application
 */

// User Roles
define('ROLE_ADMIN', 'ADMIN');
define('ROLE_TELLER', 'TELLER');
define('ROLE_KETUA', 'KETUA');
define('ROLE_ANGGOTA', 'ANGGOTA');

// Anggota Status
define('STATUS_ANGGOTA_AKTIF', 'AKTIF');
define('STATUS_ANGGOTA_NONAKTIF', 'NONAKTIF');
define('STATUS_ANGGOTA_KELUAR', 'KELUAR');

// Anggota Tipe
define('TIPE_MAHASISWA', 'MAHASISWA');
define('TIPE_DOSEN', 'DOSEN');
define('TIPE_STAF', 'STAF');
define('TIPE_UMUM', 'UMUM');

// Transaksi Simpanan
define('TRANSAKSI_SETOR', 'SETOR');
define('TRANSAKSI_TARIK', 'TARIK');
define('TRANSAKSI_TRANSFER', 'TRANSFER');

// Status Pinjaman
define('PINJAMAN_DIAJUKAN', 'DIAJUKAN');
define('PINJAMAN_DIVERIFIKASI', 'DIVERIFIKASI');
define('PINJAMAN_DISETUJUI', 'DISETUJUI');
define('PINJAMAN_DITOLAK', 'DITOLAK');
define('PINJAMAN_DICAIRKAN', 'DICAIRKAN');
define('PINJAMAN_BERJALAN', 'BERJALAN');
define('PINJAMAN_LUNAS', 'LUNAS');

// Metode Pinjaman
define('METODE_FLAT', 'FLAT');
define('METODE_MENURUN', 'MENURUN');
define('METODE_ANUITAS', 'ANUITAS');

// Status Jadwal Angsuran
define('JADWAL_BELUM', 'BELUM');
define('JADWAL_BAYAR', 'BAYAR');

// Approval Decision
define('KEPUTUSAN_SETUJU', 'SETUJU');
define('KEPUTUSAN_TOLAK', 'TOLAK');

// Kas Transaksi
define('KAS_MASUK', 'KAS_MASUK');
define('KAS_KELUAR', 'KAS_KELUAR');

// Sumber Kas
define('SUMBER_SIMPANAN', 'SIMPANAN');
define('SUMBER_PENCAIRAN_PINJAMAN', 'PENCAIRAN_PINJAMAN');
define('SUMBER_ANGSURAN', 'ANGSURAN');
define('SUMBER_OPERASIONAL', 'OPERASIONAL');
define('SUMBER_LAINNYA', 'LAINNYA');

// Notifikasi
define('NOTIF_WA', 'WA');
define('NOTIF_EMAIL', 'EMAIL');
define('NOTIF_QUEUE', 'QUEUE');
define('NOTIF_SENT', 'SENT');
define('NOTIF_FAILED', 'FAILED');

// Flash Message Types
define('FLASH_SUCCESS', 'success');
define('FLASH_ERROR', 'error');
define('FLASH_WARNING', 'warning');
define('FLASH_INFO', 'info');

// Permissions by Role
const ROLE_PERMISSIONS = [
    ROLE_ADMIN => [
        'dashboard.view',
        'anggota.view', 'anggota.create', 'anggota.edit', 'anggota.delete',
        'simpanan.view', 'simpanan.create',
        'pinjaman.view', 'pinjaman.verify', 'pinjaman.approve', 'pinjaman.disburse',
        'angsuran.view', 'angsuran.create',
        'kas.view', 'kas.create',
        'laporan.view',
        'setting.view', 'setting.edit',
        'audit.view',
        'user.manage'
    ],
    ROLE_TELLER => [
        'dashboard.view',
        'anggota.view',
        'simpanan.view', 'simpanan.create',
        'pinjaman.view',
        'angsuran.view', 'angsuran.create',
        'kas.view'
    ],
    ROLE_KETUA => [
        'dashboard.view',
        'anggota.view',
        'pinjaman.view', 'pinjaman.approve',
        'laporan.view',
        'audit.view'
    ],
    ROLE_ANGGOTA => [
        'dashboard.view',
        'simpanan.view',
        'pinjaman.view', 'pinjaman.create'
    ]
];

/**
 * Check if user has permission
 */
function hasPermission($role, $permission) {
    return in_array($permission, ROLE_PERMISSIONS[$role] ?? []);
}

/**
 * Get all available roles
 */
function getAllRoles() {
    return [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA];
}

/**
 * Get role label for display
 */
function getRoleLabel($role) {
    $labels = [
        ROLE_ADMIN => 'Administrator',
        ROLE_TELLER => 'Teller',
        ROLE_KETUA => 'Ketua Koperasi',
        ROLE_ANGGOTA => 'Anggota'
    ];
    return $labels[$role] ?? $role;
}

/**
 * Get status label with color
 */
function getStatusBadge($status, $type = 'anggota') {
    $badges = [
        'anggota' => [
            STATUS_ANGGOTA_AKTIF => '<span class="badge bg-success">Aktif</span>',
            STATUS_ANGGOTA_NONAKTIF => '<span class="badge bg-warning">Non-Aktif</span>',
            STATUS_ANGGOTA_KELUAR => '<span class="badge bg-danger">Keluar</span>',
        ],
        'pinjaman' => [
            PINJAMAN_DIAJUKAN => '<span class="badge bg-info">Diajukan</span>',
            PINJAMAN_DIVERIFIKASI => '<span class="badge bg-primary">Diverifikasi</span>',
            PINJAMAN_DISETUJUI => '<span class="badge bg-success">Disetujui</span>',
            PINJAMAN_DITOLAK => '<span class="badge bg-danger">Ditolak</span>',
            PINJAMAN_DICAIRKAN => '<span class="badge bg-primary">Dicairkan</span>',
            PINJAMAN_BERJALAN => '<span class="badge bg-warning">Berjalan</span>',
            PINJAMAN_LUNAS => '<span class="badge bg-success">Lunas</span>',
        ]
    ];
    
    return $badges[$type][$status] ?? "<span class='badge bg-secondary'>{$status}</span>";
}