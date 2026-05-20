# Proyek Koperasi Harapan Mulya - Changelog

Seluruh riwayat perubahan sistem Koperasi Harapan Mulya dicatat secara mendetail per versi di bawah ini.

---

## [Update v25] - 2026-05-20
### **Bypass Kuota Google Drive via Google Apps Script Proxy & Auto-PDF**

#### **1. Integrasi Google Apps Script Web App (Bypass Kuota 0 Byte)**
- **Bypass Kuota Cloud**: Migrasi backend Google Drive dari otentikasi offline Service Account (yang dibatasi kuota 0 byte oleh Google untuk akun personal) ke **Google Apps Script Web App Proxy** yang memanfaatkan kuota 15 GB gratis milik akun Gmail pribadi (`koperasiharapanmulyaunp@gmail.com`).
- **Driver GoogleDriveService Baru**: Menulis ulang [GoogleDriveService.php](file:///c:/laragon/www/Ksp_Koperasinat/app/services/GoogleDriveService.php) menggunakan client cURL PHP ringan asinkron yang mendukung redirect HTTP 302 otomatis, pengiriman data Base64 berkas, pengelolaan folder berjenjang dinamis, dan penghapusan sinkron.
- **Kompatibilitas Penuh Tanpa Refactoring Controller**: Menjaga 100% signature method service agar controller `AnggotaController.php` tetap bekerja secara lancar tanpa ada modifikasi baris kode sedikit pun.
- **Konfigurasi Mandiri**: Membuat [google-apps-script-config.json](file:///c:/laragon/www/Ksp_Koperasinat/storage/app/google-apps-script-config.json) untuk memetakan endpoint URL jembatan Apps Script dan Token Pengaman (`api_key`) secara terpisah dan aman dari Git.

#### **2. Standar Dokumentasi & Kerapian Lingkungan**
- **Dokumentasi Panduan Langkah Dari 0**: Membuat panduan premium [proses.md](file:///c:/laragon/www/Ksp_Koperasinat/request/drive/proses.md) yang mengupas deployment Google Apps Script, otorisasi di mode Incognito, visualisasi alur sequence diagram, dan penanganan bug otentikasi Google.
- **Log Walkthrough Baru**: Menambahkan lembar walkthrough Bagian 2 di [walk-20-05.md](file:///c:/laragon/www/Ksp_Koperasinat/request/walkhtrough/walk-20-05.md) yang selaras dengan format historis.
- **Pembersihan Repositori Otomatis**: Menghapus seluruh berkas pengujian dan uji coba sementara (`test_gdrive_flow.php`, `e2e_test_upload.php`, `diagnose_gdrive.php`, `cookie.txt`, dll.) agar lingkungan pengembangan bersih dan siap masuk ke repositori utama.

## [Update v24] - 2026-05-17
### **Modul Pembukuan BAU & Manajemen Dokumen Anggota**

#### **1. Integrasi UI/UX Pelaporan Pembukuan BAU**
- **Kalender Pop-up Premium (Windows 11 Style)**: Implementasi UI pembuatan laporan melalui kalender pop-up terintegrasi penuh di halaman dashboard, menghilangkan kebutuhan form halaman terpisah.
- **Dropdown Tahun Dinamis**: Pilihan navigasi kalender yang di-generate via JavaScript secara dinamis mendukung mundur hingga tahun 1926 dan maju hingga tahun 2126.
- **Penyelarasan Desain Dashboard**: Standardisasi antarmuka kartu laporan dengan gaya *rounded-rect*, aksen *border-left* warna, dan *widget loading glassmorphism* untuk *feedback* interaksi yang instan.

#### **2. Modul Manajemen Berkas Anggota (Backend & UI)**
- **Struktur Database Baru (`anggota_dokumen`)**: Tabel khusus relasi dengan skema *ON DELETE CASCADE* untuk memisahkan berkas fisik (KTP, Perjanjian, Pengajuan) dari tabel profil utama.
- **Sistem Upload Interaktif (Inline)**: Modifikasi fungsi `AnggotaController` (pada modul `detail()` dan `edit()`) untuk mendeteksi ketersediaan berkas dan memunculkan *form multi-part* upload secara dinamis.
- **Manajemen File Tersentralisasi**: Pembuatan direktori `public/uploads/dokumen/` dan logika enkripsi *rename file* otomatis (`{jenis}_{nomor_anggota}_{timestamp}`) agar sistem lebih aman.

## [Update v23] - 2026-05-10
### **Fitur Konfigurasi Simpanan Dinamis (Role Validator)**

#### **1. Pengaturan Simpanan Individu**
- **Autocompelete Pencarian Anggota**: Implementasi pencarian anggota dinamis bergaya Google dengan teknik *Debouncing* pada halaman Pengaturan akun Validator.
- **Form Bebas Kolom**: Menghilangkan atribut *required* untuk memungkinkan Administrator mengatur hanya sebagian simpanan (misal: hanya Motor atau hanya Mobil) untuk anggota tertentu.
- **Smart SweetAlert2**: Penambahan *pop-up* notifikasi keberhasilan yang pintar. Pesan akan menyesuaikan secara dinamis jika diisi salah satu kolom atau keduanya.

#### **2. Dashboard Manager Dinamis**
- **Kolom Ringkasan Cerdas**: Tabel "Ringkasan Data Anggota" kini secara otomatis memunculkan kolom "Simpanan Motor" dan "Simpanan Mobil" jika terdapat setidaknya satu konfigurasi yang aktif.
- **Tabel Rekapitulasi Konfigurasi**: Penambahan tabel khusus di bagian bawah Dashboard Manager yang secara otomatis mengumpulkan semua anggota yang dikonfigurasi simpanannya.

#### **3. Restrukturisasi Database (Hotfix Kritis)**
- **Migrasi `user_id` ke `anggota_id`**: Melakukan modifikasi skema tabel `konfigurasi_simpanan_anggota` untuk memutus keterikatan dengan akun login (`user_id`). 
- **Penyelesaian Bug Berbagi Konfigurasi**: Bug kritis di mana anggota yang belum mempunyai akun login (`user_id = 0`) akan saling tumpang-tindih (*overwrite*) konfigurasinya telah tuntas.
- **Penyelesaian Error Validasi**: Bug "Pilih anggota terlebih dahulu" akibat nilai `0` berhasil diatasi dengan restrukturisasi `anggota_id`.

#### **4. Daftar File Utama yang Dimodifikasi**
- `public/index.php` (Penambahan rute AJAX dan Update)
- `app/controllers/AuthController.php` (Logika simpan, session untuk pop-up)
- `app/controllers/AnggotaController.php` (Penambahan `anggota_id` pada query search)
- `app/controllers/DashboardController.php` (Integrasi tabel dengan konfigurasi)
- `views/auth/settings.php` (Tampilan dropdown pencarian, CSS, Form, dan Alert)
- `views/dashboard/manager.php` (Penambahan tabel Ringkasan Konfigurasi)

## [Update v22] - 2026-05-10
### **Standardisasi UI/UX & Fitur Bunga Dinamis**

#### **1. Perubahan & Perbaikan UI**
- **Standardisasi Navigasi**: Penyeragaman ukuran dan gaya tombol "Kembali" di seluruh modul (Laporan, Settings, Pinjaman) sesuai standar halaman Neraca (`btn-sm`, `px-3`, `shadow-sm`).
- **Header Premium**: Merombak header halaman **Pengajuan Pinjaman** dan **Top Up** agar memiliki struktur yang sama dengan halaman Simpanan (lebih bersih, responsif, dan profesional).
- **Search Suggestion (Google Style)**: Peningkatan UI *dropdown* saran pencarian anggota pada halaman Pengaturan dan Pengajuan Pinjaman agar tampil melayang dengan efek bayangan modern.

#### **2. Fitur Suku Bunga Dinamis (Khusus Role Ketua)**
- **Menu Pengaturan Bunga**: Implementasi tab "Suku Bunga" pada halaman Pengaturan khusus untuk Role Ketua.
- **Integrasi Database**: Menghubungkan form pengaturan dengan kolom `bunga_jangka_pendek` dan `bunga_jangka_panjang` di tabel `setting_koperasi`.
- **Kalkulasi Otomatis**: Seluruh perhitungan bunga pada **Simulasi**, **Pengajuan Baru**, **Top Up**, dan **Detail Pinjaman** kini bersifat dinamis mengikuti pengaturan Ketua.

#### **3. Optimasi Sistem & Pembersihan Kode**
- **Standardisasi Rute**: Menyelaraskan seluruh rute pengajuan pinjaman dari `/pinjaman/baru` menjadi `/pinjaman/ajukan` untuk konsistensi penamaan.
- **Pembersihan File**: Menghapus file view usang `views/pinjaman/baru.php` (digantikan oleh `ajukan.php`).
- **Bug Fixes**:
    - Memperbaiki Fatal Error "Cannot redeclare updateInterestRates" pada `AuthController`.
    - Memperbaiki Syntax Error pada pembuka tag PHP di `PinjamanController`.

#### **4. Daftar File yang Dimodifikasi**
- `app/controllers/PinjamanController.php` (Logika pinjaman & perbaikan syntax)
- `app/controllers/AuthController.php` (Fitur bunga & perbaikan duplikasi fungsi)
- `public/index.php` (Pembaruan rute sistem)
- `views/auth/settings.php` (Form bunga dinamis & UI search)
- `views/pinjaman/ajukan.php` (Header baru & UI search)
- `views/pinjaman/topup.php` (Header baru & navigasi)
- `views/pinjaman/detail.php` (Display bunga dinamis)
- `views/anggota/simulasi.php` (Logika bunga dinamis JS/PHP)
- `views/layout/sidebar.php` & `views/dashboard/anggota.php` (Update rute link)

---

## [Update v21] - 2026-05-02
- **Fitur Reset Sandi Paksa**: Implementasi halaman reset password penuh (Mandatory) untuk akun dengan password default.
- **Suku Bunga Dinamis**: Penambahan menu pengaturan suku bunga (Jangka Pendek & Jangka Besar) oleh Manager.
- **Pengingat Keamanan Bulanan**: Pop-up pengingat ganti sandi otomatis setiap tanggal 1.
- **Analitik Manager**: Fitur filter tahun historis pada dashboard manager.
- **Dropdown Baris Data**: Pilihan jumlah tampilan data (5, 10, 15, 20, 25) pada tabel pinjaman.
- **Logika ID Anggota**: Pembaruan generator ID anggota menggunakan inisial 1 huruf (Contoh: I0001).
- **Perbaikan Layout**: Fix footer overlap dan pembersihan tag DIV ganda.

## [Update v20] - 2026-04-30
- **Audit Role Validator**: Restrukturisasi hak akses role Administrator (Validator) dan Manager.
- **Optimasi Dashboard**: Penyesuaian tampilan dashboard berdasarkan mandat peran terbaru.

## [Update v19] - 2026-04-25
- **Optimasi Laporan Tahunan**: Perbaikan filter periode pada laporan keuangan (Neraca & Laba Rugi).
- **Update Database**: Sinkronisasi skema database `ksp_koperasinat.sql`.

## [Update v18] - 2026-04-22
- **Update Akses Login**: Pembaruan sistem otentikasi dan login akses user.

## [Update v17] - 2026-04-21
- **Integrasi AI Anna**: Implementasi asisten AI pintar berbasis Llama 3 (Groq API).
- **Standardisasi Navigasi**: Penyesuaian alur navigasi antar menu utama.

## [Update v16] - 2026-04-20
- **Fitur Keamanan**: Penguatan sistem keamanan pada level middleware.
- **Standardisasi Layout**: Penyeragaman elemen UI di seluruh halaman.

## [Update v15] - 2026-04-18
- **Integrasi AI Chatbot**: Penambahan UI Chatbot interaktif dengan fitur *suggestions*.
- **Dashboard Update**: Pembaruan visual pada ringkasan statistik.

## [Update v14] - 2026-04-15
- **Fitur Show Password**: Penambahan opsi lihat password pada form login dan pengaturan.
- **Update Pagination**: Pembaruan logika pembagian halaman pada tabel data.

## [Update v13] - 2026-04-12
- **Bagi Requirements**: Pemisahan requirement sistem untuk versi dengan dan tanpa AI.

## [Update v12] - 2026-04-10
- **Notifikasi Glow Dot**: Indikator notifikasi bergaya minimalis (Pulse Red/Steady Green).
- **Smart Database FIFO**: Pembatasan 5 notifikasi terbaru per anggota untuk efisiensi.
- **Mobile Optimization**: Perbaikan Sidebar Toggle dan Topbar pada layar mobile.

## [Update v11] - 2026-04-05
- **AI Credit Scoring**: Analisis kelayakan pinjaman otomatis berbasis AI (0-100 poin).
- **Premium Member Dashboard**: Rekonstruksi total halaman depan anggota.
- **Progress Stepper**: Animasi tahapan pengajuan pinjaman (Diterima -> Ditinjau -> Selesai).
- **Facebook Style Notifications**: Sistem notifikasi real-time dengan AJAX Mark-As-Read.

## [Update v10] - 2026-04-01
- **Integrasi AI Analistik**: Penambahan fondasi awal untuk analisis data berbasis AI.
- **Database Refactor**: Perubahan nama database utama menjadi `ksp_koperasinat`.

## [Update v9] - 2026-03-25
- **Fitur Autodebet**: Implementasi pemotongan simpanan wajib otomatis.
- **Major Bug Maintenance**: Perbaikan bug sistemik pada alur transaksi.

## [Update v8] - 2026-03-20
- **Tema Terang/Gelap**: Penambahan fitur toggle Light/Dark Mode menggunakan Bootstrap 5.x.

## [Update v7] - 2026-03-10
- **Security & Maintenance**: Pemeliharaan rutin pada modul keamanan database.

## [Update v6] - 2026-03-01
- **Fitur Ubah Sandi**: Penambahan menu mandiri untuk penggantian password pengguna.

## [Update v5] - 2026-02-20
- **Update Laporan**: Pembaruan format laporan transaksi dan mutasi simpanan.

## [Update v4] - 2026-02-10
- **Update Angsuran & Cetak Resi**: Fitur pembayaran cicilan dan cetak bukti fisik.
- **MVC Refactor**: Rombak struktur folder menjadi pola Model-View-Controller.

## [Update v3] - 2026-01-25
- **Update Setor & Tarik**: Pembaruan modul transaksi simpanan anggota.
- **Update Pinjaman**: Perbaikan alur pengajuan pinjaman dasar.

## [Update v2] - 2026-01-15
- **Bug Fixes**: Perbaikan bug pada rilis awal sistem.

## [Update v1] - 2026-01-10
- **Initial Release**: Sistem dasar manajemen Anggota, Simpanan, dan Pinjaman.

---
*Dokumentasi Riwayat Versi KSP Harapan Mulya.*
