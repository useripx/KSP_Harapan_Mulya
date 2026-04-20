# Direktori Kontroler (Controllers)

Direktori ini berisi class controller yang mengelola alur logika aplikasi. Setiap method dalam controller biasanya melambangkan satu aksi atau halaman tertentu.

## Daftar Kontroler Utama

- `AuthController.php`: Menangani Login, Logout, Registrasi, serta fitur **Ganti Sandi** dan halaman **Pengaturan**. Mengimplementasikan logika **Role-Based Redirection** setelah login sukses.
- `DashboardController.php`: Menangani statistik dan visualisasi data. Memiliki method khusus untuk tiap peran: `adminDashboard`, `tellerDashboard`, `ketuaDashboard`, dan `anggotaDashboard`.
- `AnggotaController.php`: CRUD data anggota (Lengkap dengan antarmuka Detail & Edit) dan integrasi akun user.
- `UserController.php`: Manajemen user sistem (Peran Admin), mencakup fitur **Status Toggle** dan proteksi tindakan mandiri (self-action).
- `SimpananController.php`: Transaksi setoran, penarikan, dan transfer simpanan dengan validasi saldo dan integrasi Buku Kas.
- `PinjamanController.php`: Alur kerja pengajuan, verifikasi, persetujuan, hingga pencairan pinjaman.
- `AngsuranController.php`: Manajemen jadwal bayar dan pemrosesan angsuran. Dilengkapi fitur **Ekspor PDF** dan cetak kuitansi profesional.
- `KasController.php`: Pencatatan arus kas masuk/keluar sistem.
- `LaporanController.php`: Pembuatan laporan keuangan, neraca, dan riwayat aktivitas.
