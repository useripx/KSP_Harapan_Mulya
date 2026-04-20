# 🚀 Daftar Fitur Lengkap KSP Harapan Mulya
## Sistem Informasi Koperasi Simpan Pinjam Modern

Dokumen ini merinci seluruh fitur fungsional dan teknis yang telah diimplementasikan dalam sistem KSP Harapan Mulya.

---

### 1. 🤖 Kecerdasan Buatan (AI Integration)
*   **Anita AI Assistant**: Asisten virtual melayani tanya jawab anggota (Syarat pendaftaran, lupa password, prosedur pinjaman, dll).
*   **Automated Credit Scoring**: Algoritma cerdas yang menghitung skor kelayakan anggota (0-100) saat mengajukan pinjaman berdasarkan:
    *   Rasio saldo simpanan terhadap pokok pinjaman.
    *   Riwayat tunggakan aktif.
    *   Frekuensi keterlambatan pembayaran denda sebelumnya.

### 2. 👥 Manajemen Anggota & Keamanan
*   **Registrasi Multi-Tipe**: Pendaftaran untuk Mahasiswa, Dosen, Staf, dan Umum.
*   **Auto-Generate No. Anggota**: Kodifikasi otomatis sesuai urutan pendaftaran.
*   **Role-Based Access Control (RBAC)**: Pembatasan akses super ketat untuk Admin, Teller, Ketua, dan Anggota.
*   **Audit Trail System**: Pencatatan setiap aktivitas sensitif (Login, Update Data, Approval) ke dalam tabel log.

### 3. 💰 Modul Simpanan (Tabungan)
*   **Setoran Digital**: Pencatatan setoran tunai dengan validasi minimal Rp 10.000.
*   **Penarikan Saldo**: Pengambilan simpanan dengan cek saldo real-time.
*   **Internal Transfer**: Fitur transfer saldo antar anggota koperasi dengan biaya admin yang dapat dikonfigurasi.
*   **Real-time Balance**: Saldo diperbarui secara instan melalui Database View (`v_saldo_simpanan`).

### 4. 💳 Modul Pinjaman & Angsuran
*   **Digital Application**: Pengajuan pinjaman mandiri oleh anggota melalui dashboard.
*   **Tiered Approval Workflow**: Proses verifikasi oleh Staf/Teller sebelum diteruskan ke Ketua untuk persetujuan akhir.
*   **Loan Disbursement**: Pencairan dana otomatis yang langsung menghasilkan **Jadwal Angsuran** (Amortisasi Flat).
*   **Payment Gateway**: Pembayaran angsuran bulanan yang terhubung dengan Buku Kas.
*   **Denda Otomatis**: Perhitungan denda keterlambatan secara sistematis sesuai persentase pengaturan.

### 5. ⚙️ Otomatisasi & Background Jobs (Cron)
*   **Autodebet Angsuran**: Sistem secara otomatis memotong saldo simpanan anggota untuk membayar cicilan yang jatuh tempo.
*   **Monthly Interest Posting**: Pembagian bunga simpanan kepada seluruh anggota setiap awal bulan.
*   **Due Date Reminder**: Notifikasi otomatis untuk anggota yang mendekati jatuh tempo pembayaran.

### 6. 📊 Dashboard & Visualisasi Data
*   **Admin/Teller Dashboard**: Statistik total anggota, simpanan, pinjaman aktif, dan grafik tren transaksi 7 hari terakhir.
*   **Member Mobile Dashboard**: Tampilan bergaya Mobile Banking (Card Style) yang 100% responsif di smartphone.
*   **Loan Progress Tracker**: Visualisasi status pengajuan pinjaman menggunakan *Step Indicator*.

### 7. 📄 Pelaporan & Output
*   **Export Kuitansi PDF**: Pembuatan invoice digital profesional untuk setiap transaksi angsuran.
*   **Laporan Jurnal Umum**: Pencatatan kas masuk dan keluar secara kronologis di `kas_transaksi`.
*   **Laporan Neraca & Simpanan**: Rekapitulasi keuangan untuk kebutuhan rapat pengurus.

### 8. ✨ Fitur UI/UX Premium
*   **Glow Dot Notifications**: Indikator cahaya berdenyut (Red Pulse) untuk pesan baru dan hijau tenang untuk status bersih.
*   **AJAX Interface**: Pembaruan status notifikasi dan beberapa data tanpa perlu memuat ulang halaman (Reload).
*   **FIFO Audit Log**: Sistem pembersihan otomatis notifikasi lama (Hanya menyimpan 5 notifikasi terbaru) untuk menjaga performa database.
