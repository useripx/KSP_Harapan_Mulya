# DOKUMENTASI PERUBAHAN SISTEM (PEMBUKUAN BAU & MANAJEMEN ANGGOTA)

Dokumen ini merangkum seluruh pembaruan desain antarmuka, penambahan fitur interaktif, dan modifikasi kode yang telah dilakukan pada modul Pelaporan Pembukuan BAU, sekaligus menggabungkan pembaruan pada modul Manajemen Berkas Anggota.

---

## BAGIAN 1: PEMBARUAN MODUL PELAPORAN & PEMBUKUAN BAU (FRONTEND)

### 1. Perubahan Struktur File & Halaman
- **[HAPUS]** `views/laporan/pembukuan_buat.php`
  - Halaman form kompleks (yang memuat checkbox cakupan laporan & textarea catatan) telah dibuang sepenuhnya untuk menyederhanakan alur kerja pengguna (UI/UX).
- **[UBAH]** `views/laporan/pembukuan.php`
  - Mengadopsi tata letak kartu horizontal premium (rata kiri, ikon *rounded-rect*, aksen *border-left* berwarna 4px) untuk 3 sub-menu utama: **Buat Laporan**, **Lihat Laporan**, dan **Kirim Laporan**.
  - Mengintegrasikan **Pop Up Kalender Premium** secara langsung di dalam dashboard.
- **[UBAH]** `views/laporan/index.php`
  - Penyelarasan tata letak, mengubah letak *Riwayat & Log Transaksi* menjadi di bawah, dan *Cetak BAU* ke nomor 2.
  - Menyeragamkan seluruh gaya desain kartu laporan (memberikan aksen *border-left* biru, hijau, cyan) agar konsisten dengan gaya desain halaman Pembukuan.
- **[UBAH]** `views/laporan/pembukuan_lihat.php`
  - Penghapusan tombol navigasi "+ Buat Laporan Baru" dari halaman Daftar Laporan BAU untuk memusatkan pembuatan laporan murni dari halaman dashboard utama pembukuan.

### 2. Fitur Interaktif Baru: Kalender Pop Up (Windows 11 Style)
- **Alur Pembuatan Kilat**: Mengklik kartu "Buat Laporan" di halaman `pembukuan.php` kini langsung memicu kemunculan modal kalender di tengah layar, tanpa _loading_ perpindahan halaman.
- **Desain Windows Premium**: Menggunakan desain minimalis (font _Segoe UI_), menghilangkan teks "Pop up Preview", memberikan *highlight* solid (biru-putih) pada tanggal yang dipilih, menghilangkan background khusus pada hari Minggu, serta melengkapi modal dengan sepasang tombol standar **Cancel** dan **OK**.
- **Rentang Tahun Dinamis (1926-2126)**: Pilihan tahun tidak lagi statis/hardcoded. Dropdown tahun di-generate via JavaScript untuk memberikan pilihan melimpah sejauh 200 tahun.
- **Navigasi Cerdas**: Menambahkan tombol panah navigasi (`<` dan `>`) pada *header* kalender yang secara otomatis mengatur penyesuaian tahun jika bulan digeser mundur melampaui Januari atau maju melampaui Desember.
- **Simulasi Loading Interaktif**: Mengklik tombol OK pada kalender akan menutup pop-up, menampilkan _overlay glassmorphism_ "Menyusun Data Laporan...", lalu memunculkan _Widget Sukses_ langsung di halaman dashboard dan menyimpan draf datanya ke `localStorage`.

---

## BAGIAN 2: PEMBARUAN MODUL MANAJEMEN BERKAS ANGGOTA (BACKEND & UI)
*(Pembaruan ini dikembangkan dan digabungkan dari berkas catatan teman tim)*

### **DOKUMENTASI PERUBAHAN MODUL: MANAJEMEN BERKAS ANGOTA**

Dokumen ini mencatat seluruh aset digital (file) yang mengalami modifikasi, file baru yang dibuat, serta penambahan struktur pada database untuk keperluan keberlanjutan pengembangan proyek (_handover_).

#### **1. PERUBAHAN PADA STRUKTUR DATABASE (DB)**

Untuk memisahkan berkas fisik dari data profil utama agar performa database tetap ringan, dibuat satu tabel relasi baru:

- **Nama Tabel Baru:** `anggota_dokumen`
    
- **Spesifikasi Kolom:**
    
    - Kolom ID Utama (`id`) sebagai kunci utama yang otomatis bertambah (_Auto Increment_).
        
    - Kolom Penghubung (`anggota_id`) sebagai kunci tamu (_Foreign Key_) yang mengikat langsung ke tabel induk `anggota`. Hubungan ini dipasang fitur otomatis hapus (_ON DELETE CASCADE_), artinya jika data anggota dihapus dari sistem, seluruh catatan berkasnya di tabel ini akan otomatis ikut terhapus bersih.
        
    - Kolom Jenis Dokumen (`jenis_dokumen`) dikunci ketat menggunakan tipe data pilihan (_Enum_) yang hanya mengizinkan 3 jenis kategori saja: **`ktp`**, **`perjanjan`**, atau **`pengajuan`**.
        
    - Kolom Nama File (`nama_file`) untuk menyimpan string nama berkas unik yang terenkripsi di server.
        
    - Kolom Penanda Waktu (`uploaded_at`) untuk mencatat otomatis tanggal dan jam berkas diunggah.
        

#### **2. DAFTAR FILE YANG BARU DIBUAT**

Tidak ada file tampilan (_view_) baru yang dibuat karena sistem memanfaatkan form interaktif yang ditanam langsung (_inline upload_) pada halaman yang sudah ada. Namun, ada satu folder penyimpanan baru yang wajib dipastikan keberadaannya di dalam server:

- **Folder Baru di Server:** `public/uploads/dokumen/`
    
    - **Fungsi:** Tempat penampungan seluruh file fisik (berkas gambar JPG/PNG atau dokumen PDF) yang diunggah oleh pengurus.
        

#### **3. DAFTAR FILE YANG DIEDIT / DIMODIFIKASI**

Promer berikutnya harus memperhatikan tiga file utama ini yang menjadi mesin penggerak alur data dari halaman detail hingga proses upload berkas:

##### **A. file: `controllers/AnggotaController.php` (Sisi Logika)**

Mengalami penambahan logika fungsional pada fungsi yang sudah ada dan penambahan satu fungsi aksi baru:

- **Pada Fungsi `detail()`:** Ditambahkan query untuk menarik data berkas dari tabel `anggota_dokumen` berdasarkan ID anggota yang sedang dibuka. Pengambilan data menggunakan metode pasangan kunci (_Key-Pair Array_) agar status berkas langsung terpetakan ke halaman detail.
    
- **Pada Fungsi `edit()`:** Ditambahkan query pengambilan data berkas yang sama persis seperti pada fungsi detail. Hal ini wajib dilakukan agar form upload interaktif di halaman edit tahu berkas mana saja yang sudah terisi dan mana yang masih kosong.
    
- **Fungsi Aksi Baru `uploadDokumen()`:** Berfungsi untuk memproses kiriman file dari halaman edit. Logikanya meliputi: memvalidasi format berkas (hanya JPG, JPEG, PNG, PDF), mengenkripsi nama file asli menjadi format baru yang unik (`{jenis}_{nomor_anggota}_{timestamp}` agar file tidak saling tertimpa), memindahkan file fisik ke folder penyimpanan server, dan melakukan simpan atau pembaruan (_Upsert_) data ke tabel `anggota_dokumen`.
    

##### **B. file: `views/anggota/detail.php` (Tampilan Pemantau / Read-Only)**

- **Modifikasi Layout:** Menyelaraskan struktur halaman menjadi dua kolom agar sejajar posisinya dengan halaman edit. Kolom kiri menampilkan data profil teks anggota, kolom kanan menampilkan kotak kelengkapan dokumen.
    
- **Penerapan Logika Tampilan:** Ditambahkan pengondisian dinamis. Jika data nama file terbaca di database, sistem memunculkan tombol **"Buka"** untuk melihat berkas asli di tab baru. Jika kosong, sistem otomatis memunculkan teks indikator merah **"Belum diupload"**.
    
- **Navigasi:** Ditambahkan tombol transisi "Edit Anggota" di bagian atas untuk mengarahkan pengurus ke pusat manajemen berkas jika ada dokumen yang belum lengkap.
    

##### **C. file: `views/anggota/edit.php` (Tampilan Pusat Upload Interaktif)**

- **Modifikasi Layout:** Mengubah struktur halaman menjadi dua kolom menggunakan grid Bootstrap (Kolom kiri untuk form ubah data teks profil, kolom kanan untuk manajemen berkas).
    
- **Penerapan Form Upload Interaktif:** Pada kolom kanan, setiap jenis berkas dipasang logika kondisional. Jika berkas sudah ada di database, form upload disembunyikan dan digantikan dengan tombol **"Buka Berkas"**. Jika berkas masih kosong, sistem otomatis merender kolom pilih file (`<input type="file">`) beserta tombol **"Upload"** secara langsung di baris dokumen tersebut (_inline_). Form ini juga dikonfigurasi wajib menggunakan atribut multi-part berkas (_enctype_) agar file fisik bisa ditangkap oleh server PHP.
