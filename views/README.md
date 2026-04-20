# Direktori Tampilan (Views)

Folder ini berisi file template UI aplikasi (User Interface). Rata-rata menggunakan PHP yang menyuntikkan data dari Kontroler.

## Struktur Tampilan

- `layout/`: Berisi template utama (header, footer, sidebar) yang digunakan secara konsisten.
- `auth/`: Halaman login, profil, dan **Pengaturan** (termasuk Ganti Sandi).
- `dashboard/`: Tampilan dashboard untuk tiap peran (Admin, Teller, Ketua, Anggota).
- `anggota/`: Antarmuka manajemen data anggota.
- `simpanan/`: antarmuka transaksi simpanan (Setor, Tarik, Transfer).
- `pinjaman/`: antarmuka pengajuan, verifikasi, dan daftar pinjaman.
- `angsuran/`: antarmuka pembayaran angsuran dengan detail kuitansi.
- `kas/`: Log dokumentasi transaksi buku kas.
- `laporan/`: Pusat laporan keuangan dan riwayat transaksi.

## Gaya Desain UI
Aplikasi ini menggunakan filosofi desain **Shadcn UI** yang bersih dan modern:
- **Font**: Inter (Google Fonts) untuk keterbacaan tinggi.
- **Ikon**: Bootstrap Icons untuk konsistensi visual.
- **Grafik**: Chart.js untuk visualisasi data yang interaktif.
- **Layout**: Sidebar yang menetap (sticky) dengan konten utama yang dapat di-scroll.
- **Ekspor**: Fitur konversi **PDF** instan untuk kuitansi menggunakan `html2pdf.js`.
- **Pencetakan**: Optimalisasi CSS siap-cetak untuk dokumen fisik yang profesional.
