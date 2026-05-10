# Dokumentasi Perbaikan & Update Sistem (Consolidated)

Dokumen ini merangkum seluruh perbaikan dan pembaruan yang dilakukan pada sistem Koperasi Harapan Mulya.

---

## 🟢 PERBAIKAN 1: Perubahan Identitas Instansi (23 April 2026)

**Deskripsi:** Mengubah seluruh referensi nama instansi dari **KSP Harapan Mulya** menjadi **Koperasi Harapan Mulya** untuk konsistensi branding.

### File yang Diperbarui:
- **Konfigurasi**: `app/config/app.php` (Nama & deskripsi aplikasi).
- **Layout Utama**: 
    - `views/layout/sidebar.php` (Brand header).
    - `views/layout/main.php` (Browser title bar).
    - `views/layout/footer.php` (Copyright text).
- **Halaman Login**: `views/auth/login.php` (Logo, footer, dan teks panduan).
- **Kwitansi & Laporan**: 
    - `views/angsuran/detail.php` (Kop kwitansi).
    - `views/laporan/_filter_form.php` (Kop laporan PDF).
    - `views/laporan/neraca.php`, `shu.php`, `tunggakan.php`, `laba_rugi.php` (Header laporan).
- **Dokumentasi**: `README.md`, `request/major_update.md`, `database/seed.sql`.

---

## 🔵 PERBAIKAN 2: Sinkronisasi Database & Otomasi Simulasi (24 April 2026)

**Deskripsi:** Sinkronisasi kategori anggota v18, perbaikan error database, dan otomasi fitur simulasi pinjaman.

### 1. Sinkronisasi Database (Fix Error Data Truncated)
Mencegah error saat pendaftaran anggota baru karena ketidakcocokan kategori.
- **`app/config/constants.php`**: Update konstanta `TIPE_DOSEN_TETAP`, `TIPE_KARYAWAN_TETAP`, dll.
- **`database/schema.sql`**: Update definisi `ENUM` (tipe & status) pada tabel anggota.
- **`database/seed.sql`**: Update data dummy ke kategori v18.
- **`Live Migration`**: Eksekusi SQL untuk mengubah struktur tabel dan migrasi data lama (Contoh: `STAF` → `KARYAWAN TETAP`).

### 2. Perbaikan UI & Validasi
- **`views/anggota/edit.php`**: Perbaikan nilai `NON-AKTIF` agar sinkron antara dropdown dan database.

### 3. Otomasi Simulasi Peminjaman
Penyederhanaan kalkulator simulasi agar lebih cerdas.
- **`views/anggota/simulasi.php`**: 
    - **Bunga Otomatis**: Tenor 1 bln = 1%, Tenor 2-35 bln = 0.6%.
    - **Dropdown Dihapus**: Diganti tampilan otomatis (read-only) untuk memudahkan pengguna.
    - **JS Real-time**: Label bunga update seketika saat user mengetik tenor.

---

## 🛠️ CARA UPDATE (SINKRONISASI) UNTUK TIM
Agar perubahan ini berjalan di PC lain, ikuti langkah berikut:

### Langkah 1: Ganti File Kode
Salin dan replace file berikut dari versi terbaru:
1.  `app/config/constants.php`
2.  `database/schema.sql`
3.  `database/seed.sql`
4.  `views/anggota/edit.php`
5.  `views/anggota/simulasi.php`

### Langkah 2: Jalankan Perintah SQL (Terminal)
Buka terminal/CMD di folder proyek, lalu jalankan perintah ini untuk menyinkronkan database:

```bash
# Pastikan Anda berada di folder proyek, lalu jalankan:
mysql -u root -e "USE ksp_koperasinat; ALTER TABLE anggota MODIFY COLUMN tipe ENUM('MAHASISWA','DOSEN','STAF','UMUM', 'DOSEN TETAP', 'DOSEN KONTRAK', 'DOSEN TIDAK TETAP', 'KARYAWAN TETAP', 'KARYAWAN KONTRAK', 'KARYAWAN TIDAK TETAP') NOT NULL DEFAULT 'UMUM'; UPDATE anggota SET tipe = 'DOSEN TETAP' WHERE tipe = 'DOSEN'; UPDATE anggota SET tipe = 'KARYAWAN TETAP' WHERE tipe IN ('STAF', 'UMUM', 'MAHASISWA'); ALTER TABLE anggota MODIFY COLUMN tipe ENUM('DOSEN TETAP', 'DOSEN KONTRAK', 'DOSEN TIDAK TETAP', 'KARYAWAN TETAP', 'KARYAWAN KONTRAK', 'KARYAWAN TIDAK TETAP') NOT NULL DEFAULT 'KARYAWAN TETAP'; ALTER TABLE anggota MODIFY COLUMN status ENUM('AKTIF','NONAKTIF','NON-AKTIF','KELUAR') NOT NULL DEFAULT 'AKTIF'; UPDATE anggota SET status = 'NON-AKTIF' WHERE status = 'NONAKTIF'; ALTER TABLE anggota MODIFY COLUMN status ENUM('AKTIF','NON-AKTIF','KELUAR') NOT NULL DEFAULT 'AKTIF';"
```

---

## 📝 Catatan Akhir
Seluruh pembaruan telah diuji untuk memastikan kompatibilitas data lama dengan struktur baru. Sistem kini lebih konsisten secara branding dan lebih stabil dalam menangani input data anggota serta simulasi keuangan.
