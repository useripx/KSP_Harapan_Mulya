# Dokumentasi Perkembangan & Fitur Projek (KSP)

Dokumen ini berisi rangkuman perkembangan terbaru dan fitur-fitur yang telah diimplementasikan dalam Sistem Informasi Koperasi Simpan Pinjam (KSP) kita.

## 🚀 Fitur Utama yang Berjalan

### 1. Sistem Autentikasi & Otorisasi Bertingkat
- **Role-Based Access Control (RBAC)**: Pembatasan akses pengguna yang ketat berdasarkan peran khusus, yaitu:
  - **Anggota**: Hanya bisa melihat data simpanan dan pinjaman milik sendiri, serta mengajukan pinjaman baru.
  - **Teller / Admin**: Bertugas melakukan verifikasi awal pengajuan pinjaman, memproses transaksi kas (Setor/Tarik simpanan), serta melakukan pencairan pinjaman yang sudah disetujui.
  - **Ketua**: Memiliki otoritas tertinggi untuk memberikan `Approval` (Persetujuan / Penolakan) atas pengajuan pinjaman anggota berdasarkan hasil verifikasi dari Teller.
- **Proteksi Halaman**: Session dan keamanan routing memastikan setiap halaman hanya dapat diakses oleh mereka yang berhak.

### 2. Modul Simpanan Cerdas
- **Transaksi Komprehensif**: Mendukung operasi **Setor**, **Tarik**, dan **Transfer** saldo antar anggota.
- **Kalkulasi Saldo Real-time**: Menggunakan View khusus di database (`v_saldo_simpanan`) yang mengkalkulasi saldo murni berdasarkan seluruh history transaksi uang masuk dan keluar.
- **Validasi Ketat**: Sistem secara otomatis akan menolak penarikan/transfer yang melebihi batas saldo aktif (mencegah saldo minus).

### 3. Modul Pinjaman & Angsuran
- **Alur Pinjaman Sistematis**: 
  *Diajukan oleh Anggota ➔ Diverifikasi oleh Teller ➔ Disetujui/Ditolak oleh Ketua ➔ Dicairkan oleh Teller.*
- **Generate Jadwal Otomatis**: Saat pencairan (`cairkan`), sistem akan secara otomatis membuat tabel/jadwal amortisasi angsuran bulanan berdasarkan pokok pinjaman, tenor, dan bunga flat.
- **Pelacakan Penanggung Jawab**: Sistem mencatat secara akurat siapa user yang mem-verifikasi, menyetujui, dan mencairkan setiap pinjaman dengan relasi kolom yang valid di database (`verifikasi_oleh`, `approve_oleh`, `cair_oleh`).

### 4. Fitur Spesial: Autodebet Angsuran Jatuh Tempo
- Sistem memiliki **Cron Job Background Service** (`cron_autodebet_angsuran.php`) yang dirancang untuk dieksekusi setiap hari.
- **Logika Cerdas**: Algoritma memeriksa semua angsuran anggota yang statusnya masih `BELUM` dibayar dan tanggal batas pembayarannya (`jatuh_tempo`) sama dengan hari ini atau sudah lewat.
- **Auto-Potong Saldo**: Bila saldo Simpanan anggota memadai untuk melunasi tagihan bulanan tersebut, skrip akan melakukan pemotongan otomatis (Tarik simpanan) dan mengubah status angsuran menjadi **BAYAR** (Lunas). Semua tercatat ke kas KSP tanpa intervensi manual dari Teller.

### 6. Sistem Notifikasi "Facebook Style" (Glow Dot)
- **Visual Modern**: Notifikasi tidak lagi tampil dengan angka yang ramai. Menggunakan **Indikator Cahaya (Dot)** yang berdenyut (Pulse) merah jika ada pesan baru, dan hijau tenang jika sudah dibaca.
- **Efisiensi Database (FIFO)**: Sistem secara otomatis hanya menyimpan **5 notifikasi terbaru** per anggota. Pesan ke-6 yang masuk akan menghapus pesan tertua secara otomatis.
- **Notifikasi Otomatis**: Terintegrasi pada alur Simpanan (Setor & Tarik), serta seluruh siklus Pinjaman (Pengajuan, Verifikasi, Approval, & Penolakan).
- **Mark-As-Read Instan**: Menggunakan AJAX untuk mengubah status baca dan warna indikator cahaya secara *real-time* tanpa perlu memuat ulang halaman.

### 7. Dashboard Anggota & Mobile Banking Style
- **Antarmuka Premium**: Dashboard anggota kini memiliki tampilan kartu visual yang menirukan aplikasi *Mobile Banking*.
- **Informasi Komprehensif**: Menampilkan Total Saldo, Akumulasi Setoran, Akumulasi Penarikan, Sisa Pinjaman, dan Tagihan Angsuran bulan ini dalam satu layar yang rapi.
- **Mobile Responsive**: Perbaikan total pada *Sidebar Toggle* dan layout navigasi agar aplikasi berjalan mulus pada perangkat smartphone dan tablet.

---

## 🔧 Pembaruan Teknis Terkini (V12 - April 2026)
- **Perbaikan UI Dashboard**: Menghapus redundansi layout (*Double Header*) pada dashboard anggota agar tampilan tetap presisi.
- **Sinkronisasi Notifikasi**: Memperbaiki koordinat database tabel `notifikasi` dan menyempurnakan variabel panggilan (`judul` & `tipe`) pada Topbar.
- **Aturan Bisnis (Minimal Setor)**: Menyesuaikan kebijakan minimal setoran simpanan menjadi **Rp 10.000** guna mempermudah akses menabung bagi anggota koperasi.
- **Pembersihan Root Folder**: Menghapus ratusan file sampah log dan script pengujian untuk memastikan folder projek bersih dan siap digunakan di lingkungan produksi (*clean-folder policy*).

---

**Status Proyek**: Stabil & Production-Ready - Siap untuk presentasi dan penggunaan operasional.  
**Fokus Selanjutnya (Draft)**: Implementasi Whatsapp Gateway untuk notifikasi otomatis transaksi.
