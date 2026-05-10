# Changelog Sementara - KSP Harapan Mulya (Versi 21+)

Log ini merangkum seluruh pembaruan signifikan yang dilakukan mulai dari Versi 21. Seluruh dokumentasi di bawah Versi 21 telah dihapus untuk menjaga kerapihan folder perbaikan.

---

## [V21b] - 2026-05-02 (Update Terbaru)

### Penambahan Fitur Keamanan
- **Forced Password Reset**: Implementasi halaman reset password penuh (Mandatory) untuk pengguna dengan password default (Username = Password).
- **Kompleksitas Password**: Menambahkan syarat minimal 6 karakter, huruf besar, huruf kecil, dan angka.
- **Pengingat Keamanan Bulanan**: Penambahan pop-up otomatis setiap tanggal 1 untuk edukasi keamanan akun.

### Peningkatan Dashboard & Laporan
- **Suku Bunga Dinamis**: Manager kini dapat mengatur suku bunga jangka pendek (1 bulan) dan jangka besar (>1 bulan) langsung dari menu Pengaturan.
- **Simulasi Pinjaman**: Kalkulasi simulasi pinjaman kini otomatis mengambil data suku bunga terbaru dari database.
- **Dropdown Baris Data**: Menambahkan fitur pemilihan jumlah baris tabel (5, 10, 15, 20, 25) pada daftar pinjaman.
- **Filter Status Pinjaman**: Penambahan dropdown filter status (Diajukan, Berjalan, Lunas, dll) pada manajemen pinjaman.

### Perbaikan Sistem (Bug Fixes)
- **Logika ID Anggota**: Perubahan prefix Nomor Anggota menjadi 1 huruf inisial nama depan (Contoh: B0001).
- **Fix Layout Footer**: Perbaikan CSS Flexbox agar footer tidak tertutup kotak konten pada berbagai resolusi layar.
- **Fix DIV Ghosting**: Pembersihan tag HTML redundan yang menyebabkan kerusakan layout pada halaman Pengaturan dan Manajemen User.

---

## [V21a] - 2026-05-01

### Dashboard Manager (Analitik)
- **Filter Tahun Historis**: Menambahkan kemampuan Manager untuk melihat data simpanan dan anggota pada tahun-tahun sebelumnya.
- **Akumulasi Saldo Tahunan**: Implementasi logika perhitungan saldo akhir tahunan berdasarkan masa keanggotaan.
- **Daftar Anggota Dinamis**: Filter otomatis daftar anggota yang muncul hanya jika mereka sudah terdaftar pada tahun yang dipilih.

---

## Daftar File yang Terlibat dalam Pembaruan 21+
- `app/controllers/AuthController.php` (Security & Settings)
- `app/controllers/PinjamanController.php` (Interest & Simulation)
- `app/controllers/DashboardController.php` (Manager Analytics)
- `app/controllers/LaporanController.php` (Date Filtering)
- `app/models/Anggota.php` (ID Generation)
- `app/core/Controller.php` (Forced Redirect)
- `views/auth/force_password.php` [NEW]
- `views/layout/main.php` (Global UI & Reminders)
- `views/auth/settings.php` (Rate UI)

---
*Changelog ini bersifat sementara dan akan diperbarui setiap kali ada rilis versi baru.*
