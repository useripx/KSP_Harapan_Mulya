# Dokumentasi Lengkap Perbaikan & Update V21b - KSP Harapan Mulya

Dokumen ini merangkum seluruh perubahan fitur, pembenahan error, dan peningkatan fungsionalitas yang telah diimplementasikan secara komprehensif.

---

## 1. Modul Suku Bunga Dinamis & Logika Pinjaman

**ROLE**: ADMIN, KETUA (MANAGER)
**Path**: `app/controllers/PinjamanController.php` (L:116, 371), `views/anggota/simulasi.php`
**Keterangan Update**: 
- Menghapus bunga *hardcoded* (1% & 0.6%) dan menggantinya dengan penarikan data dinamis dari database.
- Memperbarui label "Bunga" pada simulasi agar otomatis menyesuaikan dengan kebijakan manager.
- Implementasi logika: Tenor 1 bulan menggunakan `bunga_jangka_pendek`, Tenor > 1 bulan menggunakan `bunga_jangka_panjang`.

---

## 2. Fitur Filter & Baris Data (Pagination Row Count)

**ROLE**: ALL ROLES (Admin, Manager, BAU)
**Path**: `views/pinjaman/index.php`
**Keterangan Update**:
- **Filter Status**: Menambahkan dropdown filter status (Diajukan, Diverifikasi, Disetujui, Berjalan, Lunas) di sebelah search bar.
- **Jumlah Baris**: Menambahkan dropdown pilihan tampil 5, 10, 15, 20, atau 25 baris data per halaman.
- **UI Cleaning**: Menghapus kolom "Status" di dalam tabel karena sudah terwakili oleh filter dropdown di atas, memberikan ruang lebih luas untuk data nominal.

**Code Modifikasi (HTML Filter)**:
```html
<select id="pinjamanRowsPerPage" class="form-select form-select-sm shadow-sm">...</select>
<select id="pinjamanStatusFilter" class="form-select form-select-sm shadow-sm">...</select>
```

---

## 3. Laporan Simpanan & SHU (Filter Tahunan)

**ROLE**: ADMIN, KETUA
**Path**: `app/controllers/LaporanController.php` (L:27-54), `views/laporan/shu.php`
**Keterangan Update**:
- **Filter Periode**: Memperbarui `buildDateFilter` untuk mendukung filter Harian, Bulanan, dan Tahunan.
- **Logika SHU**: Jika user memilih tahun (misal 2024), sistem akan memfilter seluruh aktivitas anggota, total saldo akhir, dan ringkasan transaksi hanya pada tahun tersebut.
- **Penggantian Simpanan**: Optimasi query laporan untuk memastikan saldo yang ditampilkan adalah saldo akhir per periode yang dipilih, bukan saldo *lifetime*.

---

## 4. Pembenahan Error & Layout (Bug Fixing)

**ROLE**: ALL ROLES
**Path**: `views/auth/settings.php` (L:218), `views/user/index.php` (L:188), `views/layout/main.php` (L:277, 656)
**Keterangan Update**:
- **DIV Ghosting**: Menghapus kelebihan tag penutup `</div>` pada halaman Pengaturan dan Manajemen User yang menyebabkan layout "pecah" dan footer tidak terlihat.
- **Footer Overlap**: Memperbaiki CSS pada `.main-content` dengan Flexbox (`display: flex; flex-direction: column;`) untuk memastikan footer selalu berada di posisi paling bawah dan tidak tertutup oleh kotak konten (Informasi Akun).

---

## 5. Keamanan Akun & Reset Password Wajib

**ROLE**: ALL ROLES
**Path**: `views/auth/force_password.php` [NEW], `app/core/Controller.php` (L:13)
**Keterangan Update**:
- **Full Page Reset**: Mengganti modal peringatan menjadi satu halaman penuh yang wajib diisi.
- **Validasi Ketat**: Menambahkan syarat minimal 6 karakter, mengandung huruf besar, huruf kecil, dan angka.
- **Visual Feedback**: Menambahkan indikator "Password Cocok" dan pesan error merah jika konfirmasi sandi tidak sesuai.

---

## 6. Logika ID Anggota & Password Default

**ROLE**: ADMIN
**Path**: `app/models/Anggota.php` (L:20)
**Keterangan Update**:
- **ID Generator**: Mengubah awalan Nomor Anggota menjadi hanya 1 huruf depan (misal: B0001 untuk Budi).
- **Auto Password**: Sistem kini otomatis mendeteksi jika password user masih sama dengan ID/Username-nya dan akan langsung mengunci akses hingga password diganti.

---

## 7. Pengingat Keamanan Bulanan (Monthly Security Reminder)

**ROLE**: ALL ROLES
**Path**: `views/layout/main.php`
**Keterangan Update**: 
- Menambahkan logika pengecekan tanggal otomatis. Jika sistem mendeteksi hari ini adalah **tanggal 1**, maka akan muncul modal (pop-up) pengingat keamanan.
- **Tujuan**: Edukasi pengguna untuk melakukan penggantian kata sandi secara berkala demi menghindari kebocoran data.
- **Frekuensi**: Pop-up hanya muncul 1 kali dalam hari tersebut (menggunakan session tracking).

---

## 8. Hasil Pengujian & Verifikasi (Screenshots)

Berikut adalah hasil pengujian fitur-fitur baru pada versi V21b:

### A. Dashboard Validator (Admin)
![Dashboard Validator](file:///C:/Users/yogia/.gemini/antigravity/brain/5f63733b-3fa5-4157-8d09-b06ac548bbe5/validator_dashboard_1777736861649.png)
*Menampilkan ringkasan sistem secara *real-time*.*

### B. Pengaturan Suku Bunga (Manager)
![Pengaturan Suku Bunga](file:///C:/Users/yogia/.gemini/antigravity/brain/5f63733b-3fa5-4157-8d09-b06ac548bbe5/interest_rate_settings_1777737036325.png)
*Antarmuka pengaturan bunga jangka pendek dan jangka besar yang dinamis.*

### C. Daftar Pinjaman (Filter & Dropdown)
![Daftar Pinjaman](file:///C:/Users/yogia/.gemini/antigravity/brain/5f63733b-3fa5-4157-8d09-b06ac548bbe5/pinjaman_table_dropdowns_1777736925326.png)
*Implementasi filter status dan pemilihan jumlah baris data (5, 10, 15, 20, 25).*

### D. Dashboard Anggota (Budi Santoso)
![Dashboard Anggota](file:///C:/Users/yogia/.gemini/antigravity/brain/5f63733b-3fa5-4157-8d09-b06ac548bbe5/member_dashboard_1777737122950.png)
*Tampilan dashboard untuk anggota koperasi.*

---

## SARAN PENGEMBANGAN

1.  **Consistency**: Terapkan dropdown "Tampil Baris Data" ke seluruh tabel (Anggota, Simpanan, User) agar user experience seragam di seluruh aplikasi.
2.  **Export Data**: Tambahkan tombol "Export Excel/PDF" pada setiap laporan yang sudah difilter per tahun agar memudahkan pengarsipan fisik.

---
*Dokumentasi V21b - Terakhir diperbarui: 03 Mei 2026*
