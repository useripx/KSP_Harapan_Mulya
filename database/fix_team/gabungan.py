import re

def merge_sql():
    path_yogi = r'c:\laragon\www\Ksp_Koperasinat\database\fix_team\ksp_koperasinat_yogi.sql'
    path_fix = r'c:\laragon\www\Ksp_Koperasinat\database\fix_team\fix_team.sql'

    with open(path_yogi, 'r', encoding='utf8') as f:
        content = f.read()

    # 1. Strip all Stand-in structures (including the CREATE TABLE block for views)
    content = re.sub(r'--\s+Stand-in structure for view.*?CREATE TABLE `v_.*?\(.*?\);', '', content, flags=re.DOTALL)
    
    # 2. Strip all Indexes and Constraints
    content = re.sub(r'--\s+Indexes for dumped tables\s+--.*?(?=--\s+Constraints for dumped tables|--\s+Trigger|$)', '', content, flags=re.DOTALL)
    content = re.sub(r'--\s+Constraints for dumped tables\s+--.*?(?=--\s+Trigger|$)', '', content, flags=re.DOTALL)

    # 3. Table structures with PKs included
    schemas = {
        "users": """CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('ADMIN','PENGURUS','PENGAWAS','ANGGOTA','TELLER','MANAGER','VALIDATOR') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ANGGOTA',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "anggota": """CREATE TABLE `anggota` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `no_anggota` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('DOSEN TETAP','DOSEN KONTRAK','DOSEN TIDAK TETAP','KARYAWAN TETAP','KARYAWAN KONTRAK','KARYAWAN TIDAK TETAP') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'KARYAWAN TETAP',
  `identitas_no` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi_unit` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji` int NOT NULL DEFAULT 0,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `tgl_daftar` date NOT NULL,
  `status` enum('AKTIF','NON-AKTIF','KELUAR') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `status_validator` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `anggota_no_anggota_unique` (`no_anggota`),
  KEY `anggota_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "pinjaman": """CREATE TABLE `pinjaman` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `anggota_id` bigint UNSIGNED NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `pokok` decimal(14,2) NOT NULL,
  `tenor_bulan` int UNSIGNED NOT NULL,
  `metode` enum('FLAT','MENURUN','ANUITAS') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FLAT',
  `bunga_persen_bln` decimal(5,2) NOT NULL DEFAULT '1.50',
  `potongan_admin` decimal(14,2) NOT NULL DEFAULT '0.00',
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('DIAJUKAN','DIVERIFIKASI','DISETUJUI','DITOLAK','DICAIRKAN','BERJALAN','LUNAS') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DIAJUKAN',
  `tgl_disetujui` date DEFAULT NULL,
  `tgl_cair` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `verifikasi_oleh` bigint UNSIGNED DEFAULT NULL,
  `tgl_verifikasi` datetime DEFAULT NULL,
  `catatan_verifikasi` text COLLATE utf8mb4_unicode_ci,
  `approve_oleh` bigint UNSIGNED DEFAULT NULL,
  `catatan_approve` text COLLATE utf8mb4_unicode_ci,
  `cair_oleh` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pinjaman_anggota_id_foreign` (`anggota_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "angsuran": """CREATE TABLE `angsuran` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pinjaman_id` bigint UNSIGNED NOT NULL,
  `angsuran_ke` int UNSIGNED NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `pokok_bayar` decimal(14,2) NOT NULL DEFAULT '0.00',
  `bunga_bayar` decimal(14,2) NOT NULL DEFAULT '0.00',
  `denda` decimal(14,2) NOT NULL DEFAULT '0.00',
  `total` decimal(14,2) NOT NULL,
  `diterima_oleh` bigint UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `angsuran_pinjaman_id_foreign` (`pinjaman_id`),
  KEY `angsuran_diterima_oleh_foreign` (`diterima_oleh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "audit_logs": """CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `aksi` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objek` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objek_id` bigint UNSIGNED DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "kas_transaksi": """CREATE TABLE `kas_transaksi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipe` enum('KAS_MASUK','KAS_KELUAR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` enum('SIMPANAN','PENCAIRAN_PINJAMAN','ANGSURAN','OPERASIONAL','LAINNYA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_table` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint UNSIGNED DEFAULT NULL,
  `jumlah` decimal(14,2) NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_oleh` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kas_transaksi_dibuat_oleh_foreign` (`dibuat_oleh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "pinjaman_approval": """CREATE TABLE `pinjaman_approval` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pinjaman_id` bigint UNSIGNED NOT NULL,
  `oleh_user_id` bigint UNSIGNED NOT NULL,
  `keputusan` enum('SETUJU','TOLAK') COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pinjaman_approval_pinjaman_id_foreign` (`pinjaman_id`),
  KEY `pinjaman_approval_oleh_user_id_foreign` (`oleh_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "pinjaman_jadwal": """CREATE TABLE `pinjaman_jadwal` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pinjaman_id` bigint UNSIGNED NOT NULL,
  `angsuran_ke` int UNSIGNED NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `pokok_tagih` decimal(14,2) NOT NULL DEFAULT '0.00',
  `bunga_tagih` decimal(14,2) NOT NULL DEFAULT '0.00',
  `total_tagih` decimal(14,2) NOT NULL,
  `status` enum('BELUM','BAYAR') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BELUM',
  PRIMARY KEY (`id`),
  KEY `pinjaman_jadwal_pinjaman_id_foreign` (`pinjaman_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "setting_koperasi": """CREATE TABLE `setting_koperasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_koperasi` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_telp` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bunga_simpanan_persen_thn` decimal(5,2) NOT NULL DEFAULT '6.00',
  `bunga_pinjaman_persen_bln` decimal(5,2) NOT NULL DEFAULT '1.50',
  `bunga_jangka_pendek` decimal(5,2) DEFAULT '1.50',
  `bunga_jangka_panjang` decimal(5,2) DEFAULT '1.00',
  `admin_pinjaman_persen` decimal(5,2) NOT NULL DEFAULT '1.00',
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "simpanan_transaksi": """CREATE TABLE `simpanan_transaksi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `anggota_id` bigint UNSIGNED NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipe` enum('SETORAN','PENARIKAN','BUNGA','ADMIN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_simpanan` enum('POKOK','WAJIB','SUKARELA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(14,2) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_oleh` bigint UNSIGNED DEFAULT NULL,
  `tujuan_anggota_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `simpanan_transaksi_anggota_id_foreign` (`anggota_id`),
  KEY `simpanan_transaksi_dibuat_oleh_foreign` (`dibuat_oleh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""",
        "notifikasi": """CREATE TABLE `notifikasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `pesan` text,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"""
    }

    # 4. Replace table creations
    for table, schema in schemas.items():
        content = re.sub(rf'CREATE TABLE `{table}` \(.*?\);', schema, content, flags=re.DOTALL)
        content = content.replace(f"DROP TABLE IF EXISTS `{table}`;", "")
        content = content.replace(f"CREATE TABLE `{table}`", f"DROP TABLE IF EXISTS `{table}`;\nCREATE TABLE `{table}`")

    # 5. Handle Views (Real creation)
    views = ["v_ringkasan_pinjaman", "v_saldo_simpanan", "v_tunggakan"]
    for v in views:
        content = content.replace(f"DROP VIEW IF EXISTS `{v}`;", "")
        content = content.replace(f"DROP TABLE IF EXISTS `{v}`;", "")
        content = re.sub(rf'CREATE ALGORITHM=.*? VIEW `{v}`', f'DROP VIEW IF EXISTS `{v}`;\nDROP TABLE IF EXISTS `{v}`;\nCREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `{v}`', content)

    # 6. Data merging (Member 20, User 0)
    anggota_insert = """INSERT INTO `anggota` (`id`, `user_id`, `no_anggota`, `nama`, `tipe`, `identitas_no`, `prodi_unit`, `no_hp`, `gaji`, `alamat`, `tgl_daftar`, `status`, `status_validator`, `created_at`, `updated_at`) VALUES
(1, 4, 'A001', 'Ahmad Rizki', 'KARYAWAN TETAP', '3578012345670001', 'Teknik Informatika', '081234567890', 0, 'Jl. Merdeka No. 10, Surabaya', '2024-01-15', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(2, 5, 'A002', 'Siti Nurhaliza', 'DOSEN TETAP', '3578012345670002', 'Fakultas Ekonomi', '081234567891', 0, 'Jl. Pahlawan No. 25, Surabaya', '2024-02-20', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(3, 6, 'A003', 'Budi Santoso', 'KARYAWAN TETAP', '3578012345670003', 'Administrasi', '081234567892', 0, 'Jl. Pemuda No. 30, Surabaya', '2024-03-10', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(4, 7, 'A004', 'Dewi Lestari', 'KARYAWAN TETAP', '3578012345670004', 'Manajemen', '081234567893', 0, 'Jl. Sudirman No. 15, Surabaya', '2024-04-05', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(5, 8, 'A005', 'Eko Prasetyo', 'KARYAWAN TETAP', '3578012345670005', '-', '081234567894', 0, 'Jl. Diponegoro No. 45, Surabaya', '2024-05-12', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(6, NULL, 'A006', 'Fitri Handayani', 'KARYAWAN TETAP', '3578012345670006', 'Teknik Sipil', '081234567895', 0, 'Jl. Gatot Subroto No. 20, Surabaya', '2024-06-18', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(7, NULL, 'A007', 'Gilang Ramadhan', 'DOSEN TETAP', '3578012345670007', 'Fakultas Hukum', '081234567896', 0, 'Jl. Ahmad Yani No. 12, Surabaya', '2024-07-22', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(8, NULL, 'A008', 'Hana Putri', 'KARYAWAN TETAP', '3578012345670008', 'Sistem Informasi', '081234567897', 0, 'Jl. Basuki Rahmat No. 8, Surabaya', '2024-08-30', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(9, NULL, 'A009', 'Irfan Hakim', 'KARYAWAN TETAP', '3578012345670009', 'IT Support', '081234567898', 0, 'Jl. Veteran No. 5, Surabaya', '2024-09-14', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(10, NULL, 'A010', 'Julia Rahayu', 'KARYAWAN TETAP', '3578012345670010', '-', '081234567899', 0, 'Jl. Raya Darmo No. 100, Surabaya', '2024-10-20', 'AKTIF', 0, '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(12, 11, 'YA0001', 'Yogi Ario P', 'DOSEN TETAP', '2313020004', 'Teknik Informatika', '081358113087', 0, 'LAMONG, BADAS', '2026-03-15', 'AKTIF', 0, '2026-03-15 10:21:47', '2026-05-06 16:42:43'),
(13, 12, 'BM0001', 'Budi Macet', 'KARYAWAN TETAP', '3698520147898', '-', '081358975554', 0, 'Jalan Nangkka no 19 Kediri', '2025-01-01', 'AKTIF', 0, '2026-04-02 08:30:50', '2026-04-24 12:45:31'),
(14, 13, 'P0001', 'Prabroro', 'KARYAWAN TETAP', NULL, NULL, NULL, 0, NULL, '2026-04-04', 'AKTIF', 0, '2026-04-04 09:09:51', '2026-04-24 12:45:31'),
(15, 15, 'AR0001', 'Anggi Rita Kristanto', 'KARYAWAN TETAP', '7854120', '-', '08552121887', 0, 'Kediri', '2026-04-23', 'AKTIF', 0, '2026-04-23 12:58:51', '2026-04-24 12:45:31'),
(16, 17, 'AS0001', 'Ahmad Sutadji Handoyono', 'KARYAWAN KONTRAK', '----', '----', '-----', 0, '-----', '2026-04-24', 'AKTIF', 0, '2026-04-24 12:48:06', NULL),
(17, 20, 'AQ0001', 'Abdul Qadir', 'DOSEN TETAP', '123456', '-', '11111111111', 0, '-', '2026-05-02', 'AKTIF', 0, '2026-05-02 19:57:44', NULL),
(18, 21, 'Y0001', 'Yulianto', 'DOSEN TETAP', '345678', '-', '-', '-', '2026-05-02', 'AKTIF', 0, '2026-05-02 22:22:47', NULL),
(19, 22, 'Y0002', 'Yuliani', 'DOSEN TETAP', '-', '-', '-', 0, '-', '2026-05-02', 'AKTIF', 0, '2026-05-02 22:23:14', NULL),
(20, 0, 'E0001', 'eka abbie dhar,a', 'DOSEN TETAP', '2313020121', 'TEKNIK INFORMATIKA', '085732944677', 10000000, 'ABBIE NGANJOK 22', '2026-05-04', 'AKTIF', 0, '2026-05-04 15:52:54', '2026-05-05 13:17:37');"""

    content = re.sub(r'INSERT INTO `anggota` \(.*?\);', anggota_insert, content, flags=re.DOTALL)

    user_0_row = "(0, 'eka abbie dhar,a', 'e0001@ksp.local', 'E0001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ANGGOTA', 1, '2026-05-07 13:51:01', '2026-05-04 15:52:54', '2026-05-07 13:51:01'),\n"
    content = content.replace('INSERT INTO `users` (`id`, `name`, `email`, `username`, `password_hash`, `role`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES', 
                             'INSERT INTO `users` (`id`, `name`, `email`, `username`, `password_hash`, `role`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES\n' + user_0_row)

    # 7. Trigger and Header/Footer
    trigger = """
DELIMITER $$
CREATE TRIGGER `sync_status_ke_users` AFTER UPDATE ON `anggota` 
FOR EACH ROW BEGIN
    IF NEW.status = 'NON-AKTIF' OR NEW.status = 'KELUAR' THEN
        UPDATE users SET is_active = 0 WHERE id = NEW.user_id;
    ELSEIF NEW.status = 'AKTIF' THEN
        UPDATE users SET is_active = 1 WHERE id = NEW.user_id;
    END IF;
END$$
DELIMITER ;
"""
    header = "SET FOREIGN_KEY_CHECKS = 0;\nSET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\nSTART TRANSACTION;\n"
    footer = f"\n{trigger}\nSET FOREIGN_KEY_CHECKS = 1;\nCOMMIT;"

    # Final cleanup of remaining index/constraints
    content = re.sub(r'ALTER TABLE `.*?` ADD PRIMARY KEY \(.*?\);', '', content)
    content = re.sub(r'ALTER TABLE `.*?` MODIFY `id` .*?AUTO_INCREMENT.*?;', '', content)

    final_content = header + content + footer
    
    with open(path_fix, 'w', encoding='utf8') as f:
        f.write(final_content)

if __name__ == "__main__":
    merge_sql()
