# Rekapitulasi Seluruh File yang Dimodifikasi — KSP Harapan Mulya

*(Dikompilasi dari: `Dokumentasi 18-05.md`, `Dokumentasi 19-05.md`, `Dokumentasi 20-05.md`, `Dokumentasi 21-05.md`)*

Dokumen ini merangkum **seluruh file** yang mengalami perubahan (`[MODIFY]`), ditambahkan baru (`[NEW]`), maupun dihapus (`[DELETE]`) sepanjang siklus pengembangan tanggal **18 Mei – 21 Mei 2026**.

---

## 📅 18 Mei 2026

> **Fokus**: Tab Navigasi Pratinjau, Cetak Ringkasan A4 Landscape, Ekspor Excel, Sinkronisasi Tahun Dashboard, Dark Mode Premium, Modal Logout Premium.

| No | Lokasi File | Status | Kategori / Layer | Deskripsi Singkat Perubahan |
| -- | --- | --- | --- | --- |
| 1 | `public/index.php` | **[MODIFY]** | Routing & Session | Registrasi rute cetak, ekspor excel, dan API endpoint ringkasan anggota. |
| 2 | `app/controllers/DashboardController.php` | **[MODIFY]** | Controller & Logic | Integrasi session filter tahun (`dashboard_selected_year`) di Dashboard Manager. |
| 3 | `app/controllers/LaporanController.php` | **[MODIFY]** | Controller & Logic | Implementasi method cetak, ekspor excel, dan API endpoint JSON data kumulatif. |
| 4 | `views/layout/main.php` | **[MODIFY]** | Layout Global | Penyematan markup & fungsi Javascript Modal Logout Premium secara global. |
| 5 | `views/layout/sidebar.php` | **[MODIFY]** | Layout Global | Mengalihkan tombol logout sidebar agar memicu Modal Logout Premium. |
| 6 | `views/layout/topbar.php` | **[MODIFY]** | Layout Global | Mengalihkan tombol logout dropdown topbar agar memicu Modal Logout Premium. |
| 7 | `views/laporan/pembukuan_lihat.php` | **[MODIFY]** | Views Laporan | Penambahan tab interface, AJAX loader data, tombol cetak/excel, dan perbaikan visual lencana status. |
| 8 | `views/laporan/pembukuan.php` | **[MODIFY]** | Views Laporan | Adaptasi visual Calendar Picker, kartu aksi, grid, dan tombol agar kompatibel penuh dengan Dark Mode. |
| 9 | `views/laporan/cetak_anggota.php` | **[NEW]** | Views Laporan | File template cetak landscape A4 formal dengan tanda tangan validator dan alamat terbaru. |
| 10 | `views/angsuran/detail.php` | **[MODIFY]** | Views Angsuran | Pembaruan alamat kantor pusat baru pada footer kuitansi angsuran. |
| 11 | `views/laporan/pembukuan_kirim.php` | **[MODIFY]** | Views Laporan | Modernisasi alur animasi popup pengiriman laporan ke BAU dengan checkmark sukses interaktif. |

---

## 📅 19 Mei 2026

> **Fokus**: Revisi Laporan Keuangan Bulanan, Pengiriman Laporan BAU, Restrukturisasi Log 12-Bulan, Skema Tanggal Tutup Buku Mundur, Perbaikan Ekspor `.xlsx`, Form Simpanan Sukarela Interaktif, Kalkulator Real-Time, Sinkronisasi Saldo.

| No | Lokasi File | Status | Kategori / Layer | Deskripsi Singkat Perubahan |
| -- | --- | --- | --- | --- |
| 1 | `public/index.php` | **[MODIFY]** | Routing & API | Pendaftaran route POST `/api/pinjaman/sukarela/tambah` untuk AJAX penambahan saldo. |
| 2 | `app/controllers/LaporanController.php` | **[MODIFY]** | Controller & Logic | Perubahan Simpanan Sukarela Flat Rp 65.000, sinkronisasi tambahan saldo, dan GROUP BY compat SQL mode. |
| 3 | `app/controllers/PinjamanController.php` | **[MODIFY]** | Controller & Logic | Perubahan Simpanan Sukarela Flat Rp 65.000, endpoint AJAX secure `tambahSukarela` dengan filter `ROLE_KETUA`. |
| 4 | `app/models/Pinjaman.php` | **[MODIFY]** | Model & Query | Penambahan field `a.tgl_daftar` dalam method `findWithAnggota` untuk mendukung bulan aktif anggota. |
| 5 | `views/laporan/pembukuan.php` | **[MODIFY]** | Views Laporan | Layout simetris 50/50, penghapusan kartu Kirim Laporan, dan integrasi modal pratinjau. |
| 6 | `views/laporan/pembukuan_lihat.php` | **[MODIFY]** | Views Laporan | Fixed 12-Month Table log laporan BAU, skema tanggal mundur, pembersihan tombol cetak, filter tahun. |
| 7 | `views/pinjaman/detail.php` | **[MODIFY]** | Views Pinjaman | UI Form Tambahan Simpanan Sukarela, tombol Eye-masking, Kalkulator Real-time, dan AJAX robust handler. |
| 8 | `app/controllers/DashboardController.php` | **[MODIFY]** | Controller & Logic | Dasbor manager Simpanan Sukarela Flat Rp 65.000, sinkronisasi tambahan, named parameter, dan GROUP BY. |
| 9 | `app/controllers/AnggotaController.php` | **[MODIFY]** | Controller & Logic | Perhitungan Simpanan Sukarela Flat Rp 65.000 dasar + tambahan untuk dialirkan ke detail profil anggota. |
| 10 | `views/anggota/detail.php` | **[MODIFY]** | Views Anggota | Integrasi form tambahan interaktif, masking eye, real-time calculator di Ringkasan Keuangan anggota. |

---

## 📅 20 Mei 2026

> **Fokus**: Jembatan Google Apps Script (Bypass Kuota 0 Byte), Penyusunan Folder Dinamis di Drive, Konversi Image-to-PDF (FPDF), Bugfix `.tmp`, Offline Fallback, Pencegahan Orphan Files, Pratinjau Cloud Secure (Bypass 403), Pembersihan Repositori.

| No | Lokasi File | Status | Kategori / Layer | Deskripsi Singkat Perubahan |
| -- | --- | --- | --- | --- |
| 1 | `storage/app/google-apps-script-config.json` | **[NEW]** | Konfigurasi | File konfigurasi terpusat untuk menyimpan URL jembatan Google Apps Script dan API Key secara aman. |
| 2 | `database/migrate_anggota_dokumen.sql` | **[NEW]** | Database / DDL | Membuat skema tabel `anggota_dokumen` baru dengan relasi foreign key cascade dan kolom `drive_file_id` nullable. |
| 3 | `request/drive/proses.md` | **[NEW]** | Dokumentasi | Panduan premium deployment Google Apps Script, otorisasi keamanan, penanganan multi-akun Google, dan alur integrasi. |
| 4 | `request/walkhtrough/walk-20-05.md` | **[NEW]** | Dokumentasi | Walkthrough lengkap seluruh pembaruan, pengujian cURL otomatis, bugfix FPDF, dan skema offline local fallback. |
| 5 | `app/services/GoogleDriveService.php` | **[MODIFY]** | Service / Driver | Menulis ulang class secara total menggunakan cURL ringan ke jembatan Google Apps Script (bypass Google Client API). |
| 6 | `app/controllers/AnggotaController.php` | **[MODIFY]** | Controller & Logic | Pemrosesan upload dokumen, konversi gambar ke PDF (FPDF), bugfix ekstensi tmp, fallback lokal, dan sinkronisasi hapus. |
| 7 | `views/anggota/edit.php` | **[MODIFY]** | Views Anggota | UI Form upload & status kelengkapan 4 dokumen (KTP, KK, Form Pengajuan, Surat Perjanjian) dengan integrasi SweetAlert2. |
| 8 | `views/anggota/detail.php` | **[MODIFY]** | Views Anggota | UI Status kelengkapan dokumen 4 berkas lengkap dengan tata letak yang indah di bawah detail profil anggota. |
| 9 | `views/anggota/view_dokumen.php` | **[MODIFY]** | Views Anggota | Integrasi Google Drive Preview Iframe dengan secure bypass multi-login, tombol unduh langsung, dan offline fallback. |
| 10 | `.gitignore` | **[MODIFY]** | Git Config | Penambahan berkas rahasia `google-apps-script-config.json` agar terabaikan dari komit Git publik. |
| 11 | `request/walkthrough_gdrive.md` | **[DELETE]** | Dokumentasi | Penghapusan file panduan Service Account lama yang sudah tidak berlaku lagi. |
| 12 | `request/alurku.md` | **[DELETE]** | Dokumentasi | Penghapusan dokumen alur Service Account lama agar tidak membingungkan pengembang. |
| 13 | `request/alur_penyimpanan_dokumen.md` | **[DELETE]** | Dokumentasi | Penghapusan dokumen alur Service Account lama. |
| 14 | `request/img/` (folder) | **[DELETE]** | Aset Visual | Penghapusan gambar/diagram alur lama yang tidak lagi valid. |
| 15 | `scratch/` (folder) | **[DELETE]** | Temporary | Pembersihan direktori sementara dan berkas pengujian basis data `view_db.php`. |

---

## 📅 21 Mei 2026

> **Fokus**: Sistem Pengarsipan Otomatis (KSP_Trash → Arsip_KSP), Input Upload Selalu Terlihat, Tombol "Hapus" → "Arsipkan", Pencarian Arsip Anggota, Struktur Folder Berbasis Tahun, Manajemen Arsip untuk Manager & Validator, Direct Link ke Google Drive.

| No | Lokasi File | Status | Kategori / Layer | Deskripsi Singkat Perubahan |
| -- | --- | --- | --- | --- |
| 1 | `app/services/GoogleDriveService.php` | **[MODIFY]** | Service / Driver | Penambahan fungsi `archiveFile()` untuk memicu aksi pemindahan file ke folder `Arsip_KSP` via Google Apps Script. |
| 2 | `app/controllers/AnggotaController.php` | **[MODIFY]** | Controller & Logic | Modifikasi `deleteDokumen` dan `uploadDokumen` untuk alur pemindahan berkas ke `Arsip_KSP` (cloud & local fallback) dengan folder berbasis tahun dan timestamp. |
| 3 | `app/controllers/LaporanController.php` | **[MODIFY]** | Controller & Logic | Penambahan method `arsip()` dan `arsipSearch()`, perbaikan bug PDO binding (`:q` → `:q1,:q2,:q3`), koreksi kolom `nidn_niy` → `identitas_no`. |
| 4 | `views/anggota/edit.php` | **[MODIFY]** | Views Anggota | Merombak 4 tombol dokumen dari aksi "Hapus" ke "Arsipkan" dengan ikon `bi-archive`, warna oranye warning, dan dialog konfirmasi SweetAlert2. |
| 5 | `views/laporan/index.php` | **[MODIFY]** | Views Laporan | Menambahkan kategori "Manajemen Arsip" terpisah dari "Lapor BAU", visibilitas untuk role Manager & Validator, direct link ke Google Drive folder `Arsip_KSP`. |
| 6 | `views/arsip/index.php` | **[NEW]** | Views Arsip | Halaman pencarian arsip anggota interaktif (AJAX suggestion dropdown) dengan integrasi URL Google Drive. |
| 7 | `public/index.php` | **[MODIFY]** | Routing | Pendaftaran route `/arsip` dan `/api/arsip/search` untuk halaman dan endpoint pencarian arsip. |
| 8 | `request/walkhtrough/walk-21-05.md` | **[NEW]** | Dokumentasi | Walkthrough lengkap 5 bagian, dari implementasi awal hingga revisi akhir terminologi dan UI. |
| 9 | `request/walkhtrough/Dokumentasi 21-05.md` | **[NEW]** | Dokumentasi | Dokumentasi teknis rekapitulasi perubahan harian 21 Mei 2026 dengan diagram Mermaid. |

---

## 📅 11 Juni 2026

> **Fokus**: Halaman Error 404 & 403 Interaktif, Animasi Wordsearch, Implementasi Clean URL, Proteksi Struktur Direktori Server, Bypass Infinite Loop Apache ErrorDocument.

| No | Lokasi File | Status | Kategori / Layer | Deskripsi Singkat Perubahan |
| -- | --- | --- | --- | --- |
| 1 | `request/404/dist/script.js` | **[MODIFY]** | Template | Perbaikan logika animasi menggunakan metode `setTimeout` berurutan. |
| 2 | `request/404/dist/style.css` | **[MODIFY]** | Template | Perbaikan CSS tata letak kotak grid (*anti-wrapping*). |
| 3 | `request/404/dist/index.html` | **[MODIFY]** | Template | Pembaruan URL jQuery ke HTTPS dan modifikasi huruf grid. |
| 4 | `.htaccess` (Root) | **[NEW]** | Server Config | Enforcing Clean URL, Options -Indexes, & deteksi *Forbidden folders* (403). |
| 5 | `public/index.php` | **[MODIFY]** | Routing | Perbaikan *setNotFound* dan penyisipan logika *interceptor* `$_GET['error']=403`. |
| 6 | `views/errors/404.php` | **[NEW]** | Views | Pembuatan halaman template 404 "Page Not Found". |
| 7 | `views/errors/403.php` | **[NEW]** | Views | Pembuatan halaman template 403 "Error Forbidden". |
| 8 | `public/assets/css/404.css` | **[NEW]** | Aset Publik | Berkas stylesheet khusus halaman 404. |
| 9 | `public/assets/css/403.css` | **[NEW]** | Aset Publik | Berkas stylesheet khusus halaman 403. |
| 10 | `public/assets/js/404.js` | **[NEW]** | Aset Publik | Berkas script jquery khusus animasi 404 (15 kelas). |
| 11 | `public/assets/js/403.js` | **[NEW]** | Aset Publik | Berkas script jquery khusus animasi 403 (17 kelas). |
| 12 | `request/walkhtrough/walk-11-06.md` | **[NEW]** | Dokumentasi | Walkthrough catatan narasi komprehensif pengembangan tanggal 11 Juni 2026. |
| 13 | `request/walkhtrough/Dokumentasi 11-06.md` | **[NEW]** | Dokumentasi | Dokumentasi teknis diagram alir 403 dan rekapitulasi file. |

---

## 📊 Ringkasan Statistik Keseluruhan

| Tanggal | File Baru (`[NEW]`) | File Dimodifikasi (`[MODIFY]`) | File Dihapus (`[DELETE]`) | Total Aksi |
| --- | :---: | :---: | :---: | :---: |
| 18 Mei 2026 | 1 | 10 | 0 | **11** |
| 19 Mei 2026 | 0 | 10 | 0 | **10** |
| 20 Mei 2026 | 4 | 6 | 5 | **15** |
| 21 Mei 2026 | 3 | 6 | 0 | **9** |
| 11 Juni 2026 | 9 | 4 | 0 | **13** |
| **Grand Total** | **17** | **36** | **5** | **58** |

---

## 🗂️ Daftar File Unik yang Terdampak (Deduplikasi)

Berikut adalah daftar file **unik** yang pernah disentuh setidaknya satu kali sepanjang 18–21 Mei 2026, diurutkan berdasarkan frekuensi modifikasi tertinggi:

| No | Lokasi File | Frekuensi | Tanggal Terdampak |
| -- | --- | :---: | --- |
| 1 | `app/controllers/AnggotaController.php` | 4× | 19, 20, 21 Mei |
| 2 | `app/controllers/LaporanController.php` | 4× | 18, 19, 21 Mei |
| 3 | `views/anggota/edit.php` | 2× | 20, 21 Mei |
| 4 | `views/anggota/detail.php` | 3× | 18, 19, 20 Mei |
| 5 | `views/laporan/pembukuan_lihat.php` | 2× | 18, 19 Mei |
| 6 | `views/laporan/pembukuan.php` | 2× | 18, 19 Mei |
| 7 | `app/controllers/DashboardController.php` | 2× | 18, 19 Mei |
| 8 | `public/index.php` | 3× | 18, 19, 21 Mei |
| 9 | `app/services/GoogleDriveService.php` | 2× | 20, 21 Mei |
| 10 | `views/laporan/index.php` | 1× | 21 Mei |
| 11 | `views/layout/main.php` | 1× | 18 Mei |
| 12 | `views/layout/sidebar.php` | 1× | 18 Mei |
| 13 | `views/layout/topbar.php` | 1× | 18 Mei |
| 14 | `views/angsuran/detail.php` | 1× | 18 Mei |
| 15 | `views/laporan/pembukuan_kirim.php` | 1× | 18 Mei |
| 16 | `views/laporan/cetak_anggota.php` | 1× | 18 Mei (NEW) |
| 17 | `app/controllers/PinjamanController.php` | 1× | 19 Mei |
| 18 | `app/models/Pinjaman.php` | 1× | 19 Mei |
| 19 | `views/pinjaman/detail.php` | 1× | 19 Mei |
| 20 | `storage/app/google-apps-script-config.json` | 1× | 20 Mei (NEW) |
| 21 | `database/migrate_anggota_dokumen.sql` | 1× | 20 Mei (NEW) |
| 22 | `views/anggota/view_dokumen.php` | 1× | 20 Mei |
| 23 | `.gitignore` | 1× | 20 Mei |
| 24 | `views/arsip/index.php` | 1× | 21 Mei (NEW) |
| 25 | `request/drive/proses.md` | 1× | 20 Mei (NEW) |

> [!NOTE]
> Dokumen ini bersifat kumulatif. File walkthrough dan dokumentasi harian (`walk-xx-05.md`, `Dokumentasi xx-05.md`) tidak dicantumkan di tabel deduplikasi karena merupakan file catatan pengembangan, bukan kode sumber aplikasi.
