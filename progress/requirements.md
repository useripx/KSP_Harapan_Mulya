# 🛠️ Panduan Instalasi & Persyaratan Sistem

Dokumen ini berisi informasi teknis mengenai apa saja yang dibutuhkan untuk menjalankan sistem KSP Harapan Mulya serta langkah-langkah instalasinya.

---

## 1. 📋 Persyaratan Sistem (System Requirements)

Untuk menjalankan proyek ini secara optimal, pastikan lingkungan pengembangan Anda memenuhi kriteria berikut:

### Software Utama:
*   **Web Server**: Apache atau Nginx (Direkomendasikan menggunakan **Laragon** atau **XAMPP**).
*   **PHP Version**: Minimal **PHP 7.4** ke atas (Direkomendasikan **PHP 8.1** atau **8.2**).
*   **Database**: **MySQL** atau **MariaDB**.
*   **OS**: Windows, Linux, atau macOS.

### Ekstensi PHP yang Diperlukan:
*   `pdo_mysql` (Untuk koneksi database)
*   `json` (Komunikasi data AI)
*   `mbstring` (Manipulasi string)
*   `fileinfo` (Validasi upload file)
*   `session` (Sistem Login/RBAC)

### Akses API Eksternal:
*   **Groq API Key**: Diperlukan agar fitur **Anita AI Assistant** dapat berfungsi. Dapatkan secara gratis di [Groq Console](https://console.groq.com/).

---

## 2. 🚀 Langkah-Langkah Instalasi

Ikuti urutan langkah berikut untuk memasang sistem di komputer lokal Anda:

### Langkah 1: Persiapan Database
1.  Buka aplikasi manajemen database Anda (phpMyAdmin / HeidiSQL / DBeaver).
2.  Buat database baru dengan nama `ksp_koperasinat`.
3.  Impor file skema database dari direktori proyek:
    *   `database/schema.sql` (Struktur tabel)
    *   `database/seed.sql` (Data awal/dummy)

### Langkah 2: Konfigurasi Environment
1.  Buka file `.env` yang berada di root direktori.
2.  Sesuaikan pengaturan database sesuai kredensial lokal Anda:
    ```env
    DB_HOST=127.0.0.1
    DB_NAME=ksp_koperasinat
    DB_USER=root
    DB_PASS=
    ```
3.  Masukkan Groq API Key Anda pada baris `GROQ_API_KEY`.
4.  Sesuaikan `BASE_URL` sesuai dengan alamat virtual host atau folder lokal Anda.

### Langkah 3: Konfigurasi Virtual Host (Sangat Direkomendasikan)
Agar sistem berjalan sempurna, arahkan root folder web server Anda ke folder `public/`.
*   **Domain**: `http://ksp.test` (Contoh)
*   **Document Root**: `C:/laragon/www/Ksp_Koperasinat/public`

---

## 3. 🔑 Kredensial Login Default

Setelah instalasi selesai, gunakan akun berikut untuk mencoba sistem:

| Role | Username | Password |
| :--- | :--- | :--- |
| **Admin** | `admin` | `admin123` |
| **Teller** | `teller_01` | `password123` |
| **Ketua** | `ketua` | `password123` |
| **Anggota** | `2026/001` | `password123` |

---

## 4. 💡 Catatan Penting
*   **Autodebet**: Fitur autodebet hanya akan berjalan jika ada traffic masuk ke aplikasi (Pseudo-cron).
*   **Notifikasi**: Gunakan browser modern (Chrome/Edge/Firefox) untuk pengalaman UI terbaik dan animasi *Glow Dot*.
*   **Storage**: Pastikan folder `storage/` dan `public/uploads/` memiliki izin akses tulis (writable).

---
*Dokumentasi disusun untuk kebutuhan rilis versi 1.0.0.*
