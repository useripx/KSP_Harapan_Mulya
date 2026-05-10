-- ================================================
-- SEED DATA untuk Koperasi Harapan Mulya
-- Data dummy untuk testing aplikasi
-- ================================================

-- Hapus data lama jika ada
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE angsuran;
TRUNCATE TABLE pinjaman_jadwal;
TRUNCATE TABLE pinjaman_approval;
TRUNCATE TABLE pinjaman;
TRUNCATE TABLE simpanan_transaksi;
TRUNCATE TABLE kas_transaksi;
TRUNCATE TABLE anggota;
TRUNCATE TABLE users;
TRUNCATE TABLE audit_logs;
TRUNCATE TABLE notifikasi;
SET FOREIGN_KEY_CHECKS = 1;

-- ================================================
-- INSERT USERS
-- Password untuk semua user: password123
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
-- ================================================

INSERT INTO users (id, name, email, username, password_hash, role, is_active, created_at) VALUES
(1, 'Administrator', 'admin@ksp.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'VALIDATOR', 1, NOW()),
(2, 'Teller 1', 'teller1@ksp.com', 'teller1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'BAU', 1, NOW()),
(3, 'Manager Koperasi', 'manager@ksp.com', 'manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MANAGER', 1, NOW()),
(4, 'Ahmad Rizki', 'ahmad@example.com', 'ahmad', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ANGGOTA', 1, NOW()),
(5, 'Siti Nurhaliza', 'siti@example.com', 'siti', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ANGGOTA', 1, NOW()),
(6, 'Budi Santoso', 'budi@example.com', 'budi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ANGGOTA', 1, NOW()),
(7, 'Dewi Lestari', 'dewi@example.com', 'dewi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ANGGOTA', 1, NOW()),
(8, 'Eko Prasetyo', 'eko@example.com', 'eko', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ANGGOTA', 1, NOW());

-- ================================================
-- INSERT ANGGOTA
-- ================================================

INSERT INTO anggota (id, user_id, no_anggota, nama, tipe, identitas_no, prodi_unit, no_hp, alamat, tgl_daftar, status, created_at) VALUES
(1, 4, 'AR0001', 'Ahmad Rizki', 'KARYAWAN TETAP', '3578012345670001', 'Teknik Informatika', '081234567890', 'Jl. Merdeka No. 10, Surabaya', '2024-01-15', 'AKTIF', NOW()),
(2, 5, 'SN0001', 'Siti Nurhaliza', 'DOSEN TETAP', '3578012345670002', 'Fakultas Ekonomi', '081234567891', 'Jl. Pahlawan No. 25, Surabaya', '2024-02-20', 'AKTIF', NOW()),
(3, 6, 'BS0001', 'Budi Santoso', 'KARYAWAN TETAP', '3578012345670003', 'Administrasi', '081234567892', 'Jl. Pemuda No. 30, Surabaya', '2024-03-10', 'AKTIF', NOW()),
(4, 7, 'DL0001', 'Dewi Lestari', 'KARYAWAN TETAP', '3578012345670004', 'Manajemen', '081234567893', 'Jl. Sudirman No. 15, Surabaya', '2024-04-05', 'AKTIF', NOW()),
(5, 8, 'EP0001', 'Eko Prasetyo', 'KARYAWAN TETAP', '3578012345670005', '-', '081234567894', 'Jl. Diponegoro No. 45, Surabaya', '2024-05-12', 'AKTIF', NOW()),
(6, NULL, 'FH0001', 'Fitri Handayani', 'KARYAWAN TETAP', '3578012345670006', 'Teknik Sipil', '081234567895', 'Jl. Gatot Subroto No. 20, Surabaya', '2024-06-18', 'AKTIF', NOW()),
(7, NULL, 'GR0001', 'Gilang Ramadhan', 'DOSEN TETAP', '3578012345670007', 'Fakultas Hukum', '081234567896', 'Jl. Ahmad Yani No. 12, Surabaya', '2024-07-22', 'AKTIF', NOW()),
(8, NULL, 'HP0001', 'Hana Putri', 'KARYAWAN TETAP', '3578012345670008', 'Sistem Informasi', '081234567897', 'Jl. Basuki Rahmat No. 8, Surabaya', '2024-08-30', 'AKTIF', NOW()),
(9, NULL, 'IH0001', 'Irfan Hakim', 'KARYAWAN TETAP', '3578012345670009', 'IT Support', '081234567898', 'Jl. Veteran No. 5, Surabaya', '2024-09-14', 'AKTIF', NOW()),
(10, NULL, 'JR0001', 'Julia Rahayu', 'KARYAWAN TETAP', '3578012345670010', '-', '081234567899', 'Jl. Raya Darmo No. 100, Surabaya', '2024-10-20', 'AKTIF', NOW());

-- ================================================
-- INSERT SIMPANAN TRANSAKSI (Sample)
-- ================================================

-- Setor awal untuk semua anggota
INSERT INTO simpanan_transaksi (anggota_id, tipe, tanggal, jumlah, keterangan, dibuat_oleh, created_at) VALUES
(1, 'SETOR', '2024-01-15 10:00:00', 500000, 'Simpanan awal', 2, '2024-01-15 10:00:00'),
(2, 'SETOR', '2024-02-20 10:30:00', 1000000, 'Simpanan awal', 2, '2024-02-20 10:30:00'),
(3, 'SETOR', '2024-03-10 11:00:00', 750000, 'Simpanan awal', 2, '2024-03-10 11:00:00'),
(4, 'SETOR', '2024-04-05 09:00:00', 300000, 'Simpanan awal', 2, '2024-04-05 09:00:00'),
(5, 'SETOR', '2024-05-12 14:00:00', 2000000, 'Simpanan awal', 2, '2024-05-12 14:00:00'),
(6, 'SETOR', '2024-06-18 10:00:00', 600000, 'Simpanan awal', 2, '2024-06-18 10:00:00'),
(7, 'SETOR', '2024-07-22 11:30:00', 1500000, 'Simpanan awal', 2, '2024-07-22 11:30:00'),
(8, 'SETOR', '2024-08-30 13:00:00', 400000, 'Simpanan awal', 2, '2024-08-30 13:00:00'),
(9, 'SETOR', '2024-09-14 10:30:00', 800000, 'Simpanan awal', 2, '2024-09-14 10:30:00'),
(10, 'SETOR', '2024-10-20 15:00:00', 1200000, 'Simpanan awal', 2, '2024-10-20 15:00:00');

-- Setor tambahan bulan ini (untuk testing)
INSERT INTO simpanan_transaksi (anggota_id, tipe, tanggal, jumlah, keterangan, dibuat_oleh, created_at) VALUES
(1, 'SETOR', DATE_SUB(NOW(), INTERVAL 5 DAY), 200000, 'Setor rutin', 2, DATE_SUB(NOW(), INTERVAL 5 DAY)),
(2, 'SETOR', DATE_SUB(NOW(), INTERVAL 4 DAY), 500000, 'Setor rutin', 2, DATE_SUB(NOW(), INTERVAL 4 DAY)),
(3, 'SETOR', DATE_SUB(NOW(), INTERVAL 3 DAY), 150000, 'Setor rutin', 2, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(4, 'SETOR', DATE_SUB(NOW(), INTERVAL 2 DAY), 100000, 'Setor rutin', 2, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(5, 'SETOR', DATE_SUB(NOW(), INTERVAL 1 DAY), 300000, 'Setor rutin', 2, DATE_SUB(NOW(), INTERVAL 1 DAY));

-- Beberapa penarikan
INSERT INTO simpanan_transaksi (anggota_id, tipe, tanggal, jumlah, keterangan, dibuat_oleh, created_at) VALUES
(1, 'TARIK', DATE_SUB(NOW(), INTERVAL 10 DAY), 100000, 'Keperluan pribadi', 2, DATE_SUB(NOW(), INTERVAL 10 DAY)),
(3, 'TARIK', DATE_SUB(NOW(), INTERVAL 8 DAY), 200000, 'Keperluan kuliah', 2, DATE_SUB(NOW(), INTERVAL 8 DAY)),
(5, 'TARIK', DATE_SUB(NOW(), INTERVAL 6 DAY), 500000, 'Keperluan mendesak', 2, DATE_SUB(NOW(), INTERVAL 6 DAY));

-- Transfer antar anggota
INSERT INTO simpanan_transaksi (anggota_id, tipe, tanggal, jumlah, tujuan_anggota_id, keterangan, dibuat_oleh, created_at) VALUES
(2, 'TRANSFER', DATE_SUB(NOW(), INTERVAL 7 DAY), 250000, 1, 'Transfer ke Ahmad', 2, DATE_SUB(NOW(), INTERVAL 7 DAY));

-- ================================================
-- INSERT PINJAMAN (Sample)
-- ================================================

INSERT INTO pinjaman (id, anggota_id, tgl_pengajuan, pokok, tenor_bulan, metode, bunga_persen_bln, potongan_admin, tujuan, status, tgl_disetujui, tgl_cair, created_at) VALUES
(1, 1, '2024-11-01', 5000000, 12, 'FLAT', 1.50, 50000, 'Modal usaha', 'BERJALAN', '2024-11-05', '2024-11-10', '2024-11-01 10:00:00'),
(2, 2, '2024-11-15', 10000000, 24, 'MENURUN', 1.50, 100000, 'Renovasi rumah', 'BERJALAN', '2024-11-18', '2024-11-20', '2024-11-15 11:00:00'),
(3, 3, '2024-12-01', 3000000, 6, 'FLAT', 1.50, 30000, 'Biaya pendidikan', 'BERJALAN', '2024-12-03', '2024-12-05', '2024-12-01 09:00:00'),
(4, 5, '2025-01-02', 15000000, 36, 'ANUITAS', 1.50, 150000, 'Pengembangan usaha', 'DIAJUKAN', NULL, NULL, '2025-01-02 14:00:00'),
(5, 4, '2024-10-01', 2000000, 12, 'FLAT', 1.50, 20000, 'Keperluan mendesak', 'LUNAS', '2024-10-03', '2024-10-05', '2024-10-01 10:00:00');

-- ================================================
-- INSERT PINJAMAN JADWAL (untuk pinjaman BERJALAN)
-- ================================================

-- Jadwal untuk Pinjaman ID 1 (12 bulan, FLAT)
-- Pokok per bulan: 5000000/12 = 416667
-- Bunga per bulan: 5000000 * 1.5% = 75000
-- Total per bulan: 491667

INSERT INTO pinjaman_jadwal (pinjaman_id, angsuran_ke, jatuh_tempo, pokok_tagih, bunga_tagih, total_tagih, status) VALUES
(1, 1, '2024-12-10', 416667, 75000, 491667, 'BAYAR'),
(1, 2, '2025-01-10', 416667, 75000, 491667, 'BELUM'),
(1, 3, '2025-02-10', 416667, 75000, 491667, 'BELUM'),
(1, 4, '2025-03-10', 416667, 75000, 491667, 'BELUM'),
(1, 5, '2025-04-10', 416667, 75000, 491667, 'BELUM'),
(1, 6, '2025-05-10', 416667, 75000, 491667, 'BELUM'),
(1, 7, '2025-06-10', 416667, 75000, 491667, 'BELUM'),
(1, 8, '2025-07-10', 416667, 75000, 491667, 'BELUM'),
(1, 9, '2025-08-10', 416667, 75000, 491667, 'BELUM'),
(1, 10, '2025-09-10', 416667, 75000, 491667, 'BELUM'),
(1, 11, '2025-10-10', 416667, 75000, 491667, 'BELUM'),
(1, 12, '2025-11-10', 416665, 75000, 491665, 'BELUM');

-- Jadwal untuk Pinjaman ID 2 (24 bulan, MENURUN) - simplified
INSERT INTO pinjaman_jadwal (pinjaman_id, angsuran_ke, jatuh_tempo, pokok_tagih, bunga_tagih, total_tagih, status) VALUES
(2, 1, '2024-12-20', 416667, 150000, 566667, 'BAYAR'),
(2, 2, '2025-01-20', 416667, 143750, 560417, 'BELUM'),
(2, 3, '2025-02-20', 416667, 137500, 554167, 'BELUM');

-- Jadwal untuk Pinjaman ID 3 (6 bulan, FLAT)
INSERT INTO pinjaman_jadwal (pinjaman_id, angsuran_ke, jatuh_tempo, pokok_tagih, bunga_tagih, total_tagih, status) VALUES
(3, 1, '2025-01-05', 500000, 45000, 545000, 'BELUM'),
(3, 2, '2025-02-05', 500000, 45000, 545000, 'BELUM'),
(3, 3, '2025-03-05', 500000, 45000, 545000, 'BELUM'),
(3, 4, '2025-04-05', 500000, 45000, 545000, 'BELUM'),
(3, 5, '2025-05-05', 500000, 45000, 545000, 'BELUM'),
(3, 6, '2025-06-05', 500000, 45000, 545000, 'BELUM');

-- ================================================
-- INSERT ANGSURAN (Pembayaran yang sudah dilakukan)
-- ================================================

INSERT INTO angsuran (pinjaman_id, angsuran_ke, tanggal_bayar, pokok_bayar, bunga_bayar, denda, total, diterima_oleh, keterangan, created_at) VALUES
(1, 1, '2024-12-10', 416667, 75000, 0, 491667, 2, 'Pembayaran angsuran ke-1', '2024-12-10 10:00:00'),
(2, 1, '2024-12-20', 416667, 150000, 0, 566667, 2, 'Pembayaran angsuran ke-1', '2024-12-20 11:00:00');

-- ================================================
-- INSERT KAS TRANSAKSI (dari simpanan dan pinjaman)
-- ================================================

-- Kas Masuk dari Simpanan
INSERT INTO kas_transaksi (tanggal, tipe, sumber, ref_table, ref_id, jumlah, catatan, dibuat_oleh) VALUES
(NOW(), 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 1, 500000, 'Setor simpanan Ahmad Rizki', 2),
(NOW(), 'KAS_MASUK', 'SIMPANAN', 'simpanan_transaksi', 2, 1000000, 'Setor simpanan Siti Nurhaliza', 2);

-- Kas Keluar dari Pencairan Pinjaman
INSERT INTO kas_transaksi (tanggal, tipe, sumber, ref_table, ref_id, jumlah, catatan, dibuat_oleh) VALUES
('2024-11-10', 'KAS_KELUAR', 'PENCAIRAN_PINJAMAN', 'pinjaman', 1, 4950000, 'Pencairan pinjaman Ahmad (Rp 5jt - admin 50rb)', 2),
('2024-11-20', 'KAS_KELUAR', 'PENCAIRAN_PINJAMAN', 'pinjaman', 2, 9900000, 'Pencairan pinjaman Siti (Rp 10jt - admin 100rb)', 2);

-- Kas Masuk dari Angsuran
INSERT INTO kas_transaksi (tanggal, tipe, sumber, ref_table, ref_id, jumlah, catatan, dibuat_oleh) VALUES
('2024-12-10', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 1, 491667, 'Pembayaran angsuran Ahmad', 2),
('2024-12-20', 'KAS_MASUK', 'ANGSURAN', 'angsuran', 2, 566667, 'Pembayaran angsuran Siti', 2);

-- ================================================
-- INSERT PINJAMAN APPROVAL
-- ================================================

INSERT INTO pinjaman_approval (pinjaman_id, oleh_user_id, keputusan, catatan, tanggal) VALUES
(1, 3, 'SETUJU', 'Disetujui untuk dicairkan', '2024-11-05 14:00:00'),
(2, 3, 'SETUJU', 'Disetujui dengan tenor 24 bulan', '2024-11-18 15:00:00'),
(3, 3, 'SETUJU', 'Disetujui untuk keperluan pendidikan', '2024-12-03 10:00:00');

-- ================================================
-- SELESAI
-- ================================================

-- Update auto increment
ALTER TABLE users AUTO_INCREMENT = 9;
ALTER TABLE anggota AUTO_INCREMENT = 11;
ALTER TABLE pinjaman AUTO_INCREMENT = 6;
ALTER TABLE angsuran AUTO_INCREMENT = 3;

SELECT 'Seed data berhasil diinsert!' as message;