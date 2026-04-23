# Dokumentasi Update v18 - Koperasi Harapan Mulya

Dokumen ini mencatat seluruh perubahan dan penambahan fitur yang dilakukan pada rilis update v18.

## 0. Perubahan Nama Sistem Global
**File yang diubah:**
- `app/config/app.php`
- `views/layout/main.php`
- `views/layout/sidebar.php`
- `views/layout/footer.php`
- `views/auth/login.php`
- `database/seed.sql`
- `README.md`
- Berbagai file cetak/laporan (`views/laporan/laba_rugi.php`, `neraca.php`, `shu.php`, dll) serta kuitansi angsuran (`views/angsuran/detail.php`).

**Detail Perubahan:**
- Melakukan perubahan nama institusi/sistem secara global dari yang sebelumnya **"KSP Harapan Mulya"** menjadi **"Koperasi Harapan Mulya"**. Perubahan ini mencakup penyesuaian di tingkat konfigurasi aplikasi, struktur *layout* (Header, Footer, Sidebar), halaman *Login*, serta ke seluruh *template* cetak dokumen laporan dan kuitansi transaksi.


## 1. Perbaikan Tampilan Sidebar & Scrollbar
**File yang diubah:**
- `views/layout/main.php`

**Detail Perubahan:**
- Memperbaiki teks "Koperasi Harapan Mulya" pada header sidebar yang sebelumnya terpotong (mepet) dengan mengubah ukuran font dan mengizinkan teks untuk turun baris (`white-space: normal`).
- Menghilangkan *scrollbar* horizontal dan vertikal yang mengganggu pada area sidebar menggunakan properti CSS (menyembunyikan track dan thumb scrollbar untuk Chrome, Safari, Edge, dan Firefox) namun tetap mempertahankan fungsi *scroll* menggunakan *mouse/touchpad*.

## 2. Pembatasan Hak Akses Hapus User (Validator)
**File yang diubah:**
- `views/user/index.php`

**Detail Perubahan:**
- Menghapus tombol opsi **"Hapus"** pada menu *dropdown* aksi di tabel Manajemen User.
- Validator (Admin) kini hanya memiliki akses untuk melakukan **"Edit"** data user, untuk mencegah penghapusan akun sistem secara tidak sengaja.

## 3. Penyesuaian Kategori Tipe Anggota
**File yang diubah:**
- `views/anggota/create.php`
- `views/anggota/edit.php`

**Detail Perubahan:**
- Memperbarui opsi *dropdown* "Tipe Anggota" saat mendaftarkan anggota baru dan saat mengedit anggota.
- Opsi lama (Umum, Mahasiswa, Dosen, Staf) dihapus dan diganti secara spesifik menjadi:
  - DOSEN TETAP
  - DOSEN KONTRAK
  - DOSEN TIDAK TETAP
  - KARYAWAN TETAP
  - KARYAWAN KONTRAK
  - KARYAWAN TIDAK TETAP

## 4. Fitur Reset Sandi Cepat (oleh Validator)
**File yang diubah:**
- `views/user/edit.php`
- `app/controllers/UserController.php`
- `public/index.php`

**Detail Perubahan:**
- **UI Edit User (`views/user/edit.php`)**: Menghapus form input "Password Baru" dan menggantinya dengan tombol khusus **"Reset Sandi"**.
- **Pop Up Alur Kerja (`views/user/edit.php`)**: Menambahkan Pop Up konfirmasi (Ya/Tidak) sebelum melakukan reset, dan Pop Up sukses dengan tombol "Oke" yang secara otomatis mengarahkan admin kembali ke *Dashboard*.
- **Logika Backend (`app/controllers/UserController.php`)**: Menambahkan fungsi `resetPassword($id)` yang secara otomatis mereset sandi akun tersebut agar sama persis dengan *Username* / ID Anggota-nya.
- **Routing (`public/index.php`)**: Mendaftarkan rute sistem baru (`/users/{id}/reset-password`) untuk memproses aksi ini.

## 5. Sistem Peringatan Keamanan Otomatis (Ganti Sandi)
**File yang diubah:**
- `app/controllers/AuthController.php`
- `views/layout/main.php`

**Detail Perubahan:**
- **Deteksi Login (`AuthController.php`)**: Menambahkan logika pengecekan saat proses *login*. Jika *password* yang dimasukkan sama persis dengan *username* (mengindikasikan masih menggunakan sandi *default*), sistem akan mencatat sesi peringatan (`must_change_password`).
- **Hapus Sesi (`AuthController.php`)**: Sesi peringatan ini otomatis dihapus dan dimatikan secara permanen ketika user telah berhasil memperbarui sandinya di menu Pengaturan.
- **Pop Up Peringatan (`views/layout/main.php`)**: Menampilkan *modal pop up* berisi "Peringatan Keamanan" di layar saat user berhasil masuk. Pop up ini mengarahkan user untuk langsung mengganti sandi.
- **Kenyamanan User (`views/layout/main.php`)**: Pop up ini diatur agar hanya muncul **satu kali per sesi login** agar tidak mengganggu operasional sistem. User juga dapat menutupnya atau mengklik tombol "Nanti Saja".
