import re

def merge_sql():
    path_yogi = r'c:\laragon\www\Ksp_Koperasinat\database\fix_team\ksp_koperasinat_yogi.sql'
    path_fix = r'c:\laragon\www\Ksp_Koperasinat\database\fix_team\fix_team.sql'

    with open(path_yogi, 'r', encoding='utf8') as f:
        content = f.read()

    # 1. Clean structure
    content = re.sub(r'--\s+Stand-in structure for view.*?CREATE TABLE `v_.*?\(.*?\);', '', content, flags=re.DOTALL)
    content = re.sub(r'--\s+Indexes for dumped tables\s+--.*?(?=--\s+Constraints for dumped tables|--\s+Trigger|$)', '', content, flags=re.DOTALL)
    content = re.sub(r'--\s+Constraints for dumped tables\s+--.*?(?=--\s+Trigger|$)', '', content, flags=re.DOTALL)
    
    content = re.sub(r'CREATE TABLE `(.*?)`', r'DROP TABLE IF EXISTS `\1`;\nCREATE TABLE `\1`', content)

    # 2. Table Schemas
    schemas = {
        "users": """CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('ADMIN','PENGURUS','PENGAWAS','ANGGOTA','TELLER','MANAGER','VALIDATOR','BAU') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ANGGOTA',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"""
    }

    for table, schema in schemas.items():
        content = re.sub(rf'DROP TABLE IF EXISTS `{table}`;', '', content)
        content = re.sub(rf'CREATE TABLE `{table}` \(.*?\);', '', content, flags=re.DOTALL)
        content += f"\nDROP TABLE IF EXISTS `{table}`;\n{schema}\n"

    # 3. Restore USERS
    admin_hash = '$2y$12$sKVMml5St7Y.FCpSz/p0gOud/Xr1CEtvfJRRBXWmdLu0htPAnZI8a'
    user_0_row = "(0, 'eka abbie dhar,a', 'e0001@ksp.local', 'E0001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ANGGOTA', 1, '2026-05-07 13:51:01', '2026-05-04 15:52:54', '2026-05-07 13:51:01'),"
    
    users_insert = f"""
INSERT INTO `users` (`id`, `name`, `email`, `username`, `password_hash`, `role`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES
{user_0_row}
(1, 'Administrator', 'admin@ksp.com', 'admin', '{admin_hash}', 'VALIDATOR', 1, '2026-05-06 16:46:29', '2026-03-15 09:45:52', '2026-05-06 16:46:29'),
(2, 'BAU', 'bau@ksp.com', 'bau', '$2y$12$nozQxoXgzIQ4hZs1RxhpheEsVwl1/SBEmba8ZfUYjpAsD4dtiQA3i', 'BAU', 1, '2026-05-07 14:28:52', '2026-03-15 09:45:52', '2026-05-07 14:28:52'),
(3, 'Manager', 'manager@ksp.com', 'ketua', '$2y$12$lfAiODopbk0p4th1BiMHZOUCFN8S5Rnkm3hz/5.s7W.yCWBKHAzIW', 'MANAGER', 1, '2026-05-02 04:08:00', '2026-03-15 09:45:52', '2026-05-02 04:08:00'),
(4, 'Ahmad Rizki', 'ahmad@example.com', 'ahmad', '$2y$12$1k0P2C.TFte9JlsQinORcet5Dw0R9a7GnTNidm9nLsWAm0zzbv8dK', 'ANGGOTA', 1, '2026-04-02 09:42:24', '2026-03-15 09:45:52', '2026-04-21 11:29:40'),
(5, 'Siti Nurhaliza', 'siti@example.com', 'siti', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-03-15 09:45:59'),
(6, 'Budi Santoso', 'budi@example.com', 'budi', '$2y$12$lX2fXW.OZPzm3u0bNx7/MOPfIXf57xe5jpiGrCbUqBbEw7zD3AfrC', 'ANGGOTA', 1, '2026-05-02 22:51:56', '2026-03-15 09:45:52', '2026-05-02 22:51:56'),
(7, 'Dewi Lestari', 'dewi@example.com', 'dewi', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-03-15 10:30:05'),
(8, 'Eko Prasetyo', 'eko@example.com', 'eko', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-04-20 14:40:12'),
(9, 'Yogi Ario', 'yogi@ksp.com', 'yogi', '$2y$12$nxQLiXoHk5Rqca.XWwjwv.PYkFRfFpK0R14SoO3R6jgsCP3clPF5m', 'VALIDATOR', 1, '2026-04-21 09:52:01', '2026-03-15 09:48:16', '2026-04-21 20:09:09'),
(11, 'Yogi Ario P', '26031500001@ksp.com', '26031500001', '$2y$12$SkASdMaZH/E0RX3w0w7kSOJ7jjAMv1NAPeerqrLI8C45fd3sosPie', 'ANGGOTA', 1, '2026-04-01 13:41:08', '2026-03-15 10:21:47', '2026-04-01 13:41:08'),
(12, 'Budi Manjalu', 'budiman@ksp.com', 'budiman', '$2y$12$isU/1sB8uQ/fTURT60qZiuvIADb1KUg4bXKIJxrDO10fB.6cGBk5a', 'ANGGOTA', 1, '2026-04-02 13:04:36', '2026-04-02 08:30:50', '2026-04-02 13:04:36'),
(13, 'Prabroro', NULL, '26040200003', '$2y$12$uc2//9hDGkJdvVes06XnUu3U54S7tyjYpPZW6q0qX14P4OENRpkOu', 'ANGGOTA', 1, '2026-04-04 09:46:01', '2026-04-04 09:09:51', '2026-04-04 09:46:01'),
(15, 'Anggi Rita Kristanto', 'ar0001@ksp.local', 'AR0001', '$2y$12$yB4KsqKpMECkwZFXflY5DOQekGMK9hdv3dHkKL8tk330.LiGNqxJG', 'ANGGOTA', 1, NULL, '2026-04-23 12:58:51', NULL),
(17, 'Ahmad Sutadji Handoyono', 'as0001@ksp.local', 'AS0001', '$2y$12$qjqguhPzI9V21BWvy7LhAeRiRo2zpAPLTfNOddTRNLlkwygqeTHjS', 'ANGGOTA', 1, '2026-04-24 12:48:58', '2026-04-24 12:48:06', '2026-04-24 12:48:58'),
(18, 'Validator', 'validator@KSP.com', 'validator1', '$2y$12$9Cvl3MTDEG6DHHpuaZvxbeVo9FmUC7FqeUIYBKdPLLtFLcUc/2/JS', 'ANGGOTA', 1, '2026-05-02 22:07:07', '2026-05-02 04:05:55', '2026-05-02 22:13:35'),
(19, 'Manager', 'bendahara@KSP.com', 'manager', '$2y$12$6aIu/E6rpkwtB7Luu.cffev93aQnlsWH53GLkXfY/a17svNR6zkCC', 'MANAGER', 1, '2026-05-07 13:35:31', '2026-05-02 04:19:18', '2026-05-07 13:35:31'),
(20, 'Abdul Qadir', 'aq0001@ksp.local', 'AQ0001', '$2y$12$dSfYc27AE4tMiSocWA8.Ve9RKGTSbkQHkiLyWXiIglxLbxFr0cm..', 'ANGGOTA', 1, NULL, '2026-05-02 19:57:44', NULL),
(21, 'Yulianto', 'y0001@ksp.local', 'Y0001', '$2y$12$Z4MfxQzVfPK03wbSzVtzoOydgsjeCSjun4WbB4XA2knW87yLXxXbq', 'ANGGOTA', 1, NULL, '2026-05-02 22:22:47', NULL),
(22, 'Yuliani', 'y0002@ksp.local', 'Y0002', '$2y$12$tdb9VZ/KNs4lz3vVEBkHz.1Y7t5pDEuXtZ5kIPMUxbWwNi39y5A3G', 'ANGGOTA', 1, NULL, '2026-05-02 22:23:14', NULL),
(23, 'Iklima Test', 'iklima@test.com', 'iklima', '$2y$12$BqAbpkSTivbGnLhaUjIN4u7r7fMkbe2zbpk7iEyja7aD6A.RaplEO', 'VALIDATOR', 1, NULL, '2026-05-02 22:54:41', NULL);
"""
    content += users_insert

    # 4. Restore ANGGOTA (15 columns fixed)
    anggota_insert = """
INSERT INTO `anggota` (`id`, `user_id`, `no_anggota`, `nama`, `tipe`, `identitas_no`, `prodi_unit`, `no_hp`, `gaji`, `alamat`, `tgl_daftar`, `status`, `status_validator`, `created_at`, `updated_at`) VALUES
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
(18, 21, 'Y0001', 'Yulianto', 'DOSEN TETAP', '345678', '-', '-', 0, '-', '2026-05-02', 'AKTIF', 0, '2026-05-02 22:22:47', NULL),
(19, 22, 'Y0002', 'Yuliani', 'DOSEN TETAP', '-', '-', '-', 0, '-', '2026-05-02', 'AKTIF', 0, '2026-05-02 22:23:14', NULL),
(20, 0, 'E0001', 'eka abbie dhar,a', 'DOSEN TETAP', '2313020121', 'TEKNIK INFORMATIKA', '085732944677', 10000000, 'ABBIE NGANJOK 22', '2026-05-04', 'AKTIF', 0, '2026-05-04 15:52:54', '2026-05-05 13:17:37');
"""
    content = re.sub(r'INSERT INTO `anggota` \(.*?\);', '', content, flags=re.DOTALL)
    content += f"\n{anggota_insert}\n"

    # 5. Handle Views
    views = ["v_ringkasan_pinjaman", "v_saldo_simpanan", "v_tunggakan"]
    for v in views:
        content = content.replace(f"DROP VIEW IF EXISTS `{v}`;", "")
        content = content.replace(f"DROP TABLE IF EXISTS `{v}`;", "")
        content = re.sub(rf'CREATE ALGORITHM=.*? VIEW `{v}`', f'DROP VIEW IF EXISTS `{v}`;\nDROP TABLE IF EXISTS `{v}`;\nCREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `{v}`', content)

    # 6. Final Trigger & Footer
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

    # Cleanup leftover PKs
    content = re.sub(r'ALTER TABLE `.*?` ADD PRIMARY KEY \(.*?\);', '', content)
    content = re.sub(r'ALTER TABLE `.*?` MODIFY `id` .*?AUTO_INCREMENT.*?;', '', content)

    with open(path_fix, 'w', encoding='utf8') as f:
        f.write(header + content + footer)

if __name__ == "__main__":
    merge_sql()
