-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 15, 2026 at 06:52 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ksp_koperasinat`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `no_anggota` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('MAHASISWA','DOSEN','STAF','UMUM') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UMUM',
  `identitas_no` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi_unit` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `tgl_daftar` date NOT NULL,
  `status` enum('AKTIF','NONAKTIF','KELUAR') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `user_id`, `no_anggota`, `nama`, `tipe`, `identitas_no`, `prodi_unit`, `no_hp`, `alamat`, `tgl_daftar`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'A001', 'Ahmad Rizki', 'MAHASISWA', '3578012345670001', 'Teknik Informatika', '081234567890', 'Jl. Merdeka No. 10, Surabaya', '2024-01-15', 'AKTIF', '2026-03-15 09:45:52', NULL),
(2, 5, 'A002', 'Siti Nurhaliza', 'DOSEN', '3578012345670002', 'Fakultas Ekonomi', '081234567891', 'Jl. Pahlawan No. 25, Surabaya', '2024-02-20', 'AKTIF', '2026-03-15 09:45:52', NULL),
(3, 6, 'A003', 'Budi Santoso', 'STAF', '3578012345670003', 'Administrasi', '081234567892', 'Jl. Pemuda No. 30, Surabaya', '2024-03-10', 'AKTIF', '2026-03-15 09:45:52', NULL),
(4, 7, 'A004', 'Dewi Lestari', 'MAHASISWA', '3578012345670004', 'Manajemen', '081234567893', 'Jl. Sudirman No. 15, Surabaya', '2024-04-05', 'AKTIF', '2026-03-15 09:45:52', NULL),
(5, 8, 'A005', 'Eko Prasetyo', 'UMUM', '3578012345670005', '-', '081234567894', 'Jl. Diponegoro No. 45, Surabaya', '2024-05-12', 'AKTIF', '2026-03-15 09:45:52', NULL),
(6, NULL, 'A006', 'Fitri Handayani', 'MAHASISWA', '3578012345670006', 'Teknik Sipil', '081234567895', 'Jl. Gatot Subroto No. 20, Surabaya', '2024-06-18', 'AKTIF', '2026-03-15 09:45:52', NULL),
(7, NULL, 'A007', 'Gilang Ramadhan', 'DOSEN', '3578012345670007', 'Fakultas Hukum', '081234567896', 'Jl. Ahmad Yani No. 12, Surabaya', '2024-07-22', 'AKTIF', '2026-03-15 09:45:52', NULL),
(8, NULL, 'A008', 'Hana Putri', 'MAHASISWA', '3578012345670008', 'Sistem Informasi', '081234567897', 'Jl. Basuki Rahmat No. 8, Surabaya', '2024-08-30', 'AKTIF', '2026-03-15 09:45:52', NULL),
(9, NULL, 'A009', 'Irfan Hakim', 'STAF', '3578012345670009', 'IT Support', '081234567898', 'Jl. Veteran No. 5, Surabaya', '2024-09-14', 'AKTIF', '2026-03-15 09:45:52', NULL),
(10, NULL, 'A010', 'Julia Rahayu', 'UMUM', '3578012345670010', '-', '081234567899', 'Jl. Raya Darmo No. 100, Surabaya', '2024-10-20', 'AKTIF', '2026-03-15 09:45:52', NULL),
(12, 11, '26031500001', 'Yogi Ario P', 'MAHASISWA', '2313020004', 'Teknik Informatika', '081358113087', 'LAMONG, BADAS', '2026-03-15', 'AKTIF', '2026-03-15 10:21:47', NULL),
(13, 12, '26040200002', 'Budi Macet', 'UMUM', '3698520147898', '-', '081358975554', 'Jalan Nangkka no 19 Kediri', '2025-01-01', 'AKTIF', '2026-04-02 08:30:50', '2026-04-02 13:06:56'),
(14, 13, '26040200003', 'Prabroro', 'UMUM', NULL, NULL, NULL, NULL, '2026-04-04', 'AKTIF', '2026-04-04 09:09:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE `angsuran` (
  `id` bigint UNSIGNED NOT NULL,
  `pinjaman_id` bigint UNSIGNED NOT NULL,
  `angsuran_ke` int UNSIGNED NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `pokok_bayar` decimal(14,2) NOT NULL DEFAULT '0.00',
  `bunga_bayar` decimal(14,2) NOT NULL DEFAULT '0.00',
  `denda` decimal(14,2) NOT NULL DEFAULT '0.00',
  `total` decimal(14,2) NOT NULL,
  `diterima_oleh` bigint UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `angsuran`
--

INSERT INTO `angsuran` (`id`, `pinjaman_id`, `angsuran_ke`, `tanggal_bayar`, `pokok_bayar`, `bunga_bayar`, `denda`, `total`, `diterima_oleh`, `keterangan`, `created_at`) VALUES
(1, 1, 1, '2024-12-10', 416667.00, 75000.00, 0.00, 491667.00, 2, 'Pembayaran angsuran ke-1', '2024-12-10 10:00:00'),
(2, 2, 1, '2024-12-20', 416667.00, 150000.00, 0.00, 566667.00, 2, 'Pembayaran angsuran ke-1', '2024-12-20 11:00:00'),
(3, 1, 2, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(4, 1, 3, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(5, 1, 4, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(6, 1, 5, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(7, 1, 6, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(8, 1, 7, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(9, 1, 8, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(10, 1, 9, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(11, 1, 10, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(12, 1, 11, '2026-03-31', 416667.00, 75000.00, 0.00, 491667.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(13, 1, 12, '2026-03-31', 416665.00, 75000.00, 0.00, 491665.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(14, 2, 2, '2026-03-31', 416667.00, 143750.00, 0.00, 560417.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(15, 2, 3, '2026-03-31', 416667.00, 137500.00, 0.00, 554167.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(16, 3, 1, '2026-03-31', 500000.00, 45000.00, 0.00, 545000.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:15:34'),
(17, 3, 2, '2026-03-31', 500000.00, 45000.00, 0.00, 545000.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:34:43'),
(18, 3, 3, '2026-03-31', 500000.00, 45000.00, 0.00, 545000.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:34:43'),
(19, 3, 4, '2026-03-31', 500000.00, 45000.00, 0.00, 545000.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:34:43'),
(20, 3, 5, '2026-03-31', 500000.00, 45000.00, 0.00, 545000.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:34:43'),
(21, 3, 6, '2026-03-31', 500000.00, 45000.00, 0.00, 545000.00, NULL, 'Lunas by Autodebet Sistem', '2026-03-31 10:34:43'),
(22, 9, 1, '2025-02-15', 1000000.00, 0.00, 50000.00, 1050000.00, NULL, NULL, '2026-04-02 08:30:50'),
(23, 9, 2, '2025-02-15', 1000000.00, 0.00, 50000.00, 1050000.00, NULL, NULL, '2026-04-02 08:30:50'),
(24, 9, 3, '2025-02-15', 1000000.00, 0.00, 50000.00, 1050000.00, NULL, NULL, '2026-04-02 08:30:50'),
(25, 9, 4, '2025-02-15', 1000000.00, 0.00, 50000.00, 1050000.00, NULL, NULL, '2026-04-02 08:30:50'),
(26, 9, 5, '2025-02-15', 1000000.00, 0.00, 50000.00, 1050000.00, NULL, NULL, '2026-04-02 08:30:50'),
(27, 14, 1, '2026-04-09', 416666.67, 75000.00, 0.00, 491666.67, 1, 'TUNAI', '2026-04-09 19:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `aksi` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objek` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objek_id` bigint UNSIGNED DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `aksi`, `objek`, `objek_id`, `detail`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 09:47:13'),
(2, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 09:48:49'),
(3, 9, 'LOGIN', 'users', 9, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 09:48:56'),
(4, 9, 'LOGOUT', 'users', 9, 'User Yogi Ario logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:11:27'),
(5, 9, 'LOGIN', 'users', 9, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:11:52'),
(6, 9, 'LOGOUT', 'users', 9, 'User Yogi Ario logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:12:30'),
(7, NULL, 'LOGIN', 'users', 10, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:12:48'),
(8, NULL, 'LOGOUT', 'users', 10, 'User Yogi Ario P logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:15:07'),
(9, 9, 'LOGIN', 'users', 9, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:15:13'),
(10, 9, 'LOGOUT', 'users', 9, 'User Yogi Ario logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:21:59'),
(11, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: 26031500001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:22:09'),
(12, 11, 'LOGIN', 'users', 11, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:22:17'),
(13, 11, 'LOGOUT', 'users', 11, 'User Yogi Ario P logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:22:40'),
(14, 9, 'LOGIN', 'users', 9, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:22:48'),
(15, 9, 'LOGOUT', 'users', 9, 'User Yogi Ario logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:23:22'),
(16, 11, 'LOGIN', 'users', 11, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:23:30'),
(17, 11, 'LOGOUT', 'users', 11, 'User Yogi Ario P logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:29:27'),
(18, 9, 'LOGIN', 'users', 9, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:29:36'),
(19, 9, 'LOGOUT', 'users', 9, 'User Yogi Ario logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:33:44'),
(20, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:33:52'),
(21, 9, 'LOGIN', 'users', 9, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:38:39'),
(22, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-15 10:41:11'),
(23, 9, 'LOGOUT', 'users', 9, 'User Yogi Ario logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:46:18'),
(24, 9, 'LOGIN', 'users', 9, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:46:44'),
(25, 9, 'LOGOUT', 'users', 9, 'User Yogi Ario logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:47:13'),
(26, 11, 'LOGIN', 'users', 11, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:47:18'),
(27, 11, 'LOGOUT', 'users', 11, 'User Yogi Ario P logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:47:32'),
(28, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-15 10:47:39'),
(29, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-30 08:16:23'),
(30, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-30 08:31:14'),
(31, 11, 'LOGIN', 'users', 11, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-30 08:31:23'),
(32, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 09:59:28'),
(33, 4, 'LOGOUT', 'users', 4, 'User Ahmad Rizki logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 09:59:43'),
(34, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 09:59:49'),
(35, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 10:16:58'),
(36, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 10:17:04'),
(37, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 10:17:16'),
(38, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 10:17:24'),
(39, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 10:19:46'),
(40, 11, 'LOGIN', 'users', 11, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 10:19:51'),
(41, 11, 'LOGOUT', 'users', 11, 'User Yogi Ario P logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 10:22:56'),
(42, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 10:23:03'),
(43, 1, 'VERIFIKASI_PINJAMAN', 'pinjaman', 4, 'Pinjaman #4 telah diverifikasi.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 12:26:36'),
(44, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 12:26:46'),
(45, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 12:26:52'),
(46, 3, 'APPROVE_PINJAMAN', 'pinjaman', 4, 'Pinjaman #4 telah disetujui.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 12:27:16'),
(47, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 12:27:25'),
(48, 11, 'LOGIN', 'users', 11, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 12:27:34'),
(49, 11, 'PENGAJUAN_PINJAMAN', 'pinjaman', 6, 'Pengajuan pinjaman baru sebesar Rp 500.000.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 12:27:54'),
(50, 11, 'LOGOUT', 'users', 11, 'User Yogi Ario P logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-03-31 12:28:14'),
(51, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 12:38:20'),
(52, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:03:01'),
(53, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:03:21'),
(54, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:05:36'),
(55, 11, 'LOGIN', 'users', 11, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:05:40'),
(56, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:06:03'),
(57, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:06:16'),
(58, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:07:38'),
(59, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:07:52'),
(60, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:08:20'),
(61, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 13:11:48'),
(62, 11, 'LOGOUT', 'users', 11, 'User Yogi Ario P logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:16:17'),
(63, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:16:27'),
(64, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:23:20'),
(65, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: teller01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:23:28'),
(66, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:23:35'),
(67, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:25:13'),
(68, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:25:21'),
(69, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:33:04'),
(70, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:33:13'),
(71, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:33:19'),
(72, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: yogi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:33:31'),
(73, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:38:32'),
(74, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:39:56'),
(75, 11, 'LOGIN', 'users', 11, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:41:08'),
(76, 11, 'LOGOUT', 'users', 11, 'User Yogi Ario P logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:43:58'),
(77, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 13:44:04'),
(78, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 15:26:27'),
(79, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 15:27:02'),
(80, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 15:28:08'),
(81, 2, 'VERIFIKASI_PINJAMAN', 'pinjaman', 6, 'Pinjaman #6 telah diverifikasi.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 15:28:23'),
(82, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 15:31:42'),
(83, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-01 15:31:58'),
(84, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-01 15:45:11'),
(85, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:17:05'),
(86, 6, 'PENGAJUAN_PINJAMAN', 'pinjaman', 7, 'Pengajuan pinjaman baru sebesar Rp 50.000.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:17:29'),
(87, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:17:38'),
(88, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:17:52'),
(89, 2, 'VERIFIKASI_PINJAMAN', 'pinjaman', 7, 'Pinjaman #7 telah diverifikasi.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:18:20'),
(90, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:18:28'),
(91, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:18:40'),
(92, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:19:06'),
(93, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:19:13'),
(94, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:19:47'),
(95, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:19:53'),
(96, 4, 'PENGAJUAN_PINJAMAN', 'pinjaman', 8, 'Pengajuan pinjaman baru sebesar Rp 5.000.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:20:19'),
(97, 4, 'LOGOUT', 'users', 4, 'User Ahmad Rizki logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:20:23'),
(98, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: teller1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:20:30'),
(99, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: teller1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:20:36'),
(100, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:20:44'),
(101, 2, 'VERIFIKASI_PINJAMAN', 'pinjaman', 8, 'Pinjaman #8 telah diverifikasi.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:21:02'),
(102, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:21:10'),
(103, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:21:24'),
(104, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:21:47'),
(105, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:21:56'),
(106, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 08:35:15'),
(107, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:41:23'),
(108, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:41:35'),
(109, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:41:56'),
(110, 12, 'LOGIN', 'users', 12, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:43:12'),
(111, 12, 'PENGAJUAN_PINJAMAN', 'pinjaman', 12, 'Pengajuan pinjaman baru sebesar Rp 5.000.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:43:49'),
(112, 12, 'LOGOUT', 'users', 12, 'User Budi Manjalu logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:43:55'),
(113, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: teller1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:44:02'),
(114, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:44:09'),
(115, 2, 'VERIFIKASI_PINJAMAN', 'pinjaman', 12, 'Pinjaman #12 telah diverifikasi.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:45:02'),
(116, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:45:07'),
(117, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 08:45:13'),
(118, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:13:50'),
(119, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:14:05'),
(120, 4, 'PENGAJUAN_PINJAMAN', 'pinjaman', 13, 'Pengajuan pinjaman baru sebesar Rp 500.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:14:40'),
(121, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:15:35'),
(122, 2, 'VERIFIKASI_PINJAMAN', 'pinjaman', 13, 'Pinjaman #13 telah diverifikasi.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 09:16:05'),
(123, 4, 'LOGOUT', 'users', 4, 'User Ahmad Rizki logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:16:22'),
(124, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:16:28'),
(125, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:16:54'),
(126, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:17:00'),
(127, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:21:23'),
(128, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:21:31'),
(129, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:30:24'),
(130, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:30:30'),
(131, 4, 'LOGOUT', 'users', 4, 'User Ahmad Rizki logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:31:30'),
(132, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:31:36'),
(133, 4, 'LOGOUT', 'users', 4, 'User Ahmad Rizki logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:31:41'),
(134, 12, 'LOGIN', 'users', 12, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:31:53'),
(135, 12, 'LOGOUT', 'users', 12, 'User Budi Manjalu logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:42:18'),
(136, 4, 'LOGIN', 'users', 4, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 09:42:24'),
(137, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-02 12:58:13'),
(138, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 12:59:21'),
(139, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 13:04:30'),
(140, 12, 'LOGIN', 'users', 12, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 13:04:36'),
(141, 12, 'LOGOUT', 'users', 12, 'User Budi Manjalu logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 13:05:41'),
(142, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-02 13:05:48'),
(143, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: Admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-03 22:31:51'),
(144, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-03 22:32:03'),
(145, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 08:49:55'),
(146, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 08:50:16'),
(147, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 08:50:22'),
(148, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 08:53:28'),
(149, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 08:53:33'),
(150, 13, 'LOGIN', 'users', 13, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-04 09:10:41'),
(151, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 09:11:42'),
(152, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: 26040200003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 09:11:52'),
(153, 13, 'LOGIN', 'users', 13, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 09:11:56'),
(154, 13, 'LOGOUT', 'users', 13, 'User Prabroro logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 09:42:26'),
(155, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 09:42:32'),
(156, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 09:45:45'),
(157, 13, 'LOGIN', 'users', 13, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-04 09:46:01'),
(158, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: adminadmin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 08:06:45'),
(159, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 08:07:05'),
(160, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 08:11:00'),
(161, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 08:13:00'),
(162, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:31:58'),
(163, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:36:13'),
(164, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:37:14'),
(165, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:39:53'),
(166, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:40:05'),
(167, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:40:23'),
(168, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:40:33'),
(169, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:42:34'),
(170, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 09:42:38'),
(171, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:46:42'),
(172, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:47:41'),
(173, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:49:34'),
(174, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:50:59'),
(175, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:53:23'),
(176, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:54:16'),
(177, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 09:55:55'),
(178, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 10:01:13'),
(179, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 10:05:12'),
(180, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 15:55:41'),
(181, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 15:56:47'),
(182, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 15:57:02'),
(183, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 15:58:03'),
(184, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 16:00:05'),
(185, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 18:07:07'),
(186, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-07 18:08:51'),
(187, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:17:55'),
(188, 1, 'PENGAJUAN_PINJAMAN', 'pinjaman', 15, 'Pengajuan pinjaman baru sebesar Rp 50.000.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:20:12'),
(189, 1, 'BAYAR_ANGSURAN', 'angsuran', 27, 'Pembayaran angsuran ke-1 untuk Pinjaman #14', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:20:35'),
(190, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:24:13'),
(191, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:24:23'),
(192, 2, 'VERIFIKASI_PINJAMAN', 'pinjaman', 15, 'Pinjaman #15 telah diverifikasi.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:24:55'),
(193, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:25:03'),
(194, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:25:10'),
(195, 3, 'APPROVE_PINJAMAN', 'pinjaman', 15, 'Pinjaman #15 telah disetujui.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:25:30'),
(196, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:25:42'),
(197, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-09 19:25:48'),
(198, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-10 20:26:09'),
(199, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-10 20:31:58'),
(200, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-10 20:34:16'),
(201, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-15 13:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `kas_transaksi`
--

CREATE TABLE `kas_transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipe` enum('KAS_MASUK','KAS_KELUAR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` enum('SIMPANAN','PENCAIRAN_PINJAMAN','ANGSURAN','OPERASIONAL','LAINNYA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_table` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint UNSIGNED DEFAULT NULL,
  `jumlah` decimal(14,2) NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_oleh` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kas_transaksi`
--

INSERT INTO `kas_transaksi` (`id`, `tanggal`, `tipe`, `sumber`, `ref_table`, `ref_id`, `jumlah`, `catatan`, `dibuat_oleh`) VALUES
(1, '2026-03-15 09:45:52', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 1, 500000.00, 'Setor simpanan Ahmad Rizki', 2),
(2, '2026-03-15 09:45:52', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 2, 1000000.00, 'Setor simpanan Siti Nurhaliza', 2),
(3, '2024-11-10 00:00:00', 'KAS_KELUAR', 'PENCAIRAN_PINJAMAN', 'pinjaman', 1, 4950000.00, 'Pencairan pinjaman Ahmad (Rp 5jt - admin 50rb)', 2),
(4, '2024-11-20 00:00:00', 'KAS_KELUAR', 'PENCAIRAN_PINJAMAN', 'pinjaman', 2, 9900000.00, 'Pencairan pinjaman Siti (Rp 10jt - admin 100rb)', 2),
(5, '2024-12-10 00:00:00', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 1, 491667.00, 'Pembayaran angsuran Ahmad', 2),
(6, '2024-12-20 00:00:00', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 2, 566667.00, 'Pembayaran angsuran Siti', 2),
(7, '2026-03-15 10:23:13', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 20, 50000000.00, 'Setoran simpanan: Nabung', 9),
(8, '2026-03-15 10:30:44', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 21, 5000000.00, 'Setoran simpanan: -', 9),
(9, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 3, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-2)', NULL),
(10, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 4, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-3)', NULL),
(11, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 5, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-4)', NULL),
(12, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 6, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-5)', NULL),
(13, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 7, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-6)', NULL),
(14, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 8, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-7)', NULL),
(15, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 9, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-8)', NULL),
(16, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 10, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-9)', NULL),
(17, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 11, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-10)', NULL),
(18, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 12, 491667.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-11)', NULL),
(19, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 13, 491665.00, 'Pembayaran Autodebet An. Ahmad Rizki (Angsuran ke-12)', NULL),
(20, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 14, 560417.00, 'Pembayaran Autodebet An. Siti Nurhaliza (Angsuran ke-2)', NULL),
(21, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 15, 554167.00, 'Pembayaran Autodebet An. Siti Nurhaliza (Angsuran ke-3)', NULL),
(22, '2026-03-31 10:15:34', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 16, 545000.00, 'Pembayaran Autodebet An. Budi Santoso (Angsuran ke-1)', NULL),
(23, '2026-03-31 10:17:49', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 37, 8500000.00, 'Setoran simpanan: Tabungan + Bayar Cicilan', 1),
(24, '2026-03-31 10:19:10', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 38, 9000000.00, 'Setoran simpanan: Tabungan', 1),
(25, '2026-03-31 10:34:43', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 17, 545000.00, 'Pembayaran Autodebet An. Budi Santoso (Angsuran ke-2)', NULL),
(26, '2026-03-31 10:34:43', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 18, 545000.00, 'Pembayaran Autodebet An. Budi Santoso (Angsuran ke-3)', NULL),
(27, '2026-03-31 10:34:43', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 19, 545000.00, 'Pembayaran Autodebet An. Budi Santoso (Angsuran ke-4)', NULL),
(28, '2026-03-31 10:34:43', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 20, 545000.00, 'Pembayaran Autodebet An. Budi Santoso (Angsuran ke-5)', NULL),
(29, '2026-03-31 10:34:43', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 21, 545000.00, 'Pembayaran Autodebet An. Budi Santoso (Angsuran ke-6)', NULL),
(30, '2026-04-02 09:30:45', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 44, 50000.00, 'Setoran simpanan: nabung', 2),
(31, '2026-04-02 13:16:10', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 45, 50000.00, 'Setoran simpanan: nabung', 1),
(32, '2026-04-02 13:28:29', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 46, 35000.00, 'Setoran simpanan: nabung', 1),
(33, '2026-04-02 13:33:52', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 47, 50000.00, 'Penarikan simpanan: tes', 1),
(34, '2026-04-02 13:34:04', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 48, 35000.00, 'Penarikan simpanan: a', 1),
(35, '2026-04-02 13:34:16', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 49, 5000.00, 'Penarikan simpanan: kj', 1),
(36, '2026-04-02 13:34:27', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 50, 45000.00, 'Penarikan simpanan: cvbnm', 1),
(37, '2026-04-02 13:34:37', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 51, 50000.00, 'Penarikan simpanan: l;jh', 1),
(38, '2026-04-02 13:35:00', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 52, 50000.00, 'Penarikan simpanan: gh', 1),
(39, '2026-04-02 13:35:23', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 53, 100000.00, 'Setoran simpanan: 9', 1),
(40, '2026-04-02 13:36:06', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 54, 60000.00, 'Setoran simpanan: hj', 1),
(41, '2026-04-02 13:36:41', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 55, 450000.00, 'Setoran simpanan: lkjhg', 1),
(42, '2026-04-02 13:37:30', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 56, 80000.00, 'Setoran simpanan: hjg', 1),
(43, '2026-04-02 13:37:52', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 57, 20000.00, 'Setoran simpanan: n', 1),
(44, '2026-04-02 13:39:45', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 58, 100000.00, 'Penarikan simpanan: [[', 1),
(45, '2026-04-09 19:19:09', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 59, 50000.00, 'Setoran simpanan: -', 1),
(46, '2026-04-09 19:19:28', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 60, 20000.00, 'Penarikan simpanan: -', 1),
(47, '2026-04-09 19:20:35', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 27, 491666.67, 'Pembayaran Angsuran Ke-1 Pinjaman #14 - Prabroro', 1),
(48, '2026-04-10 20:34:36', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 61, 60000.00, 'Penarikan simpanan: butuh duit', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `pesan` text,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `tipe`, `icon`, `judul`, `pesan`, `link`, `is_read`, `created_at`) VALUES
(1, 1, 'info', 'bi-bell', 'Test Judul', 'Test Pesan', '/', 1, '2026-04-02 06:27:04'),
(7, 6, 'success', 'bi-piggy-bank', 'Simpanan Berhasil Masuk', 'Selamat! Saldo Anda masuk sebesar Rp 20.000', 'http://localhost/Ksp_Koperasinat/public/simpanan', 1, '2026-04-02 06:37:52'),
(8, 6, 'danger', 'bi-cash-stack', 'Penarikan Berhasil', 'Anda telah menarik saldo sebesar Rp 100.000', 'http://localhost/Ksp_Koperasinat/public/simpanan', 1, '2026-04-02 06:39:45'),
(9, 6, 'success', 'bi-piggy-bank', 'Simpanan Berhasil Masuk', 'Selamat! Saldo Anda masuk sebesar Rp 50.000', 'http://localhost/Ksp_Koperasinat/public/simpanan', 1, '2026-04-09 12:19:09'),
(10, 6, 'danger', 'bi-cash-stack', 'Penarikan Berhasil', 'Anda telah menarik saldo sebesar Rp 20.000', 'http://localhost/Ksp_Koperasinat/public/simpanan', 1, '2026-04-09 12:19:28'),
(11, 1, 'warning', 'bi-file-earmark-plus', 'Pengajuan Baru', 'Terdapat pengajuan pinjaman baru sebesar Rp 50.000.000', 'http://localhost/Ksp_Koperasinat/public/pinjaman/15', 1, '2026-04-09 12:20:12'),
(12, 2, 'warning', 'bi-file-earmark-plus', 'Pengajuan Baru', 'Terdapat pengajuan pinjaman baru sebesar Rp 50.000.000', 'http://localhost/Ksp_Koperasinat/public/pinjaman/15', 1, '2026-04-09 12:20:12'),
(13, 9, 'warning', 'bi-file-earmark-plus', 'Pengajuan Baru', 'Terdapat pengajuan pinjaman baru sebesar Rp 50.000.000', 'http://localhost/Ksp_Koperasinat/public/pinjaman/15', 0, '2026-04-09 12:20:12'),
(14, 3, 'primary', 'bi-person-check', 'Approval Menunggu', 'Pinjaman #15 divalidasi Teller & butuh persetujuan Anda.', 'http://localhost/Ksp_Koperasinat/public/pinjaman/15', 0, '2026-04-09 12:24:55'),
(15, 1, 'success', 'bi-cash-coin', 'Siap Dicairkan', 'Pinjaman #15 milik Budi Santoso siap dicairkan.', 'http://localhost/Ksp_Koperasinat/public/pinjaman/15', 1, '2026-04-09 12:25:30'),
(16, 2, 'success', 'bi-cash-coin', 'Siap Dicairkan', 'Pinjaman #15 milik Budi Santoso siap dicairkan.', 'http://localhost/Ksp_Koperasinat/public/pinjaman/15', 1, '2026-04-09 12:25:30'),
(17, 9, 'success', 'bi-cash-coin', 'Siap Dicairkan', 'Pinjaman #15 milik Budi Santoso siap dicairkan.', 'http://localhost/Ksp_Koperasinat/public/pinjaman/15', 0, '2026-04-09 12:25:30'),
(18, 6, 'danger', 'bi-cash-stack', 'Penarikan Berhasil', 'Anda telah menarik saldo sebesar Rp 60.000', 'http://localhost/Ksp_Koperasinat/public/simpanan', 0, '2026-04-10 13:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` bigint UNSIGNED NOT NULL,
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
  `cair_oleh` bigint UNSIGNED DEFAULT NULL
) ;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `anggota_id`, `tgl_pengajuan`, `pokok`, `tenor_bulan`, `metode`, `bunga_persen_bln`, `potongan_admin`, `tujuan`, `status`, `tgl_disetujui`, `tgl_cair`, `created_at`, `updated_at`, `verifikasi_oleh`, `tgl_verifikasi`, `catatan_verifikasi`, `approve_oleh`, `catatan_approve`, `cair_oleh`) VALUES
(1, 1, '2024-11-01', 5000000.00, 12, 'FLAT', 1.50, 50000.00, 'Modal usaha', 'LUNAS', '2024-11-05', '2024-11-10', '2024-11-01 10:00:00', '2026-03-31 10:15:34', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, '2024-11-15', 10000000.00, 24, 'MENURUN', 1.50, 100000.00, 'Renovasi rumah', 'LUNAS', '2024-11-18', '2024-11-20', '2024-11-15 11:00:00', '2026-03-31 10:15:34', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, '2024-12-01', 3000000.00, 6, 'FLAT', 1.50, 30000.00, 'Biaya pendidikan', 'LUNAS', '2024-12-03', '2024-12-05', '2024-12-01 09:00:00', '2026-03-31 10:34:43', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 5, '2025-01-02', 15000000.00, 36, 'ANUITAS', 1.50, 150000.00, 'Pengembangan usaha', 'DISETUJUI', '2026-03-31', NULL, '2025-01-02 14:00:00', '2026-03-31 12:27:16', 1, '2026-03-31 12:26:36', 'Sudah di cek', 3, 'Sudah Saya cek data sudah sesuai', NULL),
(5, 4, '2024-10-01', 2000000.00, 12, 'FLAT', 1.50, 20000.00, 'Keperluan mendesak', 'LUNAS', '2024-10-03', '2024-10-05', '2024-10-01 10:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 12, '2026-03-31', 500000000.00, 12, 'FLAT', 1.50, 0.00, 'biaya jajan', 'DIVERIFIKASI', NULL, NULL, '2026-03-31 12:27:54', '2026-04-01 15:28:23', 2, '2026-04-01 15:28:23', 'data sudah diterima', NULL, NULL, NULL),
(7, 3, '2026-04-02', 50000000.00, 24, 'FLAT', 1.50, 0.00, 'biaya perbaikan rumah', 'DIVERIFIKASI', NULL, NULL, '2026-04-02 08:17:29', '2026-04-02 08:18:20', 2, '2026-04-02 08:18:20', 'syarat sudah lengkap\r\n', NULL, NULL, NULL),
(8, 1, '2026-04-02', 5000000.00, 31, 'FLAT', 1.50, 0.00, 'biaya usaha', 'DIVERIFIKASI', NULL, NULL, '2026-04-02 08:20:19', '2026-04-02 08:21:02', 2, '2026-04-02 08:21:02', 'syarat sudah lengkap\r\n', NULL, NULL, NULL),
(9, 13, '2025-02-01', 5000000.00, 5, 'FLAT', 1.50, 0.00, NULL, 'LUNAS', NULL, NULL, '2026-04-02 08:30:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 13, '2025-10-01', 1000000.00, 2, 'FLAT', 1.50, 0.00, NULL, 'BERJALAN', NULL, NULL, '2026-04-02 08:30:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 13, '2026-04-02', 50000000.00, 12, 'FLAT', 1.50, 0.00, 'Modal usaha game center', 'DIVERIFIKASI', NULL, NULL, '2026-04-02 08:30:50', NULL, NULL, '2026-04-02 00:00:00', NULL, NULL, NULL, NULL),
(12, 13, '2026-04-02', 5000000.00, 12, 'FLAT', 1.50, 0.00, 'Biaya Usaha', 'DIVERIFIKASI', NULL, NULL, '2026-04-02 08:43:49', '2026-04-02 08:45:02', 2, '2026-04-02 08:45:02', 'data lengkap', NULL, NULL, NULL),
(13, 1, '2026-04-02', 500000.00, 3, 'FLAT', 1.50, 0.00, 'pinjam 500', 'DIVERIFIKASI', NULL, NULL, '2026-04-02 09:14:40', '2026-04-02 09:16:05', 2, '2026-04-02 09:16:05', 'iya', NULL, NULL, NULL),
(14, 14, '2026-01-01', 5000000.00, 12, 'FLAT', 1.50, 0.00, 'Modal Usaha Presentation', 'BERJALAN', NULL, NULL, '2026-04-04 09:09:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 3, '2026-04-09', 50000000.00, 27, 'FLAT', 1.50, 0.00, '-', 'DISETUJUI', '2026-04-09', NULL, '2026-04-09 19:20:12', '2026-04-09 19:25:30', 2, '2026-04-09 19:24:55', 'Data sudah lengkap', 3, '-', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman_approval`
--

CREATE TABLE `pinjaman_approval` (
  `id` bigint UNSIGNED NOT NULL,
  `pinjaman_id` bigint UNSIGNED NOT NULL,
  `oleh_user_id` bigint UNSIGNED NOT NULL,
  `keputusan` enum('SETUJU','TOLAK') COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pinjaman_approval`
--

INSERT INTO `pinjaman_approval` (`id`, `pinjaman_id`, `oleh_user_id`, `keputusan`, `catatan`, `tanggal`) VALUES
(1, 1, 3, 'SETUJU', 'Disetujui untuk dicairkan', '2024-11-05 14:00:00'),
(2, 2, 3, 'SETUJU', 'Disetujui dengan tenor 24 bulan', '2024-11-18 15:00:00'),
(3, 3, 3, 'SETUJU', 'Disetujui untuk keperluan pendidikan', '2024-12-03 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman_jadwal`
--

CREATE TABLE `pinjaman_jadwal` (
  `id` bigint UNSIGNED NOT NULL,
  `pinjaman_id` bigint UNSIGNED NOT NULL,
  `angsuran_ke` int UNSIGNED NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `pokok_tagih` decimal(14,2) NOT NULL DEFAULT '0.00',
  `bunga_tagih` decimal(14,2) NOT NULL DEFAULT '0.00',
  `total_tagih` decimal(14,2) NOT NULL,
  `status` enum('BELUM','BAYAR') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BELUM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pinjaman_jadwal`
--

INSERT INTO `pinjaman_jadwal` (`id`, `pinjaman_id`, `angsuran_ke`, `jatuh_tempo`, `pokok_tagih`, `bunga_tagih`, `total_tagih`, `status`) VALUES
(1, 1, 1, '2026-03-15', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(2, 1, 2, '2025-01-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(3, 1, 3, '2025-02-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(4, 1, 4, '2025-03-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(5, 1, 5, '2025-04-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(6, 1, 6, '2025-05-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(7, 1, 7, '2025-06-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(8, 1, 8, '2025-07-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(9, 1, 9, '2025-08-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(10, 1, 10, '2025-09-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(11, 1, 11, '2025-10-10', 416667.00, 75000.00, 491667.00, 'BAYAR'),
(12, 1, 12, '2025-11-10', 416665.00, 75000.00, 491665.00, 'BAYAR'),
(13, 2, 1, '2024-12-20', 416667.00, 150000.00, 566667.00, 'BAYAR'),
(14, 2, 2, '2025-01-20', 416667.00, 143750.00, 560417.00, 'BAYAR'),
(15, 2, 3, '2025-02-20', 416667.00, 137500.00, 554167.00, 'BAYAR'),
(16, 3, 1, '2025-01-05', 500000.00, 45000.00, 545000.00, 'BAYAR'),
(17, 3, 2, '2025-02-05', 500000.00, 45000.00, 545000.00, 'BAYAR'),
(18, 3, 3, '2025-03-05', 500000.00, 45000.00, 545000.00, 'BAYAR'),
(19, 3, 4, '2025-04-05', 500000.00, 45000.00, 545000.00, 'BAYAR'),
(20, 3, 5, '2025-05-05', 500000.00, 45000.00, 545000.00, 'BAYAR'),
(21, 3, 6, '2025-06-05', 500000.00, 45000.00, 545000.00, 'BAYAR'),
(22, 10, 1, '2026-03-02', 500000.00, 15000.00, 515000.00, 'BELUM'),
(23, 10, 2, '2026-05-01', 500000.00, 15000.00, 515000.00, 'BELUM'),
(24, 14, 1, '2026-02-15', 416666.67, 75000.00, 491666.67, 'BAYAR'),
(25, 14, 2, '2026-03-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(26, 14, 3, '2026-04-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(27, 14, 4, '2026-05-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(28, 14, 5, '2026-06-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(29, 14, 6, '2026-07-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(30, 14, 7, '2026-08-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(31, 14, 8, '2026-09-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(32, 14, 9, '2026-10-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(33, 14, 10, '2026-11-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(34, 14, 11, '2026-12-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(35, 14, 12, '2027-01-15', 416666.67, 75000.00, 491666.67, 'BELUM');

-- --------------------------------------------------------

--
-- Table structure for table `setting_koperasi`
--

CREATE TABLE `setting_koperasi` (
  `id` int UNSIGNED NOT NULL,
  `bunga_pinjaman_persen_bln` decimal(5,2) NOT NULL DEFAULT '1.50',
  `denda_telat_persen` decimal(5,2) NOT NULL DEFAULT '5.00',
  `plafon_x_saldo` decimal(6,2) NOT NULL DEFAULT '3.00',
  `tenor_maks_bulan` int UNSIGNED NOT NULL DEFAULT '12',
  `potongan_admin` decimal(14,2) NOT NULL DEFAULT '0.00',
  `minimum_simpanan_wajib` decimal(14,2) NOT NULL DEFAULT '0.00',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_koperasi`
--

INSERT INTO `setting_koperasi` (`id`, `bunga_pinjaman_persen_bln`, `denda_telat_persen`, `plafon_x_saldo`, `tenor_maks_bulan`, `potongan_admin`, `minimum_simpanan_wajib`, `updated_at`) VALUES
(1, 1.50, 5.00, 3.00, 12, 0.00, 20000.00, '2026-01-08 17:52:10');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan_transaksi`
--

CREATE TABLE `simpanan_transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` bigint UNSIGNED NOT NULL,
  `tipe` enum('SETOR','TARIK','TRANSFER') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jumlah` decimal(14,2) NOT NULL,
  `tujuan_anggota_id` bigint UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_oleh` bigint UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `simpanan_transaksi`
--

INSERT INTO `simpanan_transaksi` (`id`, `anggota_id`, `tipe`, `tanggal`, `jumlah`, `tujuan_anggota_id`, `keterangan`, `dibuat_oleh`, `created_at`) VALUES
(1, 1, 'SETOR', '2024-01-15 10:00:00', 500000.00, NULL, 'Simpanan awal', 2, '2024-01-15 10:00:00'),
(2, 2, 'SETOR', '2024-02-20 10:30:00', 1000000.00, NULL, 'Simpanan awal', 2, '2024-02-20 10:30:00'),
(3, 3, 'SETOR', '2024-03-10 11:00:00', 750000.00, NULL, 'Simpanan awal', 2, '2024-03-10 11:00:00'),
(4, 4, 'SETOR', '2024-04-05 09:00:00', 300000.00, NULL, 'Simpanan awal', 2, '2024-04-05 09:00:00'),
(5, 5, 'SETOR', '2024-05-12 14:00:00', 2000000.00, NULL, 'Simpanan awal', 2, '2024-05-12 14:00:00'),
(6, 6, 'SETOR', '2024-06-18 10:00:00', 600000.00, NULL, 'Simpanan awal', 2, '2024-06-18 10:00:00'),
(7, 7, 'SETOR', '2024-07-22 11:30:00', 1500000.00, NULL, 'Simpanan awal', 2, '2024-07-22 11:30:00'),
(8, 8, 'SETOR', '2024-08-30 13:00:00', 400000.00, NULL, 'Simpanan awal', 2, '2024-08-30 13:00:00'),
(9, 9, 'SETOR', '2024-09-14 10:30:00', 800000.00, NULL, 'Simpanan awal', 2, '2024-09-14 10:30:00'),
(10, 10, 'SETOR', '2024-10-20 15:00:00', 1200000.00, NULL, 'Simpanan awal', 2, '2024-10-20 15:00:00'),
(11, 1, 'SETOR', '2026-03-10 09:45:52', 200000.00, NULL, 'Setor rutin', 2, '2026-03-10 09:45:52'),
(12, 2, 'SETOR', '2026-03-11 09:45:52', 500000.00, NULL, 'Setor rutin', 2, '2026-03-11 09:45:52'),
(13, 3, 'SETOR', '2026-03-12 09:45:52', 150000.00, NULL, 'Setor rutin', 2, '2026-03-12 09:45:52'),
(14, 4, 'SETOR', '2026-03-13 09:45:52', 100000.00, NULL, 'Setor rutin', 2, '2026-03-13 09:45:52'),
(15, 5, 'SETOR', '2026-03-14 09:45:52', 300000.00, NULL, 'Setor rutin', 2, '2026-03-14 09:45:52'),
(16, 1, 'TARIK', '2026-03-05 09:45:52', 100000.00, NULL, 'Keperluan pribadi', 2, '2026-03-05 09:45:52'),
(17, 3, 'TARIK', '2026-03-07 09:45:52', 200000.00, NULL, 'Keperluan kuliah', 2, '2026-03-07 09:45:52'),
(18, 5, 'TARIK', '2026-03-09 09:45:52', 500000.00, NULL, 'Keperluan mendesak', 2, '2026-03-09 09:45:52'),
(19, 2, 'TRANSFER', '2026-03-08 09:45:52', 250000.00, 1, 'Transfer ke Ahmad', 2, '2026-03-08 09:45:52'),
(20, 12, 'SETOR', '2026-03-15 10:23:13', 50000000.00, NULL, 'Nabung', 9, '2026-03-15 10:23:13'),
(21, 1, 'SETOR', '2026-03-15 10:30:44', 5000000.00, NULL, '-', 9, '2026-03-15 10:30:44'),
(22, 1, 'SETOR', '2026-03-15 11:00:02', 500000.00, NULL, 'Topup untuk test autodebet', NULL, '2026-03-15 11:00:02'),
(23, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-2 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(24, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-3 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(25, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-4 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(26, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-5 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(27, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-6 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(28, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-7 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(29, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-8 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(30, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-9 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(31, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-10 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(32, 1, 'TARIK', '2026-03-31 10:15:34', 491667.00, NULL, 'Autodebet Angsuran ke-11 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(33, 1, 'TARIK', '2026-03-31 10:15:34', 491665.00, NULL, 'Autodebet Angsuran ke-12 (Pinjaman ID:1)', NULL, '2026-03-31 10:15:34'),
(34, 2, 'TARIK', '2026-03-31 10:15:34', 560417.00, NULL, 'Autodebet Angsuran ke-2 (Pinjaman ID:2)', NULL, '2026-03-31 10:15:34'),
(35, 2, 'TARIK', '2026-03-31 10:15:34', 554167.00, NULL, 'Autodebet Angsuran ke-3 (Pinjaman ID:2)', NULL, '2026-03-31 10:15:34'),
(36, 3, 'TARIK', '2026-03-31 10:15:34', 545000.00, NULL, 'Autodebet Angsuran ke-1 (Pinjaman ID:3)', NULL, '2026-03-31 10:15:34'),
(37, 3, 'SETOR', '2026-03-31 10:17:49', 8500000.00, NULL, 'Tabungan + Bayar Cicilan', 1, '2026-03-31 10:17:49'),
(38, 12, 'SETOR', '2026-03-31 10:19:10', 9000000.00, NULL, 'Tabungan', 1, '2026-03-31 10:19:10'),
(39, 3, 'TARIK', '2026-03-31 10:34:43', 545000.00, NULL, 'Autodebet Angsuran ke-2 (Pinjaman ID:3)', NULL, '2026-03-31 10:34:43'),
(40, 3, 'TARIK', '2026-03-31 10:34:43', 545000.00, NULL, 'Autodebet Angsuran ke-3 (Pinjaman ID:3)', NULL, '2026-03-31 10:34:43'),
(41, 3, 'TARIK', '2026-03-31 10:34:43', 545000.00, NULL, 'Autodebet Angsuran ke-4 (Pinjaman ID:3)', NULL, '2026-03-31 10:34:43'),
(42, 3, 'TARIK', '2026-03-31 10:34:43', 545000.00, NULL, 'Autodebet Angsuran ke-5 (Pinjaman ID:3)', NULL, '2026-03-31 10:34:43'),
(43, 3, 'TARIK', '2026-03-31 10:34:43', 545000.00, NULL, 'Autodebet Angsuran ke-6 (Pinjaman ID:3)', NULL, '2026-03-31 10:34:43'),
(44, 1, 'SETOR', '2026-04-02 09:30:45', 50000.00, NULL, 'nabung', 2, '2026-04-02 09:30:45'),
(45, 3, 'SETOR', '2026-04-02 13:16:10', 50000.00, NULL, 'nabung', 1, '2026-04-02 13:16:10'),
(46, 3, 'SETOR', '2026-04-02 13:28:29', 35000.00, NULL, 'nabung', 1, '2026-04-02 13:28:29'),
(47, 3, 'TARIK', '2026-04-02 13:33:52', 50000.00, NULL, 'tes', 1, '2026-04-02 13:33:52'),
(48, 3, 'TARIK', '2026-04-02 13:34:04', 35000.00, NULL, 'a', 1, '2026-04-02 13:34:04'),
(49, 3, 'TARIK', '2026-04-02 13:34:16', 5000.00, NULL, 'kj', 1, '2026-04-02 13:34:16'),
(50, 3, 'TARIK', '2026-04-02 13:34:27', 45000.00, NULL, 'cvbnm', 1, '2026-04-02 13:34:27'),
(51, 3, 'TARIK', '2026-04-02 13:34:37', 50000.00, NULL, 'l;jh', 1, '2026-04-02 13:34:37'),
(52, 3, 'TARIK', '2026-04-02 13:35:00', 50000.00, NULL, 'gh', 1, '2026-04-02 13:35:00'),
(53, 3, 'SETOR', '2026-04-02 13:35:23', 100000.00, NULL, '9', 1, '2026-04-02 13:35:23'),
(54, 3, 'SETOR', '2026-04-02 13:36:06', 60000.00, NULL, 'hj', 1, '2026-04-02 13:36:06'),
(55, 3, 'SETOR', '2026-04-02 13:36:41', 450000.00, NULL, 'lkjhg', 1, '2026-04-02 13:36:41'),
(56, 3, 'SETOR', '2026-04-02 13:37:29', 80000.00, NULL, 'hjg', 1, '2026-04-02 13:37:30'),
(57, 3, 'SETOR', '2026-04-02 13:37:52', 20000.00, NULL, 'n', 1, '2026-04-02 13:37:52'),
(58, 3, 'TARIK', '2026-04-02 13:39:45', 100000.00, NULL, '[[', 1, '2026-04-02 13:39:45'),
(59, 3, 'SETOR', '2026-04-09 19:19:09', 50000.00, NULL, '-', 1, '2026-04-09 19:19:09'),
(60, 3, 'TARIK', '2026-04-09 19:19:28', 20000.00, NULL, '-', 1, '2026-04-09 19:19:28'),
(61, 3, 'TARIK', '2026-04-10 20:34:36', 60000.00, NULL, 'butuh duit', 2, '2026-04-10 20:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('ADMIN','TELLER','KETUA','ANGGOTA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ANGGOTA',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password_hash`, `role`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@ksp.com', 'admin', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ADMIN', 1, '2026-04-15 13:41:50', '2026-03-15 09:45:52', '2026-04-15 13:41:50'),
(2, 'Teller 1', 'teller1@ksp.com', 'teller1', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'TELLER', 1, '2026-04-10 20:34:16', '2026-03-15 09:45:52', '2026-04-10 20:34:16'),
(3, 'Ketua Koperasi', 'ketua@ksp.com', 'ketua', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'KETUA', 1, '2026-04-09 19:25:10', '2026-03-15 09:45:52', '2026-04-09 19:25:10'),
(4, 'Ahmad Rizki', 'ahmad@example.com', 'ahmad', '$2y$12$1k0P2C.TFte9JlsQinORcet5Dw0R9a7GnTNidm9nLsWAm0zzbv8dK', 'ANGGOTA', 1, '2026-04-02 09:42:24', '2026-03-15 09:45:52', '2026-04-02 09:42:24'),
(5, 'Siti Nurhaliza', 'siti@example.com', 'siti', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-03-15 09:45:59'),
(6, 'Budi Santoso', 'budi@example.com', 'budi', '$2y$12$Nj6yQGabhgPJaoOXDL8U7unR/SXhLJCrg2tyUJaBywKkM6ofD9WVG', 'ANGGOTA', 1, '2026-04-10 20:26:09', '2026-03-15 09:45:52', '2026-04-10 20:26:09'),
(7, 'Dewi Lestari', 'dewi@example.com', 'dewi', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-03-15 10:30:05'),
(8, 'Eko Prasetyo', 'eko@example.com', 'eko', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-03-15 09:45:59'),
(9, 'Yogi Ario', 'yogi@ksp.com', 'yogi', '$2y$12$QOuP68GsLsJ9mWIvesIj4eBW/Z3e6A/qafy4QrDo7x79P.YzZWUU2', 'ADMIN', 1, '2026-03-15 10:46:44', '2026-03-15 09:48:16', '2026-04-02 09:20:55'),
(11, 'Yogi Ario P', '26031500001@ksp.com', '26031500001', '$2y$12$SkASdMaZH/E0RX3w0w7kSOJ7jjAMv1NAPeerqrLI8C45fd3sosPie', 'ANGGOTA', 1, '2026-04-01 13:41:08', '2026-03-15 10:21:47', '2026-04-01 13:41:08'),
(12, 'Budi Manjalu', 'budiman@ksp.com', 'budiman', '$2y$12$isU/1sB8uQ/fTURT60qZiuvIADb1KUg4bXKIJxrDO10fB.6cGBk5a', 'ANGGOTA', 1, '2026-04-02 13:04:36', '2026-04-02 08:30:50', '2026-04-02 13:04:36'),
(13, 'Prabroro', NULL, '26040200003', '$2y$12$uc2//9hDGkJdvVes06XnUu3U54S7tyjYpPZW6q0qX14P4OENRpkOu', 'ANGGOTA', 1, '2026-04-04 09:46:01', '2026-04-04 09:09:51', '2026-04-04 09:46:01');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_ringkasan_pinjaman`
-- (See below for the actual view)
--
CREATE TABLE `v_ringkasan_pinjaman` (
`anggota_id` bigint unsigned
,`bunga_persen_bln` decimal(5,2)
,`metode` enum('FLAT','MENURUN','ANUITAS')
,`pinjaman_id` bigint unsigned
,`pokok` decimal(14,2)
,`sisa_pokok` decimal(37,2)
,`status` enum('DIAJUKAN','DIVERIFIKASI','DISETUJUI','DITOLAK','DICAIRKAN','BERJALAN','LUNAS')
,`tenor_bulan` int unsigned
,`total_dibayar` decimal(36,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_saldo_simpanan`
-- (See below for the actual view)
--
CREATE TABLE `v_saldo_simpanan` (
`anggota_id` bigint unsigned
,`nama` varchar(120)
,`no_anggota` varchar(30)
,`saldo` decimal(36,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tunggakan`
-- (See below for the actual view)
--
CREATE TABLE `v_tunggakan` (
`anggota_id` bigint unsigned
,`angsuran_ke` int unsigned
,`hari_telat` int
,`jatuh_tempo` date
,`nama` varchar(120)
,`no_anggota` varchar(30)
,`pinjaman_id` bigint unsigned
,`total_tagih` decimal(14,2)
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_anggota` (`no_anggota`),
  ADD KEY `fk_anggota_user` (`user_id`);

--
-- Indexes for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_angsuran_pinj` (`pinjaman_id`),
  ADD KEY `idx_angsuran_tgl` (`tanggal_bayar`),
  ADD KEY `fk_angsuran_user` (`diterima_oleh`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_user` (`user_id`),
  ADD KEY `idx_audit_obj` (`objek`,`objek_id`);

--
-- Indexes for table `kas_transaksi`
--
ALTER TABLE `kas_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kas_tgl` (`tanggal`),
  ADD KEY `idx_kas_ref` (`ref_table`,`ref_id`),
  ADD KEY `fk_kas_user` (`dibuat_oleh`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pinj_anggota_status` (`anggota_id`,`status`),
  ADD KEY `fk_pinj_verif` (`verifikasi_oleh`),
  ADD KEY `fk_pinj_appr` (`approve_oleh`),
  ADD KEY `fk_pinj_cair` (`cair_oleh`);

--
-- Indexes for table `pinjaman_approval`
--
ALTER TABLE `pinjaman_approval`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_app_pinj` (`pinjaman_id`),
  ADD KEY `fk_app_user` (`oleh_user_id`);

--
-- Indexes for table `pinjaman_jadwal`
--
ALTER TABLE `pinjaman_jadwal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_jadwal` (`pinjaman_id`,`angsuran_ke`),
  ADD KEY `idx_jadwal_jt` (`jatuh_tempo`);

--
-- Indexes for table `setting_koperasi`
--
ALTER TABLE `setting_koperasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simpanan_transaksi`
--
ALTER TABLE `simpanan_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_simpanan_anggota_tgl` (`anggota_id`,`tanggal`),
  ADD KEY `idx_simpanan_tipe` (`tipe`),
  ADD KEY `fk_simp_tujuan` (`tujuan_anggota_id`),
  ADD KEY `fk_simp_user` (`dibuat_oleh`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `angsuran`
--
ALTER TABLE `angsuran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `kas_transaksi`
--
ALTER TABLE `kas_transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pinjaman_approval`
--
ALTER TABLE `pinjaman_approval`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pinjaman_jadwal`
--
ALTER TABLE `pinjaman_jadwal`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `setting_koperasi`
--
ALTER TABLE `setting_koperasi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `simpanan_transaksi`
--
ALTER TABLE `simpanan_transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

-- --------------------------------------------------------

--
-- Structure for view `v_ringkasan_pinjaman`
--
DROP TABLE IF EXISTS `v_ringkasan_pinjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ringkasan_pinjaman`  AS SELECT `p`.`id` AS `pinjaman_id`, `p`.`anggota_id` AS `anggota_id`, `p`.`pokok` AS `pokok`, `p`.`tenor_bulan` AS `tenor_bulan`, `p`.`metode` AS `metode`, `p`.`bunga_persen_bln` AS `bunga_persen_bln`, `p`.`status` AS `status`, coalesce(sum(`a`.`total`),0) AS `total_dibayar`, (`p`.`pokok` - coalesce(sum(`a`.`pokok_bayar`),0)) AS `sisa_pokok` FROM (`pinjaman` `p` left join `angsuran` `a` on((`a`.`pinjaman_id` = `p`.`id`))) GROUP BY `p`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_saldo_simpanan`
--
DROP TABLE IF EXISTS `v_saldo_simpanan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_saldo_simpanan`  AS SELECT `a`.`id` AS `anggota_id`, `a`.`no_anggota` AS `no_anggota`, `a`.`nama` AS `nama`, coalesce(sum((case when (`st`.`tipe` = 'SETOR') then `st`.`jumlah` when (`st`.`tipe` = 'TARIK') then -(`st`.`jumlah`) when ((`st`.`tipe` = 'TRANSFER') and (`st`.`anggota_id` = `a`.`id`)) then -(`st`.`jumlah`) when ((`st`.`tipe` = 'TRANSFER') and (`st`.`tujuan_anggota_id` = `a`.`id`)) then `st`.`jumlah` else 0 end)),0) AS `saldo` FROM (`anggota` `a` left join `simpanan_transaksi` `st` on(((`st`.`anggota_id` = `a`.`id`) or (`st`.`tujuan_anggota_id` = `a`.`id`)))) GROUP BY `a`.`id`, `a`.`no_anggota`, `a`.`nama` ;

-- --------------------------------------------------------

--
-- Structure for view `v_tunggakan`
--
DROP TABLE IF EXISTS `v_tunggakan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tunggakan`  AS SELECT `j`.`pinjaman_id` AS `pinjaman_id`, `p`.`anggota_id` AS `anggota_id`, `a2`.`no_anggota` AS `no_anggota`, `a2`.`nama` AS `nama`, `j`.`angsuran_ke` AS `angsuran_ke`, `j`.`jatuh_tempo` AS `jatuh_tempo`, `j`.`total_tagih` AS `total_tagih`, (to_days(curdate()) - to_days(`j`.`jatuh_tempo`)) AS `hari_telat` FROM ((`pinjaman_jadwal` `j` join `pinjaman` `p` on((`p`.`id` = `j`.`pinjaman_id`))) join `anggota` `a2` on((`a2`.`id` = `p`.`anggota_id`))) WHERE ((`j`.`status` = 'BELUM') AND (`j`.`jatuh_tempo` < curdate())) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `fk_anggota_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD CONSTRAINT `fk_angsuran_pinj` FOREIGN KEY (`pinjaman_id`) REFERENCES `pinjaman` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_angsuran_user` FOREIGN KEY (`diterima_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kas_transaksi`
--
ALTER TABLE `kas_transaksi`
  ADD CONSTRAINT `fk_kas_user` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `fk_pinj_anggota` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pinj_appr` FOREIGN KEY (`approve_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pinj_cair` FOREIGN KEY (`cair_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pinj_verif` FOREIGN KEY (`verifikasi_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pinjaman_approval`
--
ALTER TABLE `pinjaman_approval`
  ADD CONSTRAINT `fk_app_pinj` FOREIGN KEY (`pinjaman_id`) REFERENCES `pinjaman` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_app_user` FOREIGN KEY (`oleh_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pinjaman_jadwal`
--
ALTER TABLE `pinjaman_jadwal`
  ADD CONSTRAINT `fk_jadwal_pinj` FOREIGN KEY (`pinjaman_id`) REFERENCES `pinjaman` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simpanan_transaksi`
--
ALTER TABLE `simpanan_transaksi`
  ADD CONSTRAINT `fk_simp_anggota` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_simp_tujuan` FOREIGN KEY (`tujuan_anggota_id`) REFERENCES `anggota` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_simp_user` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
