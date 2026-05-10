-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2026 at 11:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_anggota` varchar(30) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `tipe` enum('DOSEN TETAP','DOSEN KONTRAK','DOSEN TIDAK TETAP','KARYAWAN TETAP','KARYAWAN KONTRAK','KARYAWAN TIDAK TETAP') NOT NULL DEFAULT 'KARYAWAN TETAP',
  `identitas_no` varchar(40) DEFAULT NULL,
  `prodi_unit` varchar(120) DEFAULT NULL,
  `no_hp` varchar(25) DEFAULT NULL,
  `gaji` int(11) NOT NULL DEFAULT 0,
  `alamat` text DEFAULT NULL,
  `tgl_daftar` date NOT NULL,
  `status` enum('AKTIF','NON-AKTIF','KELUAR') NOT NULL DEFAULT 'AKTIF',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `user_id`, `no_anggota`, `nama`, `tipe`, `identitas_no`, `prodi_unit`, `no_hp`, `gaji`, `alamat`, `tgl_daftar`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'A001', 'Ahmad Rizki', 'KARYAWAN TETAP', '3578012345670001', 'Teknik Informatika', '081234567890', 0, 'Jl. Merdeka No. 10, Surabaya', '2024-01-15', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(2, 5, 'A002', 'Siti Nurhaliza', 'DOSEN TETAP', '3578012345670002', 'Fakultas Ekonomi', '081234567891', 0, 'Jl. Pahlawan No. 25, Surabaya', '2024-02-20', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(3, 6, 'A003', 'Budi Santoso', 'KARYAWAN TETAP', '3578012345670003', 'Administrasi', '081234567892', 0, 'Jl. Pemuda No. 30, Surabaya', '2024-03-10', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(4, 7, 'A004', 'Dewi Lestari', 'KARYAWAN TETAP', '3578012345670004', 'Manajemen', '081234567893', 0, 'Jl. Sudirman No. 15, Surabaya', '2024-04-05', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(5, 8, 'A005', 'Eko Prasetyo', 'KARYAWAN TETAP', '3578012345670005', '-', '081234567894', 0, 'Jl. Diponegoro No. 45, Surabaya', '2024-05-12', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(6, NULL, 'A006', 'Fitri Handayani', 'KARYAWAN TETAP', '3578012345670006', 'Teknik Sipil', '081234567895', 0, 'Jl. Gatot Subroto No. 20, Surabaya', '2024-06-18', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(7, NULL, 'A007', 'Gilang Ramadhan', 'DOSEN TETAP', '3578012345670007', 'Fakultas Hukum', '081234567896', 0, 'Jl. Ahmad Yani No. 12, Surabaya', '2024-07-22', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(8, NULL, 'A008', 'Hana Putri', 'KARYAWAN TETAP', '3578012345670008', 'Sistem Informasi', '081234567897', 0, 'Jl. Basuki Rahmat No. 8, Surabaya', '2024-08-30', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(9, NULL, 'A009', 'Irfan Hakim', 'KARYAWAN TETAP', '3578012345670009', 'IT Support', '081234567898', 0, 'Jl. Veteran No. 5, Surabaya', '2024-09-14', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(10, NULL, 'A010', 'Julia Rahayu', 'KARYAWAN TETAP', '3578012345670010', '-', '081234567899', 0, 'Jl. Raya Darmo No. 100, Surabaya', '2024-10-20', 'AKTIF', '2026-03-15 09:45:52', '2026-04-24 12:45:31'),
(12, 11, '26031500001', 'Yogi Ario P', 'KARYAWAN TETAP', '2313020004', 'Teknik Informatika', '081358113087', 0, 'LAMONG, BADAS', '2026-03-15', 'AKTIF', '2026-03-15 10:21:47', '2026-04-24 12:45:31'),
(13, 12, '26040200002', 'Budi Macet', 'KARYAWAN TETAP', '3698520147898', '-', '081358975554', 0, 'Jalan Nangkka no 19 Kediri', '2025-01-01', 'AKTIF', '2026-04-02 08:30:50', '2026-04-24 12:45:31'),
(14, 13, '26040200003', 'Prabroro', 'KARYAWAN TETAP', NULL, NULL, NULL, 0, NULL, '2026-04-04', 'AKTIF', '2026-04-04 09:09:51', '2026-04-24 12:45:31'),
(15, 15, 'AR0001', 'Anggi Rita Kristanto', 'KARYAWAN TETAP', '7854120', '-', '08552121887', 0, 'Kediri', '2026-04-23', 'AKTIF', '2026-04-23 12:58:51', '2026-04-24 12:45:31'),
(16, 17, 'AS0001', 'Ahmad Sutadji Handoyono', 'KARYAWAN KONTRAK', '----', '----', '-----', 0, '-----', '2026-04-24', 'AKTIF', '2026-04-24 12:48:06', NULL),
(17, 20, 'AQ0001', 'Abdul Qadir', 'DOSEN TETAP', '123456', '-', '11111111111', 0, '-', '2026-05-02', 'AKTIF', '2026-05-02 19:57:44', NULL),
(18, 21, 'Y0001', 'Yulianto', 'DOSEN TETAP', '345678', '-', '-', 0, '-', '2026-05-02', 'AKTIF', '2026-05-02 22:22:47', NULL),
(19, 22, 'Y0002', 'Yuliani', 'DOSEN TETAP', '-', '-', '-', 0, '-', '2026-05-02', 'AKTIF', '2026-05-02 22:23:14', NULL),
(20, 0, 'E0001', 'eka abbie dhar,a', 'DOSEN TETAP', '2313020121', 'TEKNIK INFORMATIKA', '085732944677', 10000000, 'ABBIE NGANJOK 22', '2026-05-04', 'AKTIF', '2026-05-04 15:52:54', '2026-05-05 13:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE `angsuran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pinjaman_id` bigint(20) UNSIGNED NOT NULL,
  `angsuran_ke` int(10) UNSIGNED NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `pokok_bayar` decimal(14,2) NOT NULL DEFAULT 0.00,
  `bunga_bayar` decimal(14,2) NOT NULL DEFAULT 0.00,
  `denda` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total` decimal(14,2) NOT NULL,
  `diterima_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `aksi` varchar(120) NOT NULL,
  `objek` varchar(120) DEFAULT NULL,
  `objek_id` bigint(20) UNSIGNED DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
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
(201, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-15 13:41:50'),
(202, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-18 13:07:06'),
(203, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 08:07:48'),
(204, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 08:14:56'),
(205, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 08:24:05'),
(206, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 08:37:48'),
(207, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 13:45:19'),
(208, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 13:45:47'),
(209, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 13:45:52'),
(210, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 13:51:30'),
(211, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 13:51:36'),
(212, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:04:49'),
(213, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:08:29'),
(214, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:08:33'),
(215, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:22:42'),
(216, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:28:58'),
(217, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:41:16'),
(218, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:41:44'),
(219, 6, 'PENGAJUAN_PINJAMAN', 'pinjaman', 16, 'Pengajuan pinjaman baru sebesar Rp 5.000.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:42:51'),
(220, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:47:33'),
(221, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: teller_01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:48:31'),
(222, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: teller_01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:48:54'),
(223, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: teller_01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:49:10'),
(224, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:49:51'),
(225, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:50:02'),
(226, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:50:18'),
(227, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:51:04'),
(228, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:51:13'),
(229, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 14:59:26'),
(230, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 15:06:50'),
(231, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 19:36:19'),
(232, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 19:44:29'),
(233, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 19:44:55'),
(234, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 19:46:41'),
(235, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 19:46:49'),
(236, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-20 19:54:06'),
(237, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:17:58'),
(238, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:27:37'),
(239, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:27:44'),
(240, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:28:16'),
(241, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:28:22'),
(242, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:28:32'),
(243, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:28:37'),
(244, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:28:57'),
(245, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 04:32:38'),
(246, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 08:10:44'),
(247, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:04:59'),
(248, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:06:50'),
(249, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:06:55'),
(250, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:07:07'),
(251, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:07:21'),
(252, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:07:48'),
(253, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:07:54'),
(254, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:19:33'),
(255, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:19:39'),
(256, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:30:53'),
(257, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:30:58'),
(258, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:40:39'),
(259, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:45:05'),
(260, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:45:09'),
(261, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:45:41'),
(262, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:45:50'),
(263, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:46:11'),
(264, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:46:15'),
(265, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:46:51'),
(266, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:50:46');
INSERT INTO `audit_logs` (`id`, `user_id`, `aksi`, `objek`, `objek_id`, `detail`, `ip_address`, `user_agent`, `created_at`) VALUES
(267, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:51:58'),
(268, 9, 'LOGIN', 'users', 9, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:52:01'),
(269, 9, 'LOGOUT', 'users', 9, 'User Yogi Ario logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:53:40'),
(270, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 09:53:45'),
(271, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 10:46:28'),
(272, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 10:56:56'),
(273, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 10:57:07'),
(274, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 11:24:50'),
(275, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 11:24:59'),
(276, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 11:27:00'),
(277, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 11:27:10'),
(278, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 11:31:17'),
(279, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 11:31:26'),
(280, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 11:47:40'),
(281, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 15:45:48'),
(282, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 16:02:22'),
(283, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 16:02:29'),
(284, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 16:57:30'),
(285, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 17:18:32'),
(286, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 17:28:40'),
(287, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 19:40:10'),
(288, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 19:46:16'),
(289, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 19:46:35'),
(290, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 19:49:39'),
(291, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 19:55:35'),
(292, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 19:56:28'),
(293, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 19:56:52'),
(294, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 20:02:47'),
(295, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 20:04:37'),
(296, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-21 20:05:44'),
(297, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 20:09:49'),
(298, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 20:13:44'),
(299, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 20:14:04'),
(300, 2, 'LOGOUT', 'users', 2, 'User Teller 1 logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 20:14:27'),
(301, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 21:08:10'),
(302, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 21:08:44'),
(303, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 21:08:56'),
(304, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 21:34:14'),
(305, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 21:34:19'),
(306, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 21:37:56'),
(307, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 21:38:02'),
(308, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', '2026-04-21 22:27:15'),
(309, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: user', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 09:55:52'),
(310, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:19:58'),
(311, 6, 'PENGAJUAN_PINJAMAN', 'pinjaman', 17, 'Pengajuan pinjaman baru sebesar Rp 1.000.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:22:11'),
(312, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:26:57'),
(313, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:27:07'),
(314, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:27:49'),
(315, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:28:36'),
(316, 1, 'PENGAJUAN_PINJAMAN', 'pinjaman', 18, 'Pengajuan pinjaman baru sebesar Rp 500.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:35:34'),
(317, 1, 'VERIFIKASI_PINJAMAN', 'pinjaman', 18, 'Pinjaman #18 telah diverifikasi.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:36:08'),
(318, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:45:45'),
(319, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:45:53'),
(320, 3, 'APPROVE_PINJAMAN', 'pinjaman', 18, 'Pinjaman #18 telah disetujui.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 11:46:58'),
(321, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 12:08:09'),
(322, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 12:13:33'),
(323, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 12:31:29'),
(324, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-22 12:31:34'),
(325, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 09:36:11'),
(326, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 09:48:21'),
(327, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 09:48:27'),
(328, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 09:48:34'),
(329, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 09:48:38'),
(330, 3, 'LOGOUT', 'users', 3, 'User Ketua Koperasi logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 09:48:58'),
(331, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 09:49:01'),
(332, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 10:29:50'),
(333, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 10:29:58'),
(334, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 10:32:26'),
(335, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: budi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 10:32:31'),
(336, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 10:32:37'),
(337, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: budi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 11:46:26'),
(338, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: budi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 11:49:14'),
(339, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: A003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 11:50:13'),
(340, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 11:50:23'),
(341, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 11:52:14'),
(342, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: A003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 11:52:23'),
(343, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 11:54:21'),
(344, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:02:54'),
(345, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:03:01'),
(346, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:03:18'),
(347, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: A001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:03:26'),
(348, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: A001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:03:33'),
(349, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: budi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:03:38'),
(350, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:03:44'),
(351, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:03:48'),
(352, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:03:55'),
(353, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:46:17'),
(354, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-23 12:46:21'),
(355, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 11:07:40'),
(356, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 11:08:32'),
(357, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 11:08:41'),
(358, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 11:10:51'),
(359, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 11:10:55'),
(360, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 12:47:34'),
(361, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 12:48:52'),
(362, 17, 'LOGIN', 'users', 17, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 12:48:58'),
(363, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-27 14:42:35'),
(364, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-29 10:00:58'),
(365, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-29 11:18:41'),
(366, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-30 08:59:10'),
(367, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-30 12:47:18'),
(368, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 03:44:22'),
(369, 3, 'LOGOUT', 'users', 3, 'User Manager logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:05:03'),
(370, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:05:06'),
(371, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:07:53'),
(372, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:08:00'),
(373, 3, 'LOGOUT', 'users', 3, 'User Manager logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:08:11'),
(374, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:08:17'),
(375, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:16:20'),
(376, 18, 'LOGIN', 'users', 18, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:16:27'),
(377, 18, 'LOGOUT', 'users', 18, 'User Validator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:17:05'),
(378, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:17:12'),
(379, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:19:24'),
(380, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:19:32'),
(381, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:20:39'),
(382, 19, 'LOGIN', 'users', 19, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 04:20:45'),
(383, 19, 'LOGIN', 'users', 19, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 19:18:55'),
(384, 19, 'LOGOUT', 'users', 19, 'User Manager logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 19:48:34'),
(385, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 19:48:38'),
(386, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 19:52:29'),
(387, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 19:54:06'),
(388, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 20:01:04'),
(389, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 20:01:11'),
(390, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 20:05:48'),
(391, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 20:06:00'),
(392, 19, 'LOGIN', 'users', 19, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 21:17:47'),
(393, 19, 'LOGOUT', 'users', 19, 'User Manager logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 22:06:54'),
(394, 18, 'LOGIN', 'users', 18, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 22:07:07'),
(395, 18, 'LOGOUT', 'users', 18, 'User Validator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 22:19:00'),
(396, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 22:22:23'),
(397, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 22:30:41'),
(398, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 22:30:47'),
(399, 6, 'FORCE_CHANGE_PASSWORD', 'users', 6, 'User performed mandatory password reset', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-05-02 22:33:47'),
(400, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:47:36'),
(401, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:49:48'),
(402, 19, 'LOGIN', 'users', 19, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:50:11'),
(403, 19, 'LOGOUT', 'users', 19, 'User Manager logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:51:43'),
(404, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:51:56'),
(405, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:52:31'),
(406, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: iklima', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:52:54'),
(407, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:53:09'),
(408, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 22:54:48'),
(409, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: budi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 11:29:32'),
(410, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: budi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 11:29:38'),
(411, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: A003', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 11:29:57'),
(412, 6, 'LOGIN', 'users', 6, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 11:34:35'),
(413, 6, 'LOGOUT', 'users', 6, 'User Budi Santoso logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 15:52:00'),
(414, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 15:52:07'),
(415, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 15:53:34'),
(416, 0, 'LOGIN', 'users', 0, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 15:53:38'),
(417, 0, 'FORCE_CHANGE_PASSWORD', 'users', 0, 'User performed mandatory password reset', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 15:54:19'),
(418, 0, 'PENGAJUAN_PINJAMAN', 'pinjaman', 19, 'Pengajuan pinjaman sebesar Rp 7.000.000', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:09:03'),
(419, 0, 'LOGOUT', 'users', 0, 'User eka abbie dhar,a logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:09:24'),
(420, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: validator', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:09:37'),
(421, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: validator', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:09:46'),
(422, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:09:59'),
(423, 1, 'VERIFIKASI_PINJAMAN', 'pinjaman', 19, 'Pinjaman #19 telah diverifikasi.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:16:27'),
(424, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:16:37'),
(425, 0, 'LOGIN', 'users', 0, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:17:12'),
(426, 0, 'LOGOUT', 'users', 0, 'User eka abbie dhar,a logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:17:27'),
(427, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:17:57'),
(428, 3, 'APPROVE_PINJAMAN', 'pinjaman', 19, 'Pinjaman #19 telah disetujui.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:18:07'),
(429, 3, 'LOGOUT', 'users', 3, 'User Manager logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:18:12'),
(430, 0, 'LOGIN', 'users', 0, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:18:24'),
(431, 0, 'LOGOUT', 'users', 0, 'User eka abbie dhar,a logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:18:34'),
(432, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: ketua', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:18:45'),
(433, 3, 'LOGIN', 'users', 3, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:18:51'),
(434, 3, 'LOGOUT', 'users', 3, 'User Manager logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:19:01'),
(435, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:19:05'),
(436, 2, 'LOGOUT', 'users', 2, 'User BAU logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:19:11'),
(437, 2, 'LOGIN', 'users', 2, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:19:29'),
(438, 2, 'LOGOUT', 'users', 2, 'User BAU logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:20:21'),
(439, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: bau', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:20:35'),
(440, 0, 'LOGIN', 'users', 0, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:20:46'),
(441, 0, 'LOGOUT', 'users', 0, 'User eka abbie dhar,a logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:21:12'),
(442, 1, 'LOGIN', 'users', 1, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:21:20'),
(443, 1, 'PENCAIRAN_PINJAMAN', 'pinjaman', 19, 'Pinjaman #19 telah dicairkan.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:26:07'),
(444, 1, 'LOGOUT', 'users', 1, 'User Administrator logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:26:31'),
(445, 0, 'LOGIN', 'users', 0, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:26:45'),
(446, 0, 'PENGAJUAN_PINJAMAN', 'pinjaman', 20, 'Pengajuan pinjaman sebesar Rp 8.000.000', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 16:39:35'),
(447, 0, 'LOGIN', 'users', 0, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-05 11:23:41'),
(448, 0, 'LOGIN', 'users', 0, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-05 11:36:49'),
(449, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: E0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-07 13:47:47'),
(450, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: E0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-07 13:47:54'),
(451, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: E0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-07 13:48:11'),
(452, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: E0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-07 13:48:23'),
(453, NULL, 'FAILED_LOGIN', 'users', NULL, 'Failed login attempt for username: 2313020121', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-07 13:48:42'),
(454, 0, 'LOGIN', 'users', 0, 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-07 13:51:01');

-- --------------------------------------------------------

--
-- Table structure for table `kas_transaksi`
--

CREATE TABLE `kas_transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `tipe` enum('KAS_MASUK','KAS_KELUAR') NOT NULL,
  `sumber` enum('SIMPANAN','PENCAIRAN_PINJAMAN','ANGSURAN','OPERASIONAL','LAINNYA') NOT NULL,
  `ref_table` varchar(50) DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah` decimal(14,2) NOT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `dibuat_oleh` bigint(20) UNSIGNED DEFAULT NULL
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
(48, '2026-04-10 20:34:36', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 61, 60000.00, 'Penarikan simpanan: butuh duit', 2),
(49, '2026-04-21 09:45:01', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 62, 600000.00, 'Setoran simpanan: ghjkl', 1),
(50, '2026-04-21 09:46:06', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 63, 300000.00, 'Penarikan simpanan: wer', 1),
(51, '2026-04-22 11:30:31', 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 64, 500000.00, 'Setoran simpanan: -', 1),
(52, '2026-04-22 11:32:11', 'KAS_KELUAR', 'SIMPANAN', 'simpanan_transaksi', 65, 1000000.00, 'Penarikan simpanan: sejuta', 1),
(53, '2026-05-04 16:26:07', 'KAS_KELUAR', 'PENCAIRAN_PINJAMAN', 'pinjaman', 19, 7000000.00, 'Pencairan Pinjaman #19 - eka abbie dhar,a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `anggota_id` bigint(20) UNSIGNED NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `pokok` decimal(14,2) NOT NULL,
  `tenor_bulan` int(10) UNSIGNED NOT NULL,
  `metode` enum('FLAT','MENURUN','ANUITAS') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FLAT',
  `bunga_persen_bln` decimal(5,2) NOT NULL DEFAULT 1.50,
  `potongan_admin` decimal(14,2) NOT NULL DEFAULT 0.00,
  `tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('DIAJUKAN','DIVERIFIKASI','DISETUJUI','DITOLAK','DICAIRKAN','BERJALAN','LUNAS') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DIAJUKAN',
  `tgl_disetujui` date DEFAULT NULL,
  `tgl_cair` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `verifikasi_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `tgl_verifikasi` datetime DEFAULT NULL,
  `catatan_verifikasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approve_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `catatan_approve` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cair_oleh` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(15, 3, '2026-04-09', 50000000.00, 27, 'FLAT', 1.50, 0.00, '-', 'DISETUJUI', '2026-04-09', NULL, '2026-04-09 19:20:12', '2026-04-09 19:25:30', 2, '2026-04-09 19:24:55', 'Data sudah lengkap', 3, '-', NULL),
(16, 3, '2026-04-20', 5000000.00, 12, 'FLAT', 1.50, 0.00, 'renovasi rumah', 'DIAJUKAN', NULL, NULL, '2026-04-20 14:42:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 3, '2026-04-22', 1000000.00, 12, 'FLAT', 1.50, 0.00, 'coba', 'DIAJUKAN', NULL, NULL, '2026-04-22 11:22:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 3, '2026-04-22', 500000.00, 12, 'FLAT', 1.50, 0.00, 'keperluan sekolah', 'DISETUJUI', '2026-04-22', NULL, '2026-04-22 11:35:34', '2026-04-22 11:46:58', 1, '2026-04-22 11:36:08', 'anggota memenuhi syarat pengaajuan pinjaman', 3, '', NULL),
(19, 20, '2026-05-04', 7000000.00, 5, '', 0.60, 0.00, 'rahasia', 'BERJALAN', '2026-05-04', '2026-05-04', '2026-05-04 16:09:03', '2026-05-04 16:26:07', 1, '2026-05-04 16:16:27', 'hasil valid', 3, 'acc bolo', 1),
(20, 20, '2026-05-04', 8000000.00, 3, '', 0.60, 0.00, 'kecelakaan', 'DIAJUKAN', NULL, NULL, '2026-05-04 16:39:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman_approval`
--

CREATE TABLE `pinjaman_approval` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pinjaman_id` bigint(20) UNSIGNED NOT NULL,
  `oleh_user_id` bigint(20) UNSIGNED NOT NULL,
  `keputusan` enum('SETUJU','TOLAK') NOT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
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
  `id` int(11) NOT NULL,
  `pinjaman_id` bigint(20) UNSIGNED NOT NULL,
  `angsuran_ke` int(10) UNSIGNED NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `pokok_tagih` decimal(14,2) NOT NULL DEFAULT 0.00,
  `bunga_tagih` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total_tagih` decimal(14,2) NOT NULL,
  `status` enum('BELUM','BAYAR') NOT NULL DEFAULT 'BELUM'
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
(35, 14, 12, '2027-01-15', 416666.67, 75000.00, 491666.67, 'BELUM'),
(36, 19, 1, '2026-06-04', 1400000.00, 42000.00, 1442000.00, 'BELUM'),
(37, 19, 2, '2026-07-04', 1400000.00, 42000.00, 1442000.00, 'BELUM'),
(38, 19, 3, '2026-08-04', 1400000.00, 42000.00, 1442000.00, 'BELUM'),
(39, 19, 4, '2026-09-04', 1400000.00, 42000.00, 1442000.00, 'BELUM'),
(40, 19, 5, '2026-10-04', 1400000.00, 42000.00, 1442000.00, 'BELUM');

-- --------------------------------------------------------

--
-- Table structure for table `setting_koperasi`
--

CREATE TABLE `setting_koperasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `bunga_pinjaman_persen_bln` decimal(5,2) NOT NULL DEFAULT 1.50,
  `denda_telat_persen` decimal(5,2) NOT NULL DEFAULT 5.00,
  `plafon_x_saldo` decimal(6,2) NOT NULL DEFAULT 3.00,
  `tenor_maks_bulan` int(10) UNSIGNED NOT NULL DEFAULT 12,
  `potongan_admin` decimal(14,2) NOT NULL DEFAULT 0.00,
  `minimum_simpanan_wajib` decimal(14,2) NOT NULL DEFAULT 0.00,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bunga_jangka_pendek` decimal(5,2) NOT NULL DEFAULT 1.00,
  `bunga_jangka_panjang` decimal(5,2) NOT NULL DEFAULT 0.60
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_koperasi`
--

INSERT INTO `setting_koperasi` (`id`, `bunga_pinjaman_persen_bln`, `denda_telat_persen`, `plafon_x_saldo`, `tenor_maks_bulan`, `potongan_admin`, `minimum_simpanan_wajib`, `updated_at`, `bunga_jangka_pendek`, `bunga_jangka_panjang`) VALUES
(1, 1.50, 5.00, 3.00, 12, 0.00, 20000.00, '2026-01-08 17:52:10', 1.00, 0.60);

-- --------------------------------------------------------

--
-- Table structure for table `simpanan_transaksi`
--

CREATE TABLE `simpanan_transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `anggota_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` enum('SETOR','TARIK','TRANSFER') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `jumlah` decimal(14,2) NOT NULL,
  `tujuan_anggota_id` bigint(20) UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(61, 3, 'TARIK', '2026-04-10 20:34:36', 60000.00, NULL, 'butuh duit', 2, '2026-04-10 20:34:36'),
(62, 3, 'SETOR', '2026-04-21 09:45:01', 600000.00, NULL, 'ghjkl', 1, '2026-04-21 09:45:01'),
(63, 3, 'TARIK', '2026-04-21 09:46:06', 300000.00, NULL, 'wer', 1, '2026-04-21 09:46:06'),
(64, 3, 'SETOR', '2026-04-22 11:30:31', 500000.00, NULL, '-', 1, '2026-04-22 11:30:31'),
(65, 3, 'TARIK', '2026-04-22 11:32:11', 1000000.00, NULL, 'sejuta', 1, '2026-04-22 11:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('VALIDATOR','BAU','MANAGER','ANGGOTA') NOT NULL DEFAULT 'ANGGOTA',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password_hash`, `role`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES
(0, 'eka abbie dhar,a', 'e0001@ksp.local', 'E0001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ANGGOTA', 1, '2026-05-07 13:51:01', '2026-05-04 15:52:54', '2026-05-07 13:51:01'),
(1, 'Administrator', 'admin@ksp.com', 'admin', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'VALIDATOR', 1, '2026-05-04 16:21:20', '2026-03-15 09:45:52', '2026-05-04 16:21:20'),
(2, 'BAU', 'bau@ksp.com', 'bau', '$2y$12$nozQxoXgzIQ4hZs1RxhpheEsVwl1/SBEmba8ZfUYjpAsD4dtiQA3i', 'BAU', 1, '2026-05-04 16:19:29', '2026-03-15 09:45:52', '2026-05-04 16:19:29'),
(3, 'Manager', 'manager@ksp.com', 'ketua', '$2y$12$lfAiODopbk0p4th1BiMHZOUCFN8S5Rnkm3hz/5.s7W.yCWBKHAzIW', 'MANAGER', 1, '2026-05-04 16:18:51', '2026-03-15 09:45:52', '2026-05-04 16:18:51'),
(4, 'Ahmad Rizki', 'ahmad@example.com', 'ahmad', '$2y$12$1k0P2C.TFte9JlsQinORcet5Dw0R9a7GnTNidm9nLsWAm0zzbv8dK', 'ANGGOTA', 1, '2026-04-02 09:42:24', '2026-03-15 09:45:52', '2026-04-21 11:29:40'),
(5, 'Siti Nurhaliza', 'siti@example.com', 'siti', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-03-15 09:45:59'),
(6, 'Budi Santoso', 'budi@example.com', 'budi', '$2a$12$KVwyu0nAdD5yMm50tlCS0OCtKTIYIs54vlb38NbKT1m52NNPvf3VG', 'ANGGOTA', 1, '2026-05-04 11:34:35', '2026-03-15 09:45:52', '2026-05-04 11:34:35'),
(7, 'Dewi Lestari', 'dewi@example.com', 'dewi', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-03-15 10:30:05'),
(8, 'Eko Prasetyo', 'eko@example.com', 'eko', '$2y$12$.ck2s0lKpzY43bNhXdI8ne7DuHjSbVKL3Um9JnvLSNT1KCNwFWbmy', 'ANGGOTA', 1, NULL, '2026-03-15 09:45:52', '2026-04-20 14:40:12'),
(9, 'Yogi Ario', 'yogi@ksp.com', 'yogi', '$2y$12$nxQLiXoHk5Rqca.XWwjwv.PYkFRfFpK0R14SoO3R6jgsCP3clPF5m', 'VALIDATOR', 1, '2026-04-21 09:52:01', '2026-03-15 09:48:16', '2026-04-21 20:09:09'),
(11, 'Yogi Ario P', '26031500001@ksp.com', '26031500001', '$2y$12$SkASdMaZH/E0RX3w0w7kSOJ7jjAMv1NAPeerqrLI8C45fd3sosPie', 'ANGGOTA', 1, '2026-04-01 13:41:08', '2026-03-15 10:21:47', '2026-04-01 13:41:08'),
(12, 'Budi Manjalu', 'budiman@ksp.com', 'budiman', '$2y$12$isU/1sB8uQ/fTURT60qZiuvIADb1KUg4bXKIJxrDO10fB.6cGBk5a', 'ANGGOTA', 1, '2026-04-02 13:04:36', '2026-04-02 08:30:50', '2026-04-02 13:04:36'),
(13, 'Prabroro', NULL, '26040200003', '$2y$12$uc2//9hDGkJdvVes06XnUu3U54S7tyjYpPZW6q0qX14P4OENRpkOu', 'ANGGOTA', 1, '2026-04-04 09:46:01', '2026-04-04 09:09:51', '2026-04-04 09:46:01'),
(15, 'Anggi Rita Kristanto', 'ar0001@ksp.local', 'AR0001', '$2y$12$yB4KsqKpMECkwZFXflY5DOQekGMK9hdv3dHkKL8tk330.LiGNqxJG', 'ANGGOTA', 1, NULL, '2026-04-23 12:58:51', NULL),
(17, 'Ahmad Sutadji Handoyono', 'as0001@ksp.local', 'AS0001', '$2y$12$qjqguhPzI9V21BWvy7LhAeRiRo2zpAPLTfNOddTRNLlkwygqeTHjS', 'ANGGOTA', 1, '2026-04-24 12:48:58', '2026-04-24 12:48:06', '2026-04-24 12:48:58'),
(18, 'Validator', 'validator@KSP.com', 'validator1', '$2y$12$9Cvl3MTDEG6DHHpuaZvxbeVo9FmUC7FqeUIYBKdPLLtFLcUc/2/JS', 'ANGGOTA', 1, '2026-05-02 22:07:07', '2026-05-02 04:05:55', '2026-05-02 22:13:35'),
(19, 'Manager', 'bendahara@KSP.com', 'manager', '$2y$12$6aIu/E6rpkwtB7Luu.cffev93aQnlsWH53GLkXfY/a17svNR6zkCC', 'MANAGER', 1, '2026-05-02 22:50:11', '2026-05-02 04:19:18', '2026-05-02 22:50:11'),
(20, 'Abdul Qadir', 'aq0001@ksp.local', 'AQ0001', '$2y$12$dSfYc27AE4tMiSocWA8.Ve9RKGTSbkQHkiLyWXiIglxLbxFr0cm..', 'ANGGOTA', 1, NULL, '2026-05-02 19:57:44', NULL),
(21, 'Yulianto', 'y0001@ksp.local', 'Y0001', '$2y$12$Z4MfxQzVfPK03wbSzVtzoOydgsjeCSjun4WbB4XA2knW87yLXxXbq', 'ANGGOTA', 1, NULL, '2026-05-02 22:22:47', NULL),
(22, 'Yuliani', 'y0002@ksp.local', 'Y0002', '$2y$12$tdb9VZ/KNs4lz3vVEBkHz.1Y7t5pDEuXtZ5kIPMUxbWwNi39y5A3G', 'ANGGOTA', 1, NULL, '2026-05-02 22:23:14', NULL),
(23, 'Iklima Test', 'iklima@test.com', 'iklima', '$2y$12$BqAbpkSTivbGnLhaUjIN4u7r7fMkbe2zbpk7iEyja7aD6A.RaplEO', 'VALIDATOR', 1, NULL, '2026-05-02 22:54:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `v_ringkasan_pinjaman`
--

CREATE TABLE `v_ringkasan_pinjaman` (
  `pinjaman_id` bigint(20) UNSIGNED DEFAULT NULL,
  `anggota_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pokok` decimal(14,2) DEFAULT NULL,
  `tenor_bulan` int(10) UNSIGNED DEFAULT NULL,
  `metode` enum('FLAT','MENURUN','ANUITAS') DEFAULT NULL,
  `bunga_persen_bln` decimal(5,2) DEFAULT NULL,
  `status` enum('DIAJUKAN','DIVERIFIKASI','DISETUJUI','DITOLAK','DICAIRKAN','BERJALAN','LUNAS') DEFAULT NULL,
  `total_dibayar` decimal(36,2) DEFAULT NULL,
  `sisa_pokok` decimal(37,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `v_saldo_simpanan`
--

CREATE TABLE `v_saldo_simpanan` (
  `anggota_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_anggota` varchar(30) DEFAULT NULL,
  `nama` varchar(120) DEFAULT NULL,
  `saldo` decimal(36,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `v_tunggakan`
--

CREATE TABLE `v_tunggakan` (
  `pinjaman_id` bigint(20) UNSIGNED DEFAULT NULL,
  `anggota_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_anggota` varchar(30) DEFAULT NULL,
  `nama` varchar(120) DEFAULT NULL,
  `angsuran_ke` int(10) UNSIGNED DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `total_tagih` decimal(14,2) DEFAULT NULL,
  `hari_telat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `angsuran`
--
ALTER TABLE `angsuran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=455;

--
-- AUTO_INCREMENT for table `kas_transaksi`
--
ALTER TABLE `kas_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pinjaman_approval`
--
ALTER TABLE `pinjaman_approval`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pinjaman_jadwal`
--
ALTER TABLE `pinjaman_jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
