# Dokumentasi Fitur Laporan - KSP Harapan Mulya

Fitur Laporan (Modul FD 3) telah diperbarui dengan integrasi logika akuntansi yang komprehensif dan antarmuka yang siap cetak (print-ready).

## Daftar Laporan

1. **Laba Rugi**: Perhitungan pendapatan operasional (bunga, denda, admin) dikurangi beban kas.
2. **Neraca Keuangan**: Rekapitulasi Aktiva (Kas & Piutang) dan Pasiva (Simpanan & Ekuitas).
3. **Tunggakan**: Daftar anggota yang memiliki keterlambatan angsuran, bersumber dari database view `v_tunggakan`.
4. **Distribusi SHU**: Alokasi Sisa Hasil Usaha berdasarkan persentase yang ditetapkan (Cadangan, Jasa Anggota, Pengurus, Pendidikan, Sosial).
5. **Riwayat Angsuran & Arus Kas**: Rekapitulasi transaksi periodik.

## Detail Implementasi Teknikal

### 1. Logic & Controller (`ChatbotController.php`)
- Penggunaan `buildDateFilter()` untuk fleksibilitas rentang waktu (Harian/Bulanan/Tahunan).
- Integrasi database view untuk performa query laporan yang lebih cepat.
- Perhitungan ekuitas dinamis: `Aset - Total Simpanan`.

### 2. Antarmuka (Views)
- **Standardisasi Bootstrap 5**: Menggantikan komponen Tailwind CSS agar konsisten dengan seluruh dashboard.
- **Fitur Cetak**: Implementasi layout `@media print` untuk menghasilkan dokumen fisik yang rapi dan profesional.
- **Signature Area**: Penambahan area tanda tangan dinamis (Ketua & Sekretaris) pada bagian bawah laporan.

## Cara Menggunakan
1. Masuk ke menu **Laporan** di sidebar.
2. Pilih jenis laporan yang diinginkan.
3. Gunakan filter periode jika diperlukan.
4. Klik tombol **Cetak** untuk mencetak laporan atau menyimpannya sebagai PDF.

---
*Dokumentasi ini dibuat untuk branch `fitur/laporan_byCharistiano`.*
