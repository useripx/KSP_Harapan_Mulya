# Rencana Implementasi: Fitur Cetak BAU & Pembukuan (Fokus Frontend - Role Manager)

Dokumen ini berisi rencana implementasi untuk menambahkan menu **Pembukuan** di bawah kategori baru **Cetak BAU** pada halaman **Pusat Laporan & Analitik**, khusus difokuskan pada peran **Manager**. Sesuai arahan, pengerjaan tahap ini berfokus penuh pada **Frontend** terlebih dahulu untuk menjaga fleksibilitas backend di masa mendatang.

---

## 📌 Deskripsi Goal (Fokus Frontend)
1. **Fokus Penuh pada Frontend**: Semua halaman dan sub-menu yang dibuat akan menyajikan antarmuka pengguna (UI) premium, interaktif, responsif, dan dinamis menggunakan data mockup terlebih dahulu. Logika backend (seperti integrasi Google Service atau OAuth 2.0) ditangguhkan hingga keputusan arsitektur backend final diambil.
2. **Kategori Baru "Cetak BAU"**: Menambahkan kategori bernama **"Cetak BAU"** di halaman utama Laporan (`/laporan`).
3. **Card Menu "Pembukuan" (Akses Terbatas)**: Menampilkan menu "Pembukuan" di bawah kategori "Cetak BAU" **hanya jika** pengguna yang masuk adalah **Manager** (`ROLE_KETUA`).
4. **Halaman Menu Pembukuan**: Mengarahkan ke `/laporan/pembukuan` yang menampilkan 3 sub-menu utama:
   - **Buat Laporan** (Arah rute: `/laporan/pembukuan/buat`)
   - **Lihat Laporan** (Arah rute: `/laporan/pembukuan/lihat`)
   - **Kirim Laporan** (Arah rute: `/laporan/pembukuan/kirim` — khusus ditujukan untuk mengirimkan laporan kepada pihak **BAU**).

---

## 🔒 Aturan Hak Akses & Pengiriman
- **Akses Eksklusif**: Menu **Cetak BAU -> Pembukuan** hanya dapat diakses oleh user dengan role **Manager** (`ROLE_KETUA`). Jika diakses oleh role lain (seperti Validator atau BAU), sistem akan mengembalikan halaman error 403 atau mengalihkan kembali ke dashboard dengan pesan peringatan.
- **Kirim Laporan**: Halaman **Kirim Laporan** dirancang khusus untuk memfasilitasi pengiriman laporan dari **Manager** menuju **BAU (Bagian Administrasi Umum)**.

---

## 🛠️ Rencana Perubahan Kode & File

### 1. Routing & Controller

#### [MODIFY] [index.php (Public Routes)](file:///c:/laragon/www/Ksp_Koperasinat/public/index.php)
Mendaftarkan rute-rute baru untuk menyajikan halaman frontend Pembukuan:
```php
// Laporan -> Pembukuan BAU & Sub-Menu (Fokus Manager)
$router->get('/laporan/pembukuan', 'LaporanController@pembukuan');
$router->get('/laporan/pembukuan/buat', 'LaporanController@pembukuanBuat');
$router->get('/laporan/pembukuan/lihat', 'LaporanController@pembukuanLihat');
$router->get('/laporan/pembukuan/kirim', 'LaporanController@pembukuanKirim');
```

#### [MODIFY] [LaporanController.php](file:///c:/laragon/www/Ksp_Koperasinat/app/controllers/LaporanController.php)
Menambahkan metode controller dengan validasi ketat agar hanya role **Manager** (`ROLE_KETUA`) yang dapat mengakses halaman tersebut:
```php
    /**
     * Memastikan hanya Manager (ROLE_KETUA) yang dapat mengakses halaman Pembukuan BAU
     */
    private function requireManagerOnly()
    {
        if (Auth::role() !== ROLE_KETUA) {
            $this->redirect('/laporan', 'Akses ditolak. Menu ini hanya dapat diakses oleh Manager.', 'error');
        }
    }

    public function pembukuan()
    {
        $this->requireManagerOnly();
        $this->view('laporan/pembukuan', [
            'pageTitle' => 'Pembukuan BAU'
        ]);
    }

    public function pembukuanBuat()
    {
        $this->requireManagerOnly();
        $this->view('laporan/pembukuan_buat', [
            'pageTitle' => 'Buat Laporan BAU'
        ]);
    }

    public function pembukuanLihat()
    {
        $this->requireManagerOnly();
        $this->view('laporan/pembukuan_lihat', [
            'pageTitle' => 'Daftar Laporan BAU'
        ]);
    }

    public function pembukuanKirim()
    {
        $this->requireManagerOnly();
        $this->view('laporan/pembukuan_kirim', [
            'pageTitle' => 'Kirim Laporan ke BAU'
        ]);
    }
```

---

### 2. Tampilan Antarmuka (Frontend Views)

#### [MODIFY] [index.php (View Laporan)](file:///c:/laragon/www/Ksp_Koperasinat/views/laporan/index.php)
Menambahkan kategori **Cetak BAU** dan card **Pembukuan** secara dinamis yang hanya muncul bagi role **Manager**:
```html
    <?php if (Auth::role() === ROLE_KETUA): ?>
    <!-- Cetak BAU (Khusus Manager) -->
    <div class="col-12 mt-5">
        <h5 class="fw-bold mb-3 d-flex align-items-center">
            <i class="bi bi-file-earmark-bar-graph me-2" style="color: #6610f2;"></i> Cetak BAU
        </h5>
    </div>
    
    <div class="col-md-4">
        <a href="<?= url('/laporan/pembukuan') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #6610f2 !important;">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3" style="background-color: #f1e6ff; color: #6610f2;">
                            <i class="bi bi-journal-bookmark fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold">Pembukuan</h6>
                    </div>
                    <p class="card-text text-muted small">Kelola penyusunan, peninjauan, dan pengiriman berkas laporan kepada pihak BAU.</p>
                </div>
            </div>
        </a>
    </div>
    <?php endif; ?>
```

#### [NEW] [pembukuan.php](file:///c:/laragon/www/Ksp_Koperasinat/views/laporan/pembukuan.php)
- Membuat halaman menu berpenampilan modern dengan kartu navigasi untuk 3 sub-menu utama: **Buat Laporan**, **Lihat Laporan**, dan **Kirim Laporan**.
- Desain menggunakan palet warna premium harmonis (indigo/purple) dengan efek hover halus.

#### [NEW] [pembukuan_buat.php](file:///c:/laragon/www/Ksp_Koperasinat/views/laporan/pembukuan_buat.php)
- Halaman form interaktif untuk menyusun laporan baru.
- Berisi pilihan periode buku, daftar cakupan laporan keuangan (Neraca, Laba Rugi, Kas), catatan manajerial, serta tombol aksi "Generate Draf Laporan" yang disimulasikan dengan antarmuka yang dinamis.

#### [NEW] [pembukuan_lihat.php](file:///c:/laragon/www/Ksp_Koperasinat/views/laporan/pembukuan_lihat.php)
- Menyediakan tabel log laporan pembukuan yang telah dibuat dengan status visual seperti `Draf`, `Final`, atau `Terkirim ke BAU`.
- Dilengkapi dengan fitur tiruan (mock) pencarian, filter, dan tombol cetak/pratinjau.

#### [NEW] [pembukuan_kirim.php](file:///c:/laragon/www/Ksp_Koperasinat/views/laporan/pembukuan_kirim.php)
- Didesain secara khusus untuk pengiriman berkas ke **Bagian Administrasi Umum (BAU)**.
- Form mencakup pilihan file draf laporan yang akan dikirim, input nama penerima di BAU, catatan pesan pengantar, serta tombol kirim dengan mikro-animasi loading sukses.

---

## 🔍 Rencana Verifikasi
1. **Verifikasi Hak Akses**:
   - Login sebagai **Validator** atau **BAU**, lalu buka `/laporan`. Pastikan kategori **Cetak BAU** dan card **Pembukuan** **tidak muncul**. Coba ketik langsung `/laporan/pembukuan` di URL bar, dan pastikan pengguna dialihkan kembali ke `/laporan` dengan pesan error akses ditolak.
   - Login sebagai **Manager** (`ROLE_KETUA`), periksa apakah kategori dan kartu Pembukuan tampil sempurna.
2. **Navigasi Frontend**:
   - Klik kartu "Pembukuan" sebagai Manager, pastikan masuk ke `/laporan/pembukuan` dengan tata letak grid 3 sub-menu yang estetis.
   - Klik masing-masing sub-menu ("Buat", "Lihat", "Kirim") dan pastikan semua rute menyajikan halaman UI yang dirancang khusus tanpa adanya error 404.
3. **Responsivitas**:
   - Uji tampilan di mobile browser (atau responsive mode pengembang) untuk memastikan form dan tabel dapat terbaca dan digunakan dengan nyaman di semua resolusi layar.
