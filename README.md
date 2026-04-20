# KSP Harapan Mulya - Koperasi Simpan Pinjam

Sistem Informasi Manajemen Koperasi Simpan Pinjam (KSP) Harapan Mulya dengan integrasi AI Assistant (Anna).

## Fitur Utama

- **Dashboard Komprehensif**: Statistik ringkasan untuk Admin, Teller, Ketua, dan Anggota.
- **Manajemen Anggota**: Pengelolaan data anggota lengkap dengan status aktif/non-aktif.
- **Sistem Simpanan**: Setor, Tarik, dan Transfer antar anggota.
- **Sistem Pinjaman**: Pengajuan, Verifikasi, Approval, hingga Pencairan dana.
- **Angsuran Otomatis**: Pencatatan angsuran rutin dengan riwayat pembayaran yang transparan.
- **Laporan Keuangan**: Neraca, Laba Rugi, SHU, dan laporan transaksi lainnya.
- **Anna AI Assistant**: Asisten AI pintar berbasis Llama 3 (Groq API) untuk membantu menjawab pertanyaan seputar layanan koperasi.

## Arsitektur Teknologi

- **Backend**: PHP Native 8.x dengan pola arsitektur MVC (Model-View-Controller).
- **Database**: MySQL.
- **Frontend**: Bootstrap 5, Bi-icon, SweetAlert2.
- **AI Integration**: Groq Cloud API (Llama-3.3-70b).

## Cara Instalasi

1. Clone repositori ini.
2. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database serta API Key Groq.
3. Import database `ksp_koperasinat.sql` ke MySQL Anda.
4. Jalankan aplikasi di server lokal (Laragon/XAMPP).

## Akses Akun (Default)
- **Admin**: admin / password
- **Teller**: teller / password
- **Ketua**: ketua / password

---
*Dikembangkan dengan ❤️ untuk KSP Harapan Mulya.*