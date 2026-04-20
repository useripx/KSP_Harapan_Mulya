-- ============================================================
-- DATABASE: ksp_koperasi (MySQL/MariaDB)
-- ============================================================
CREATE DATABASE IF NOT EXISTS ksp_koperasi
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ksp_koperasi;

-- ============================================================
-- 1) USERS
-- ============================================================
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NULL UNIQUE,
  username VARCHAR(60) NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('ADMIN','TELLER','KETUA','ANGGOTA') NOT NULL DEFAULT 'ANGGOTA',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  last_login_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- 2) ANGGOTA
-- ============================================================
CREATE TABLE anggota (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  no_anggota VARCHAR(30) NOT NULL UNIQUE,
  nama VARCHAR(120) NOT NULL,
  tipe ENUM('MAHASISWA','DOSEN','STAF','UMUM') NOT NULL DEFAULT 'UMUM',
  identitas_no VARCHAR(40) NULL,     -- NIM/NIP/KTP
  prodi_unit VARCHAR(120) NULL,
  no_hp VARCHAR(25) NULL,
  alamat TEXT NULL,
  tgl_daftar DATE NOT NULL,
  status ENUM('AKTIF','NONAKTIF','KELUAR') NOT NULL DEFAULT 'AKTIF',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_anggota_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- 3) SETTING KOPERASI (aturan global)
-- ============================================================
CREATE TABLE setting_koperasi (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  bunga_pinjaman_persen_bln DECIMAL(5,2) NOT NULL DEFAULT 1.50,
  denda_telat_persen DECIMAL(5,2) NOT NULL DEFAULT 5.00,
  plafon_x_saldo DECIMAL(6,2) NOT NULL DEFAULT 3.00,
  tenor_maks_bulan INT UNSIGNED NOT NULL DEFAULT 12,
  potongan_admin DECIMAL(14,2) NOT NULL DEFAULT 0,
  minimum_simpanan_wajib DECIMAL(14,2) NOT NULL DEFAULT 0,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO setting_koperasi
(bunga_pinjaman_persen_bln, denda_telat_persen, plafon_x_saldo, tenor_maks_bulan, potongan_admin, minimum_simpanan_wajib)
VALUES (1.50, 5.00, 3.00, 12, 0, 20000);

-- ============================================================
-- 4) SIMPANAN TRANSAKSI (SETOR/TARIK/TRANSFER)
-- ============================================================
CREATE TABLE simpanan_transaksi (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  anggota_id BIGINT UNSIGNED NOT NULL,
  tipe ENUM('SETOR','TARIK','TRANSFER') NOT NULL,
  tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  jumlah DECIMAL(14,2) NOT NULL CHECK (jumlah > 0),
  tujuan_anggota_id BIGINT UNSIGNED NULL,   -- untuk TRANSFER
  keterangan VARCHAR(255) NULL,
  dibuat_oleh BIGINT UNSIGNED NULL,         -- user teller/admin
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_simpanan_anggota_tgl (anggota_id, tanggal),
  INDEX idx_simpanan_tipe (tipe),

  CONSTRAINT fk_simp_anggota
    FOREIGN KEY (anggota_id) REFERENCES anggota(id)
    ON UPDATE CASCADE ON DELETE RESTRICT,

  CONSTRAINT fk_simp_tujuan
    FOREIGN KEY (tujuan_anggota_id) REFERENCES anggota(id)
    ON UPDATE CASCADE ON DELETE SET NULL,

  CONSTRAINT fk_simp_user
    FOREIGN KEY (dibuat_oleh) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- 5) PINJAMAN
-- status: DIAJUKAN -> DIVERIFIKASI -> DISETUJUI/DITOLAK -> DICAIRKAN -> BERJALAN -> LUNAS
-- ============================================================
CREATE TABLE pinjaman (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  anggota_id BIGINT UNSIGNED NOT NULL,
  tgl_pengajuan DATE NOT NULL,
  pokok DECIMAL(14,2) NOT NULL CHECK (pokok > 0),
  tenor_bulan INT UNSIGNED NOT NULL CHECK (tenor_bulan > 0),
  metode ENUM('FLAT','MENURUN','ANUITAS') NOT NULL DEFAULT 'FLAT',
  bunga_persen_bln DECIMAL(5,2) NOT NULL DEFAULT 1.50,
  potongan_admin DECIMAL(14,2) NOT NULL DEFAULT 0,
  tujuan VARCHAR(255) NULL,

  status ENUM('DIAJUKAN','DIVERIFIKASI','DISETUJUI','DITOLAK','DICAIRKAN','BERJALAN','LUNAS')
    NOT NULL DEFAULT 'DIAJUKAN',

  tgl_disetujui DATE NULL,
  tgl_cair DATE NULL,

  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_pinj_anggota_status (anggota_id, status),

  CONSTRAINT fk_pinj_anggota
    FOREIGN KEY (anggota_id) REFERENCES anggota(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================================
-- 6) PINJAMAN APPROVAL (riwayat keputusan ketua/manajer)
-- ============================================================
CREATE TABLE pinjaman_approval (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pinjaman_id BIGINT UNSIGNED NOT NULL,
  oleh_user_id BIGINT UNSIGNED NOT NULL,
  keputusan ENUM('SETUJU','TOLAK') NOT NULL,
  catatan VARCHAR(255) NULL,
  tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_app_pinj (pinjaman_id),

  CONSTRAINT fk_app_pinj
    FOREIGN KEY (pinjaman_id) REFERENCES pinjaman(id)
    ON UPDATE CASCADE ON DELETE CASCADE,

  CONSTRAINT fk_app_user
    FOREIGN KEY (oleh_user_id) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================================
-- 7) PINJAMAN JADWAL (schedule angsuran)
-- ============================================================
CREATE TABLE pinjaman_jadwal (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pinjaman_id BIGINT UNSIGNED NOT NULL,
  angsuran_ke INT UNSIGNED NOT NULL,
  jatuh_tempo DATE NOT NULL,

  pokok_tagih DECIMAL(14,2) NOT NULL DEFAULT 0,
  bunga_tagih DECIMAL(14,2) NOT NULL DEFAULT 0,
  total_tagih DECIMAL(14,2) NOT NULL,

  status ENUM('BELUM','BAYAR') NOT NULL DEFAULT 'BELUM',

  UNIQUE KEY uq_jadwal (pinjaman_id, angsuran_ke),
  INDEX idx_jadwal_jt (jatuh_tempo),

  CONSTRAINT fk_jadwal_pinj
    FOREIGN KEY (pinjaman_id) REFERENCES pinjaman(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 8) ANGSURAN (pembayaran)
-- ============================================================
CREATE TABLE angsuran (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pinjaman_id BIGINT UNSIGNED NOT NULL,
  angsuran_ke INT UNSIGNED NOT NULL,
  tanggal_bayar DATE NOT NULL,

  pokok_bayar DECIMAL(14,2) NOT NULL DEFAULT 0,
  bunga_bayar DECIMAL(14,2) NOT NULL DEFAULT 0,
  denda DECIMAL(14,2) NOT NULL DEFAULT 0,
  total DECIMAL(14,2) NOT NULL,

  diterima_oleh BIGINT UNSIGNED NULL,
  keterangan VARCHAR(255) NULL,

  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_angsuran_pinj (pinjaman_id),
  INDEX idx_angsuran_tgl (tanggal_bayar),

  CONSTRAINT fk_angsuran_pinj
    FOREIGN KEY (pinjaman_id) REFERENCES pinjaman(id)
    ON UPDATE CASCADE ON DELETE RESTRICT,

  CONSTRAINT fk_angsuran_user
    FOREIGN KEY (diterima_oleh) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- 9) KAS TRANSAKSI (audit kas masuk/keluar)
-- ============================================================
CREATE TABLE kas_transaksi (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  tipe ENUM('KAS_MASUK','KAS_KELUAR') NOT NULL,
  sumber ENUM('SIMPANAN','PENCAIRAN_PINJAMAN','ANGSURAN','OPERASIONAL','LAINNYA') NOT NULL,
  ref_table VARCHAR(50) NULL,
  ref_id BIGINT UNSIGNED NULL,
  jumlah DECIMAL(14,2) NOT NULL,
  catatan VARCHAR(255) NULL,
  dibuat_oleh BIGINT UNSIGNED NULL,

  INDEX idx_kas_tgl (tanggal),
  INDEX idx_kas_ref (ref_table, ref_id),

  CONSTRAINT fk_kas_user
    FOREIGN KEY (dibuat_oleh) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- 10) AUDIT LOGS
-- ============================================================
CREATE TABLE audit_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  aksi VARCHAR(120) NOT NULL,       -- contoh: 'LOGIN', 'CREATE_PINJAMAN'
  objek VARCHAR(120) NULL,          -- contoh: 'pinjaman'
  objek_id BIGINT UNSIGNED NULL,
  detail TEXT NULL,
  ip_address VARCHAR(45) NULL,
  user_agent VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_audit_user (user_id),
  INDEX idx_audit_obj (objek, objek_id),

  CONSTRAINT fk_audit_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- 11) NOTIFIKASI (WA/Email queue)
-- ============================================================
CREATE TABLE notifikasi (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  channel ENUM('WA','EMAIL') NOT NULL,
  tujuan VARCHAR(150) NOT NULL,
  judul VARCHAR(150) NULL,
  pesan TEXT NOT NULL,
  status ENUM('QUEUE','SENT','FAILED') NOT NULL DEFAULT 'QUEUE',
  last_error VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- VIEW 1: SALDO SIMPANAN PER ANGGOTA
-- saldo = total SETOR + transfer_masuk - TARIK - transfer_keluar
-- ============================================================
CREATE OR REPLACE VIEW v_saldo_simpanan AS
SELECT
  a.id AS anggota_id,
  a.no_anggota,
  a.nama,
  COALESCE(SUM(
    CASE
      WHEN st.tipe='SETOR' THEN st.jumlah
      WHEN st.tipe='TARIK' THEN -st.jumlah
      WHEN st.tipe='TRANSFER' AND st.anggota_id=a.id THEN -st.jumlah
      WHEN st.tipe='TRANSFER' AND st.tujuan_anggota_id=a.id THEN st.jumlah
      ELSE 0
    END
  ),0) AS saldo
FROM anggota a
LEFT JOIN simpanan_transaksi st
  ON (st.anggota_id=a.id OR st.tujuan_anggota_id=a.id)
GROUP BY a.id, a.no_anggota, a.nama;

-- ============================================================
-- VIEW 2: RINGKASAN PINJAMAN (dibayar & sisa) - estimasi sederhana
-- ============================================================
CREATE OR REPLACE VIEW v_ringkasan_pinjaman AS
SELECT
  p.id AS pinjaman_id,
  p.anggota_id,
  p.pokok,
  p.tenor_bulan,
  p.metode,
  p.bunga_persen_bln,
  p.status,
  COALESCE(SUM(a.total),0) AS total_dibayar,
  (p.pokok - COALESCE(SUM(a.pokok_bayar),0)) AS sisa_pokok
FROM pinjaman p
LEFT JOIN angsuran a ON a.pinjaman_id = p.id
GROUP BY p.id;

-- ============================================================
-- VIEW 3: TUNGGAKAN (jadwal BELUM & sudah lewat jatuh tempo)
-- ============================================================
CREATE OR REPLACE VIEW v_tunggakan AS
SELECT
  j.pinjaman_id,
  p.anggota_id,
  a2.no_anggota,
  a2.nama,
  j.angsuran_ke,
  j.jatuh_tempo,
  j.total_tagih,
  DATEDIFF(CURDATE(), j.jatuh_tempo) AS hari_telat
FROM pinjaman_jadwal j
JOIN pinjaman p ON p.id=j.pinjaman_id
JOIN anggota a2 ON a2.id=p.anggota_id
WHERE j.status='BELUM' AND j.jatuh_tempo < CURDATE();
