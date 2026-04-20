# 📂 Dokumentasi Struktur Folder & Fungsi File
## KSP Harapan Mulya (Sistem Informasi Koperasi Simpan Pinjam)

Dokumentasi ini menjelaskan fungsi dari setiap folder dan file utama dalam ekosistem aplikasi KSP Harapan Mulya untuk memudahkan pemeliharaan dan pengembangan lebih lanjut.

---

### 1. `app/`
Folder inti aplikasi yang berisi seluruh logika backend (Server-side). Mengikuti pola arsitektur MVC (Model-View-Controller).

### 2. `app/config/`
Berisi file konfigurasi global aplikasi.
- **`app.php`**: Pengaturan umum seperti Nama Aplikasi, Base URL, dan Timezone.
- **`database.php`**: Konfigurasi koneksi ke MySQL/MariaDB (Host, User, Pass, DB Name).
- **`constants.php`**: Definisi konstanta global (misal: Batas minimal setor, Role user).

### 3. `app/controllers/`
Menangani logika alur permintaan (request) dan mengirimkan data ke View.
- **`AuthController.php`**: Menangani Login, Logout, dan Session.
- **`PinjamanController.php`**: Alur pengajuan, verifikasi, hingga persetujuan pinjaman.
- **`SimpananController.php`**: Logika setor, tarik, dan transfer saldo.
- **`LaporanController.php`**: Mengolah data untuk ditampilkan dalam format laporan.
- **`ChatbotController.php`**: Mengelola respon asisten AI (chatbot) untuk bantuan anggota secara otomatis.


### 4. `app/core/`
Mesin utama (Engine) dari custom MVC framework ini.
- **`Router.php`**: Sistem routing yang mencocokkan URL dengan Controller.
- **`Controller.php`**: Base class untuk semua controller (load model & view).
- **`Model.php`**: Base class untuk interaksi database (CRUD dasar).
- **`View.php`**: Engine untuk memanggil file template UI.

### 5. `app/helpers/`
Fungsi-fungsi bantuan yang digunakan di seluruh aplikasi.
- **`format.php`**: Formatter Rupiah, tanggal Indonesia, dan nomor anggota.
- **`security.php`**: Sanitasi input (XSS protection) dan enkripsi password.
- **`validator.php`**: Validasi input form (required, email, numeric).

### 6. `app/jobs/`
Script yang dijalankan secara otomatis di latar belakang (Background Jobs/Cron).
- **`cron_autodebet_angsuran.php`**: Memotong saldo simpanan secara otomatis untuk bayar cicilan.
- **`posting_bunga_bulanan.php`**: Menghitung dan menambah bunga ke saldo anggota tiap bulan.

### 7. `app/logs/`
Penyimpanan file log internal aplikasi untuk keperluan debugging selama pengembangan.

### 8. `app/middleware/`
Lapisan keamanan sebelum request mencapai Controller.
- **`AuthMiddleware.php`**: Memastikan user sudah login.
- **`RoleMiddleware.php`**: Membatasi akses (Misal: Hanya Ketua yang bisa buka laporan keuangan).

### 9. `app/models/`
Representasi setiap tabel di database dalam bentuk program.
- **`Anggota.php`**, **`Pinjaman.php`**, **`User.php`**: Berisi query khusus untuk tabel masing-masing.

### 10. `app/services/`
Logika bisnis tingkat tinggi yang tidak cocok di controller agar controller tetap "ramping".
- **`KasService.php`**: Mengotomatisasi pencatatan kas masuk/keluar saat ada transaksi.
- **`CreditScoreService.php`**: Algoritma cerdas penentu kelayakan pinjaman anggota.
- **`GroqService.php`**: Layanan integrasi dengan **AI (Groq/Gemini)** untuk memproses pertanyaan bantuan anggota.


### 11. `database/`
Seluruh aset yang berkaitan dengan struktur data.
- **`schema.sql`**: Struktur tabel database lengkap.
- **`seed.sql`**: Data awal (dummy) untuk testing aplikasi.

### 12. `progress/`
Catatan perkembangan proyek, daftar fitur yang sudah selesai (TODO list), dan bahan presentasi.

### 13. `public/`
Folder satu-satunya yang dapat diakses secara publik oleh browser. Berisi `index.php` sebagai entry point.

### 14 - 17. `public/assets/ (css, img, js)`
Aset statis untuk mempercantik UI.
- **`css/`**: Style utama (clean modern slate).
- **`js/`**: Logika interaktif seperti **AJAX Notifikasi**, **Chart.js** untuk grafik, dan modul **Chatbot AI (`chatbot.js`)**.


### 18 - 20. `public/uploads/ (bukti, pinjaman)`
Tempat penyimpanan file yang diunggah user.
- **`bukti/`**: Gambar kuitansi atau bukti transfer manual.
- **`pinjaman/`**: Dokumen pendukung pengajuan pinjaman (PDF/Gambar).

### 21 - 26. `storage/ (exports, logs)`
Penyimpanan data dinamis hasil generate sistem.
- **`exports/pdf/`**: Hasil cetak kuitansi dan laporan dalam bentuk PDF.
- **`storage/logs/app.log`**: Catatan error/runtime aplikasi di server produksi.

### 27. `views/`
Kumpulan file tampilan (.php) yang berisi campuran HTML dan sedikit logika PHP untuk output.

### 28 - 33. `views/ (anggota, angsuran, auth, dashboard, kas, laporan)`
Template UI yang dikelompokkan per modul fitur. 

### 34. `views/layout/`
Struktur dasar halaman (Master Template).
- **`sidebar.php`**: Menu navigasi samping.
- **`header.php`**: Bagian atas (Profile & Notifications).
- **`footer.php`**: Bagian bawah halaman (Copyright & Scripts).
- **`chatbot.php`**: UI Widget Chatbot (Floating button & Chat window) yang terintegrasi di seluruh halaman.


### 35. `views/partials/`
Komponen UI kecil yang sering digunakan berulang.
- **`alerts.php`**: Notifikasi sukses/error.
- **`modals.php`**: Popup konfirmasi hapus atau edit data.

### 36 - 39. `views/ (pinjaman, profile, simpanan, user)`
Tampilan untuk fitur spesifik user profil, transaksi simpanan, dan manajemen akun user.
