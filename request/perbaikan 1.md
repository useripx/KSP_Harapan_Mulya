# Dokumentasi Perbaikan 1: Perubahan Nama Instansi

**Tanggal:** 23 April 2026
**Deskripsi:** Mengubah seluruh referensi nama instansi dari **KSP Harapan Mulya** menjadi **Koperasi Harapan Mulya** sesuai dengan permintaan pihak koperasi. Perubahan ini dilakukan secara menyeluruh pada aplikasi untuk memastikan konsistensi penamaan identitas koperasi.

## Daftar File yang Diperbarui

### 1. Konfigurasi Utama
- `app/config/app.php`: Mengubah nama dan deskripsi aplikasi di dalam konfigurasi dasar sistem.

### 2. Tampilan Antarmuka (Views) & Layouts
- `views/layout/sidebar.php`: Memperbarui nama yang muncul di bagian atas menu navigasi sidebar.
- `views/layout/main.php`: Memperbarui nama yang tampil pada *title bar* tab browser pengguna.
- `views/layout/footer.php`: Memperbarui teks *copyright* di bagian bawah aplikasi.
- `views/auth/login.php`: Memperbarui judul halaman, teks panduan hubungi pihak koperasi, dan footer halaman otentikasi.

### 3. Tampilan Detail dan Komponen Bukti/Kwitansi
- `views/angsuran/detail.php`: Memperbarui bagian kop dan footer pada detail cetak kwitansi angsuran.
- `views/laporan/_filter_form.php`: Memperbarui kop cetak PDF untuk laporan. (Teks kapital diubah dari `KSP HARAPAN MULYA` menjadi `KOPERASI HARAPAN MULYA`).

### 4. Tampilan Laporan Keuangan Khusus Cetak
- `views/laporan/neraca.php`: Memperbarui nama di kop tampilan laporan cetak.
- `views/laporan/shu.php`: Memperbarui nama di kop tampilan laporan cetak.
- `views/laporan/tunggakan.php`: Memperbarui nama di kop tampilan laporan cetak.
- `views/laporan/laba_rugi.php`: Memperbarui nama di kop tampilan laporan cetak.

### 5. Dokumentasi & Skrip Database
- `README.md`: Memperbarui dokumentasi utama repositori.
- `request/major_update.md`: Memperbarui nama dalam catatan pembaruan sistem.
- `request/dokumentasi_fix.md`: Memperbarui nama instansi terkait catatan perbaikan kompatibilitas database.
- `database/seed.sql`: Memperbarui teks komentar keterangan data *dummy*.

## Catatan
Perubahan ini murni pada aspek teks visual (*text rendering*) dan nama variabel statis, tidak ada perubahan logika bisnis maupun skema database (tabel/kolom) yang terkait dengan perubahan nama ini.
