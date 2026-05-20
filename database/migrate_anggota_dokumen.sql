-- ============================================================
-- MIGRATION: CREATE anggota_dokumen TABLE
-- ============================================================
USE ksp_koperasinat;

CREATE TABLE IF NOT EXISTS anggota_dokumen (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  anggota_id BIGINT UNSIGNED NOT NULL,
  jenis_dokumen ENUM('ktp', 'kk', 'pengajuan', 'perjanjian') NOT NULL,
  nama_file VARCHAR(255) NOT NULL,
  drive_file_id VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_anggota_dokumen_anggota
    FOREIGN KEY (anggota_id) REFERENCES anggota(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;
