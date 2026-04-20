# Alur Kerja Harian: Frontend Dev 1 (Maret 2026)
**Peran:** Admin Dashboard & Teller Interface (Web Desktop)
**Proyek:** KSP Koperasinat / Harapan Mulya
**Target:** 0 s/d 100% (Production Ready)

## 📋 Ringkasan Peran
Bertanggung jawab penuh atas antarmuka internal koperasi yang digunakan oleh **Admin** dan **Teller**. Fokus utama pada kecepatan input data, manajemen finansial yang akurat, dan laporan yang siap cetak.

---

## 🗓️ Jadwal Harian: Maret 2026

| Minggu | Tanggal | Aktivitas Harian | Detail Pekerjaan |
| :--- | :--- | :--- | :--- |
| **W1** | 01 Mar | Persiapan & Analisis | Mempelajari AD/ART, aturan bunga (1.5%), dan denda (5%). |
| | 02 Mar | Project Initialization | Setup Framework (Bootstrap 5), Datatables, & struktur folder `views/admin`. |
| | 03 Mar | Main Layout | Membangun Sidebar responsif, Profile Bar, & sistem navigasi utama. |
| | 04 Mar | Auth UI | Membuat halaman Login dan halaman proteksi "Access Denied" (RBAC). |
| | 05 Mar | Master Data Anggota | Membuat UI Daftar Anggota menggunakan Datatables (Fitur Search & Filter). |
| | 06 Mar | Form Input Anggota | Membuat Form "Tambah Anggota" lengkap dengan validasi frontend. |
| | 07 Mar | Profile View | Membuat detail profil anggota & history transaksi dari sisi Admin. |
| **W2** | 08 Mar | Review Transaksi | Analisis alur Setor/Tarik Tunai bersama Backend Developer. |
| | 09 Mar | Teller Dashboard | UI Ringkasan Kas Teller dan fitur pencarian ID Anggota cepat. |
| | 10 Mar | Form Setor Tunai | Optimasi navigasi Keyboard (Enter key support) untuk transaksi cepat. |
| | 11 Mar | Form Tarik Tunai | Implementasi validasi saldo real-time pada interface Teller. |
| | 12 Mar | Teller Daily Logs | Membuat tabel riwayat transaksi harian khusus untuk petugas Teller. |
| | 13 Mar | API Integration | Menghubungkan Form Teller dengan API Simpanan (Backend Integration). |
| | 14 Mar | Stress Testing | Uji coba input massal untuk memastikan responsivitas UI. |
| **W3** | 15 Mar | Analisis Kredit | Review rumus Amortisasi Cicilan (Pokok + Bunga) untuk UI. |
| | 16 Mar | Loan Dashboard | Membangun antarmuka daftar antrean "Pengajuan Pinjaman". |
| | 17 Mar | Verification UI | Membuat modal verifikasi dokumen & skor kelayakan anggota. |
| | 18 Mar | Approval Workflow | Membangun tombol otoritas (Approve/Reject) untuk Ketua Koperasi. |
| | 19 Mar | Installment Form | Membangun Form "Bayar Angsuran" dan sistem input denda. |
| | 20 Mar | Amortization Table | Membuat visualisasi Jadwal Cicilan Bulanan yang dinamis. |
| | 21 Mar | Status Sync | Sinkronisasi status pinjaman (Pending -> Cair -> Lunas) ke Dashboard. |
| **W4** | 22 Mar | Riset Reporting | Studi layout Kwitansi & Laporan Keuangan resmi koperasi. |
| | 23 Mar | Reporting UI | Membuat halaman Rekap Transaksi Harian/Bulanan (Data-dense). |
| | 24 Mar | Filter System | Implementasi pemilih tanggal (Datepicker) interaktif untuk filter. |
| | 25 Mar | CSS Print Styling | Optimalisasi `@media print` untuk cetak Kwitansi & Laporan (Kop Surat). |
| | 26 Mar | Premium UI FX | Implementasi **Glow Dot Notifikasi** (Animasi CSS Pulse). |
| | 27 Mar | UI Polishing | Merapikan CSS, margin, dan perbaikan tampilan di Mobile/Tablet. |
| | 28 Mar | QA & Bug Fixing | Mencari & memperbaiki bug tampilan pada Datatables. |
| | 29 Mar | UX Enhancement | Penambahan animasi transisi halaman agar terasa lebih premium. |
| | 30 Mar | Documentation | Menulis User Manual (Panduan Pengguna) untuk Admin & Teller. |
| | 31 Mar | Handover & Deploy | Serah terima kodingan & persiapan peluncuran operasional. |

---

## 💡 Prinsip Pengembangan
1. **Efficiency First:** Admin & Teller bekerja setiap hari, UI harus cepat dan mudah dinavigasi.
2. **Zero Error UI:** Validasi input harus ketat di sisi Client sebelum dikirim ke Server.
3. **Professional Aesthetics:** Menggunakan palet warna yang bersih, tipografi yang jelas (Outfit/Inter), dan elemen UI yang modern.

---
*Dokumen ini dibuat otomatis berdasarkan instruksi pengembangan sistem KSP Koperasinat.*
