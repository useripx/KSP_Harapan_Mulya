# Rencana Implementasi: Aktivasi Fitur Pencarian Anggota & Konfigurasi Simpanan (Update 23)

Rencana ini bertujuan untuk mengaktifkan fungsi pencarian anggota (autocomplete) pada halaman Pengaturan, menampilkan saran dari database, serta memungkinkan admin untuk mengonfigurasi parameter simpanan per anggota. Selain itu, tampilan dashboard Manager akan disesuaikan secara dinamis.

## User Review Required

> [!IMPORTANT]
> Akses ke fitur **"Konfigurasi Simpanan"** di halaman Pengaturan telah dikonfirmasi hanya untuk role **Admin (Validator)**.

## Proposed Changes

### 1. Backend (Routing)

#### [MODIFY] [index.php](file:///c:/laragon/www/Ksp_Koperasinat/public/index.php)
Menambahkan rute API dan rute penyimpanan yang diperlukan agar frontend bisa berkomunikasi dengan backend.
- Tambahkan rute `GET /api/settings/savings` untuk mengambil data simpanan anggota.
- Tambahkan rute `POST /settings/savings/update` untuk memproses pembaruan konfigurasi.

### 2. Dashboard Manager (Monitoring)

#### [MODIFY] [DashboardController.php](file:///c:/laragon/www/Ksp_Koperasinat/app/controllers/DashboardController.php)
- Mengambil data dari tabel `konfigurasi_simpanan_anggota` untuk ditampilkan di dashboard Manager.
- Memperbarui query `ringkasanAnggota` agar menyertakan nilai simpanan motor/mobil yang dikonfigurasi.
- Menambahkan variabel `$configSummary` ke view untuk mengisi tabel ringkasan konfigurasi.

#### [MODIFY] [manager.php](file:///c:/laragon/www/Ksp_Koperasinat/views/dashboard/manager.php)
- **Tabel Ringkasan Data Anggota**: Menambahkan kolom dinamis untuk "Simpanan Motor" dan "Simpanan Mobil". Kolom ini hanya akan muncul jika ada anggota yang memiliki konfigurasi tersebut.
- **Tabel Ringkasan Konfigurasi**: Mengaktifkan data pada tabel "Ringkasan Konfigurasi Simpanan Anggota" agar menampilkan data real-time dari apa yang diinput oleh Validator.

### 3. Frontend (UI & Logic - Settings)

#### [MODIFY] [settings.php](file:///c:/laragon/www/Ksp_Koperasinat/views/auth/settings.php)
- **Pembersihan UI**: Menghapus `div` kosong di bagian bawah halaman (elemen yang ditandai hijau).
- **Aktivasi Fitur Ungu**:
    - Memastikan input pencarian terhubung ke endpoint `/api/anggota/search`.
    - Mengaktifkan dropdown "Suggestions List" yang melayang saat user mengetik.
    - Menangani aksi klik pada saran: menampilkan nama anggota di bawah kotak pencarian dan menyembunyikan input pencarian sementara.
    - Mengaktifkan tombol **"x" (Remove)** untuk membatalkan pilihan anggota dan kembali ke mode pencarian.
    - Otomatis mengisi form "Parameter Simpanan" dengan data yang diambil dari database saat anggota dipilih.

## Verification Plan

### Manual Verification
1. **Login sebagai Admin**.
2. Buka menu **Pengaturan** > **Konfigurasi Simpanan**.
3. Verifikasi pembersihan UI dan fungsi pencarian.
4. Simpan konfigurasi anggota.
5. **Login sebagai Manager**.
6. Verifikasi kolom baru muncul di tabel ringkasan jika data sudah diisi oleh Validator.
