<<<<<<< HEAD

<p>
    <strong>Aplikasi Manajemen Koperasi Modern dengan Integrasi AI, Analitik Lanjutan, dan Keamanan Tingkat Tinggi.</strong>
  </p>

<!-- Badges -->

<p>
    <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap&logoColor=white" alt="Bootstrap">
    <img src="https://img.shields.io/badge/Architecture-MVC-2b5a9b?style=flat-square" alt="MVC">
    <img src="https://img.shields.io/badge/Version-v23.0-success?style=flat-square" alt="Version">
  </p>
</div>

---

## 🚀 Tentang Proyek

Sistem Koperasi Harapan Mulya adalah platform digital berbasis web yang dirancang khusus untuk mengelola seluruh ekosistem koperasi simpan pinjam secara transparan, otomatis, dan aman. Aplikasi ini menggunakan pola **MVC (Model-View-Controller)** murni tanpa framework besar, memastikan performa yang sangat cepat dan kode yang mudah dirawat.

## ✨ Fitur Unggulan

### 💰 Modul Simpan Pinjam Dinamis

- **Suku Bunga Fleksibel**: Pengaturan bunga (Jangka Pendek & Jangka Panjang) yang dikendalikan langsung secara dinamis melalui Dashboard Manager.
- **Konfigurasi Simpanan Individu**: Kemampuan menetapkan aturan saldo wajib (Motor/Mobil) per anggota menggunakan fitur *Autocomplete Search* yang pintar.
- **Top-Up & Autodebet**: Integrasi potong saldo otomatis dan pengajuan penambahan plafon pinjaman.
- **Kalkulator & Simulasi**: Simulasi angsuran dan bunga secara *real-time* sebelum pengajuan.

### 🛡️ Keamanan & Aksesibilitas

- **Sistem Role-Based Access (RBAC)**: Pemisahan tegas hak akses antara Anggota, Validator (Admin), BAU (Keuangan), dan Manager (Ketua).
- **Mandatory Password Reset**: Deteksi kata sandi *default* yang memaksa pengguna segera mengganti keamanan akunnya.
- **Pengingat Keamanan Bulanan**: Pop-up otomatis setiap tanggal 1 yang mengingatkan pengguna untuk mengganti kata sandi.

### 💻 UI/UX Modern

- **Mode Terang/Gelap (Dark Mode)**: Mendukung tema gelap secara universal (Bootstrap 5.x).
- **Notifikasi *Real-Time***: Sistem pemberitahuan bergaya Facebook dengan lampu indikator dinamis (*Glow Dot*).
- **Responsive & Interactive**: Dipercantik dengan **SweetAlert2** untuk *pop-up* dan navigasi yang sangat ramah seluler (*mobile-friendly*).

---

## 🛠️ Arsitektur & Teknologi

| Komponen                      | Teknologi yang Digunakan           |
| :---------------------------- | :--------------------------------- |
| **Bahasa Pemrograman**  | PHP Native 8.x (OOP)               |
| **Arsitektur**          | Model-View-Controller (MVC) Custom |
| **Database**            | MySQL / MariaDB                    |
| **Frontend Framework**  | Bootstrap 5.3.8                    |
| **Iconography**         | Bootstrap Icons (Bi-icons)         |
| **Modul Interaktif**    | Vanilla JavaScript, SweetAlert2    |
| **Integrasi Eksternal** | Groq API (Untuk Modul AI)          |

---

## 📦 Cara Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di lingkungan pengembangan lokal (Localhost):

1. **Clone Repositori**

   ```bash
   git clone https://github.com/Username/Ksp_Koperasinat.git
   cd Ksp_Koperasinat
   ```
2. **Konfigurasi Lingkungan (Environment)**
   Salin file konfigurasi bawaan dan sesuaikan dengan *database* lokal Anda.

   ```bash
   cp .env.example .env
   ```

   > ⚠️ Pastikan Anda mengatur `DB_NAME`, `DB_USER`, `DB_PASS`, serta memasukkan API Key untuk Groq API (`GROQ_API_KEY`) di dalam file `.env`.
   >
3. **Impor Database**

   - Buat database baru di MySQL dengan nama `ksp_koperasinat`.
   - Impor struktur dan data awal dari file `ksp_koperasinat.sql` yang tersedia.
4. **Jalankan Aplikasi**

   - Jika Anda menggunakan Laragon atau XAMPP, pastikan *Virtual Host* atau folder proyek mengarah dengan benar.
   - Akses aplikasi di browser Anda: `http://localhost/Ksp_Koperasinat/public`

---

## 🔑 Akses Akun Pengujian (Default)

Gunakan kredensial berikut untuk menguji *Role* yang berbeda dalam sistem:

| Peran (Role)              | Username                 | Password            | Deskripsi                                                                         |
| :------------------------ | :----------------------- | :------------------ | :-------------------------------------------------------------------------------- |
| **Validator**       | `admin`                | `password123`     | Konfigurasi sistem dasar, pendaftaran anggota, & pengaturan simpanan individu.    |
| **Manager / Ketua** | `ketua`                | `passwor123`      | Pengaturan suku bunga dinamis,*approval* akhir pinjaman, dan tinjauan analitik. |
| **BAU (Keuangan)**  | `bau`                  | `bau`             | Manajemen pencairan dana dan penerimaan angsuran.                                 |
| **Anggota**         | `(Gunakan ID Anggota)` | `(Sandi Default)` | Dashboard personal, pengajuan, mutasi, dan simulasi pinjaman.                     |

---

## 📋 Changelog (Riwayat Pembaruan)

Aplikasi ini terus berkembang pesat. Untuk melihat daftar lengkap pembaruan sistem mulai dari versi awal hingga **v23**, silakan baca [CHANGELOG.md](changelog.md).

---

<div align="center">
  <br>
  <i>Dikembangkan dengan ❤️ untuk digitalisasi dan efisiensi Koperasi Harapan Mulya.</i>
</div><div align="center">
  <img src="https://img.shields.io/badge/Koperasi-Harapan%20Mulya-2b5a9b?style=for-the-badge&logo=home-assistant" alt="Koperasi Logo">
  <h1>Sistem Informasi Manajemen Koperasi Simpan Pinjam</h1>
=======
# KSP_Harapan_Mulya
>>>>>>> 21ff0606c6eb7723c4832ba3896d9e8fb61e5dd9
