-- ============================================================
-- MIGRATION: Rename Roles
-- ADMIN  -> VALIDATOR
-- TELLER -> BAU
-- KETUA  -> MANAGER
-- ANGGOTA tetap ANGGOTA
-- Jalankan di database ksp_koperasi
-- ============================================================

USE ksp_koperasi;

-- Step 1: Ubah ENUM dulu dengan menambah nilai baru
ALTER TABLE users
  MODIFY COLUMN role ENUM('ADMIN','TELLER','KETUA','ANGGOTA','VALIDATOR','BAU','MANAGER')
  NOT NULL DEFAULT 'ANGGOTA';

-- Step 2: Update data yang ada
UPDATE users SET role = 'VALIDATOR' WHERE role = 'ADMIN';
UPDATE users SET role = 'BAU'       WHERE role = 'TELLER';
UPDATE users SET role = 'MANAGER'   WHERE role = 'KETUA';

-- Step 3: Hapus nilai ENUM lama
ALTER TABLE users
  MODIFY COLUMN role ENUM('VALIDATOR','BAU','MANAGER','ANGGOTA')
  NOT NULL DEFAULT 'ANGGOTA';

SELECT 'Migrasi role selesai!' AS status;
SELECT role, COUNT(*) AS jumlah FROM users GROUP BY role;
