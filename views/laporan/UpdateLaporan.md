# Log Pembenahan Project KSP Harmul - 19 April 2026

## 1. Infrastruktur & Koneksi Database
* **Import Database**: Berhasil melakukan migrasi skema database dari `ksp_koperasinat.sql` ke MySQL lokal.
* **Fix Warning PHP 8.5**: Melakukan pembaruan pada `app/config/database.php` baris 25 dengan mengganti konstanta `PDO::MYSQL_ATTR_INIT_COMMAND` menjadi `Pdo\Mysql::ATTR_INIT_COMMAND` untuk mengatasi *error deprecated* pada versi PHP terbaru.
* **Sinkronisasi Environment**: Update file `.env` pada bagian `BASE_URL` agar sesuai dengan konfigurasi folder Laragon (`http://localhost/Ksp_Koperasinat/public/`) guna mengatasi masalah *Connection Refused* saat proses *redirect login*.

## 2. Pengembangan Modul Laporan (FD 3)
Tugas utama hari ini adalah memindahkan logika laporan dari Laravel ke arsitektur MVC PHP Native milik tim.

### A. Logic (LaporanController.php)
* **Filtering Waktu**: Mengintegrasikan fungsi `buildDateFilter()` bawaan sistem untuk mendukung laporan harian, bulanan, dan tahunan.
* **Laporan Tunggakan**: Menghubungkan *function* `tunggakan()` dengan database *view* `v_tunggakan` untuk menarik data anggota yang telat bayar secara *real-time*.
* **Laporan Laba Rugi**: Membuat perhitungan pendapatan dari akumulasi `bunga_bayar` & `denda` (tabel `angsuran`) serta `potongan_admin` (tabel `pinjaman`), dikurangi beban operasional dari tabel `kas_transaksi`.
* **Laporan Neraca**: Mengimplementasikan hitungan Aktiva (Kas + Piutang) dan Pasiva agar *Balance*. Variabel baru ditambahkan: `$totalSimpanan` (dari `v_saldo_simpanan`) dan `$ekuitas` (Aset - Simpanan).

### B. Antarmuka / UI (Views)
* **Standarisasi UI**: Mengubah semua *layout* laporan dari Tailwind CSS ke Bootstrap 5 agar senada dengan modul lainnya.
* **Integrasi Filter & Cetak**: Memasang breadcrumb dan memanggil `_filter_form.php` di setiap halaman laporan (`angsuran`, `kas`, `neraca`, `laba_rugi`) sehingga fitur filter periode dan tombol **Cetak PDF** sudah menyatu secara global.
* **Fixing Neraca**: Memperbaiki tampilan kolom Pasiva yang sebelumnya masih bertuliskan `*(Data Rekap)*` menjadi angka nominal asli dari database.

## 3. Status Fitur FD 3
| Nama Laporan | Status | Sumber Data |
| :--- | :--- | :--- |
| Riwayat Angsuran | ✅ Selesai | Tabel `angsuran` |
| Arus Kas Utama | ✅ Selesai | Tabel `kas_transaksi` |
| Tunggakan | ✅ Selesai | View `v_tunggakan` |
| Laba Rugi | ✅ Selesai | Gabungan Tabel |
| Neraca Keuangan | ✅ Selesai | Akumulasi Global |
| Distribusi SHU | ✅ Selesai | Persentase Laba Bersih |

## 4. Todo Next (Pekerjaan Selanjutnya)
- [ ] Test semua filter periode (Harian, Bulanan, Tahunan) di setiap menu laporan.
- [ ] Pastikan fungsi `formatRupiah()` sudah terdefinisi di helper global agar tidak terjadi *undefined function error*.
- [ ] Sinkronisasi dengan tim lain untuk penempatan menu sidebar Laporan.

***