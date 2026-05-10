-- ================================================
-- MIGRATION: Update ENUM tipe anggota
-- Tanggal: 23 April 2026
-- Deskripsi: Mengubah nilai ENUM kolom 'tipe' pada tabel 'anggota'
--            dari (MAHASISWA, DOSEN, STAF, UMUM)
--            menjadi (DOSEN TETAP, DOSEN KONTRAK, DOSEN TIDAK TETAP,
--                     KARYAWAN TETAP, KARYAWAN KONTRAK, KARYAWAN TIDAK TETAP)
-- ================================================

-- 1. Ubah ENUM kolom tipe
ALTER TABLE anggota 
MODIFY COLUMN tipe ENUM(
    'DOSEN TETAP',
    'DOSEN KONTRAK',
    'DOSEN TIDAK TETAP',
    'KARYAWAN TETAP',
    'KARYAWAN KONTRAK',
    'KARYAWAN TIDAK TETAP'
) NOT NULL DEFAULT 'KARYAWAN TETAP';

-- 2. Update data lama agar sesuai dengan nilai ENUM baru
UPDATE anggota SET tipe = 'DOSEN TETAP' WHERE tipe = 'DOSEN';
UPDATE anggota SET tipe = 'KARYAWAN TETAP' WHERE tipe = 'STAF';
UPDATE anggota SET tipe = 'KARYAWAN TETAP' WHERE tipe = 'UMUM';
UPDATE anggota SET tipe = 'KARYAWAN TETAP' WHERE tipe = 'MAHASISWA';

SELECT 'Migration tipe anggota berhasil!' AS message;
