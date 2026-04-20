# 📱 Dokumentasi Fitur KSP Harapan Mulya (Mobile Sync)

Dokumen ini disusun sebagai panduan bagi tim pengembang Mobile untuk menyamakan fitur dan logika bisnis antara aplikasi Web dan Mobile.

---

## 1. 👥 Peran & Akses Pengguna (RBAC)
Sistem memiliki 4 role utama dengan hak akses yang berbeda:

| Role | Deskripsi | Fitur Utama Mobile |
| :--- | :--- | :--- |
| **Anggota** | Nasabah Koperasi | Dashboard Saldo, Riwayat Transaksi, Pengajuan Pinjaman, Chat AI, Notifikasi. |
| **Teller** | Operasional Harian | Verifikasi Pinjaman, Pencairan Dana, Input Transaksi Simpanan (Setor/Tarik). |
| **Ketua** | Pengambil Keputusan | Approval Pinjaman (berdasarkan Credit Scoring), Laporan Neraca. |
| **Admin** | Pengelola Sistem | Manajemen User, Konfigurasi Sistem, Audit Trail. |

---

## 2. 🤖 Kecerdasan Buatan (AI Integration)
### Anita AI Assistant
*   **Fungsi**: Tanya jawab seputar SOP Koperasi, syarat pendaftaran, dan informasi akun.
*   **Teknologi**: Terintegrasi dengan Groq Cloud API (Llama3 model).
*   **Endpoint**: `POST /chatbot/ask`

### Automated Credit Scoring
*   **Fungsi**: Menilai kelayakan pinjaman secara otomatis (Skor 0-100).
*   **Parameter Penilaian**:
    1.  **Rasio Simpanan**: Saldo simpanan minimal 10% dari pokok pinjaman.
    2.  **Riwayat Tunggakan**: Mengecek apakah ada pinjaman aktif yang belum lunas.
    3.  **Kedisiplinan**: Frekuensi denda pada transaksi angsuran sebelumnya.

---

## 3. 💰 Modul Simpanan (Savings)
*   **Real-time Balance**: Saldo dihitung secara instan melalui database view `v_saldo_simpanan`.
*   **Setoran**: Minimal Rp 10.000.
*   **Penarikan**: Validasi saldo tidak boleh minus (Saldo Mengendap disesuaikan config).
*   **Transfer Internal**: Fitur transfer saldo antar anggota dengan validasi nomor anggota tujuan.

---

## 4. 💳 Modul Pinjaman & Angsuran (Loans)
### Alur Pengajuan (Flow)
`Dashboard Anggota (Ajukan) -> Verifikasi (Teller) -> Approval (Ketua) -> Pencairan (Teller)`

### Fitur Kunci:
*   **Amortisasi Flat**: Bunga dihitung tetap setiap bulan dari pokok awal.
*   **Jadwal Angsuran**: Otomatis terbentuk saat status berubah menjadi `DICAIRKAN`.
*   **Denda Otomatis**: Perhitungan denda per hari keterlambatan sesuai persentase pengaturan.
*   **Status Tracker**: Visualisasi progress pengajuan (Step Indicator).

---

## 5. ⚙️ Otomatisasi (Background Jobs)
### Autodebet Angsuran
*   **Logika**: Sistem secara otomatis memotong saldo simpanan anggota jika ada angsuran yang jatuh tempo hari ini.
*   **Syarat**: Saldo simpanan mencukupi untuk bayar (Angsuran + Denda).
*   **Implementasi**: Berjalan di `index.php` sebagai pseudo-cron.

### Pembagian Bunga
*   Posting bunga simpanan bulanan secara otomatis ke saldo anggota.

---

## 6. 🔔 Sistem Notifikasi (Glow Dot UX)
*   **Indikator**: Dot berdenyut (Pulse) di topbar.
*   **FIFO System**: Hanya menyimpan 5 notifikasi terbaru per user.
*   **Event Notifikasi**:
    *   Setoran/Penarikan Sukses.
    *   Update Status Pinjaman (Verifikasi, Approve, Cair).
    *   Ping Jatuh Tempo.

---

## 7. 🛠️ Daftar Endpoint Utama (Sync Reference)
Tim mobile dapat merujuk ke route berikut di aplikasi Backend:

### Auth & Profile
- `POST /login`: Autentikasi user.
- `GET /logout`: Menghapus sesi.
- `GET /profile`: Mengambil data profil user aktif.
- `POST /settings/password/update`: Ganti password.

### Transaksi
- `GET /api/anggota/{id}/saldo`: Cek saldo real-time.
- `POST /simpanan/transfer`: Eksekusi transfer saldo.
- `POST /pinjaman/store`: Pengajuan pinjaman baru.
- `POST /angsuran/proses`: Pembayaran manual angsuran.

### AI & Notif
- `POST /chatbot/ask`: Bertanya ke Anita AI.
- `POST /api/notifikasi/read`: Menandai notifikasi telah dibaca.

---

## 8. 📄 Pelaporan & Output
*   **Export PDF**: Semua transaksi angsuran wajib menghasilkan invoice/kuitansi digital.
*   **Filter Dinamis**: Laporan dapat difilter harian, bulanan, atau tahunan.

---
*Dokumentasi ini disinkronkan dengan rilis terakhir (April 2026).*
