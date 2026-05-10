# Dokumentasi Perbaikan Dashboard Manager - Update v21a

Dokumen ini menjelaskan logika di balik fitur filter tahun dan kalkulasi saldo simpanan pada Dashboard Manager yang baru saja diperbarui.

## 1. Fitur Utama
- **Filter Tahun**: Memungkinkan Manager untuk melihat status koperasi pada tahun tertentu (historis).
- **Saldo Akhir Tahunan**: Menampilkan akumulasi simpanan anggota hingga akhir tahun yang dipilih.
- **Daftar Anggota Dinamis**: Menampilkan hanya anggota yang sudah bergabung pada tahun tersebut.

## 2. Logika Pemilihan Anggota (Visibility)
Sistem menggunakan kolom `tgl_daftar` untuk menentukan apakah seorang anggota harus muncul di tahun yang dipilih:
- **Aturan**: `YEAR(tgl_daftar) <= Tahun_Dipilih`
- **Contoh**: 
    - Jika memilih tahun **2024**, Anggota A (daftar 2023) akan **MUNCUL**.
    - Jika memilih tahun **2024**, Anggota B (daftar 2025) akan **TIDAK MUNCUL**.
    - Hal ini memastikan Manager melihat daftar anggota yang benar-benar aktif pada tahun tersebut.

## 3. Logika Kalkulasi Saldo (Dummy Cumulative)
Karena saat ini data yang ditampilkan masih berupa data simulasi (dummy), sistem menggunakan perhitungan akumulatif berdasarkan masa keanggotaan:

### Rumus Masa Aktif
`Masa_Aktif = Tahun_Dipilih - YEAR(tgl_daftar) + 1`

### Rumus Saldo per Kategori
`Saldo = (Kontribusi_Tahunan) * Masa_Aktif`

**Contoh Simulasi Anggota A (Daftar 2024):**
- **Jika Filter = 2024**: 
    - Masa Aktif = 2024 - 2024 + 1 = **1 Tahun**
    - Saldo Wajib = 500.000 * 1 = **500.000**
- **Jika Filter = 2025**:
    - Masa Aktif = 2025 - 2024 + 1 = **2 Tahun**
    - Saldo Wajib = 500.000 * 2 = **1.000.000**

## 4. Struktur Tampilan (UI)
- **Header**: Judul tabel secara dinamis berubah menjadi *"Data ringkasan saldo simpanan (Saldo Akhir) anggota pada tahun [Tahun]"*.
- **Dropdown Tahun**: Diambil otomatis dari database berdasarkan tahun pendaftaran anggota tertua hingga tahun pendaftaran terbaru.
- **Total Keseluruhan**: Merupakan jumlah dari semua kategori simpanan (Wajib + Pokok + Sukarela + Belanja + Dana Sosial) pada posisi tahun tersebut.

## 5. File yang Diubah
- `app/controllers/DashboardController.php`: Menangani logika query SQL dan parameter tahun.
- `views/dashboard/manager.php`: Menampilkan dropdown filter dan format tabel yang rapi.

---
*Catatan: Logika ini akan secara otomatis beralih ke data riil (transaksi asli) setelah sistem divalidasi dan data simulasi diganti dengan data dari tabel `simpanan_transaksi`.*
