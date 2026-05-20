# 🚀 Alur Penyimpanan Berkas & Integrasi Google Drive + Auto-PDF

Dokumen ini menjelaskan rancangan arsitektur dan alur kerja (workflow) mutakhir untuk penyimpanan berkas kelengkapan anggota KSP Harapan Mulya. Sistem ini mengintegrasikan **Konversi Format Otomatis (Image-to-PDF)** dan **Sinkronisasi Google Drive API** dengan pembagian folder terstruktur demi kerapian data, keamanan tingkat tinggi, dan kemudahan akses.

---

## 📸 Infografis Alur Kerja (High-Level SaaS Pipeline)

Berikut adalah gambaran visual berestetika premium mengenai proses pengunggahan, konversi, deteksi folder, hingga penyimpanan di Google Drive:

![Pipeline Penyimpanan Berkas KSP ke Google Drive](file:///c:/laragon/www/Ksp_Koperasinat/image/doc_upload_flow.png)

*Infografis di atas menunjukkan visualisasi 4 langkah utama sistem memproses berkas unggahan.*

---

## 🔄 1. Langkah-Demi-Langkah Alur Kerja (Step-by-Step Flow)

Ketika seorang **Validator** mengunggah berkas anggota (misalnya untuk Anggota dengan Nomor: `A0001`, Nama: `Budi Santoso`), sistem secara cerdas akan mengeksekusi langkah-langkah di bawah ini:

### 📥 Langkah A: Deteksi Unggahan & Penyimpanan Sementara
1. **Penerimaan Berkas:** Validator mengunggah berkas dari halaman admin (KTP, KK, Form Pengajuan, dll.).
2. **Penyimpanan Lokal Sementara:** Sistem menangkap file dari `$_FILES` dan memindahkannya ke direktori lokal sementara server hosting (`public/uploads/temp/`) untuk diproses.
3. **Deteksi Jenis Dokumen:** Sistem membaca parameter input untuk membedakan dokumen profil (KTP, KK) dengan dokumen pinjaman (Form Pengajuan, Surat Perjanjian).

### 🛠️ Langkah B: Konversi PDF Otomatis & Standardisasi Nama File
1. **Deteksi Format:** Sistem mengecek ekstensi file asal.
   * Jika berkas yang diunggah berupa gambar (`.png`, `.jpg`, `.jpeg`, dll.):
     * Sistem memicu library konversi PDF di server (misalnya PHP `GD`/`Imagick` dikombinasikan dengan `FPDF` atau `Dompdf`).
     * Gambar dibungkus dan dikonversi menjadi file `.pdf` murni dengan kompresi yang dioptimalkan untuk performa.
   * Jika berkas yang diunggah sudah berupa `.pdf`, tahap konversi dilewati.
2. **Standardisasi Nama File:** Nama file diubah secara otomatis menjadi format seragam (seluruhnya huruf kecil, spasi diganti dengan garis bawah):
   $$\text{Format Nama Berkas} = \text{\{jenis\_dokumen\}}\_\text{\{no\_anggota\}}\_\text{\{nama\_anggota\}}.pdf$$
   * *Contoh KTP:* `ktp_a0001_budi_santoso.pdf`
   * *Contoh KK:* `kk_a0001_budi_santoso.pdf`
   * *Contoh Form Pengajuan:* `pengajuan_a0001_budi_santoso.pdf`

### ☁️ Langkah C: Deteksi Folder Root & Folder Anggota di Google Drive
Sistem berkomunikasi secara asinkron dengan **Google Drive API** menggunakan Service Account resmi:
1. **Pencarian Folder Root (`KSP`):**
   * Sistem memeriksa apakah folder bernama **`KSP`** sudah ada di akun Google Drive.
   * Jika belum ada, sistem membuatnya terlebih dahulu dan mencatat `Folder ID` dari folder `KSP` tersebut.
2. **Pencarian Folder Anggota (`{no_anggota}_{nama_anggota}`):**
   * Di dalam folder `KSP`, sistem mencari folder dengan nama format `{no_anggota}_{nama_anggota}` (Contoh: `A0001_Budi Santoso`).
   * Jika **belum ada**, sistem akan secara dinamis membuat folder baru: `A0001_Budi Santoso` di dalam folder `KSP`.

### 📂 Langkah D: Pembagian Folder (Subfolder Routing) & Pengunggahan Final
Sistem mengelompokkan berkas secara rapi ke dalam dua subfolder di dalam folder anggota tersebut:
1. **Subfolder `profil`:**
   * Digunakan khusus untuk dokumen identitas diri: **KTP, KK, Pas Foto**.
   * Jika subfolder `profil` belum ada di dalam folder anggota, sistem akan membuatnya secara dinamis.
   * Sistem mengunggah file `ktp_a0001_budi_santoso.pdf` atau `kk_a0001_a0001_budi_santoso.pdf` ke dalam subfolder `profil`.
2. **Subfolder `pinjaman`:**
   * Digunakan khusus untuk dokumen transaksi kredit: **Form Pengajuan, Surat Perjanjian Kredit, Slip Gaji, Foto Jaminan**.
   * Jika subfolder `pinjaman` belum ada di dalam folder anggota, sistem akan membuatnya secara dinamis.
   * Sistem mengunggah file `pengajuan_a0001_budi_santoso.pdf` atau `perjanjian_a0001_budi_santoso.pdf` ke dalam subfolder `pinjaman`.
3. **Pembersihan Server Lokal:**
   * Setelah file sukses diunggah ke Google Drive dan ID File Drive tercatat di database koperasi, file fisik di folder sementara server hosting (`public/uploads/temp/`) **dihapus secara otomatis (`unlink()`)** untuk menghemat penyimpanan hosting lokal.

---

## 📊 2. Diagram Alur Logika Sistem (Mermaid Flowchart)

Berikut adalah diagram alur keputusan (decision tree) dari backend saat menerima berkas unggahan:

```mermaid
graph TD
    %% Styling
    classDef startEnd fill:#0f172a,stroke:#38bdf8,stroke-width:2px,color:#fff;
    classDef process fill:#1e293b,stroke:#475569,stroke-width:1px,color:#fff;
    classDef decision fill:#1e1b4b,stroke:#6366f1,stroke-width:2px,color:#fff;
    classDef success fill:#064e3b,stroke:#10b981,stroke-width:2px,color:#fff;
    
    Start([1. Validator Unggah Berkas]) --> Temp[2. Simpan di Hosting Lokal Sementara]:::process
    Temp --> CheckPDF{3. Apakah File PDF?}:::decision
    
    CheckPDF -- Tidak -- > Convert[4. Konversi ke PDF & Rename:<br/><b>jenis_noanggota_nama.pdf</b>]:::process
    CheckPDF -- Ya --> Rename[5. Ganti Nama File:<br/><b>jenis_noanggota_nama.pdf</b>]:::process
    
    Convert --> DriveCheck{6. Cek Folder KSP di Drive?}:::decision
    Rename --> DriveCheck
    
    DriveCheck -- Belum Ada --> CreateRoot[7. Buat Folder Utama 'KSP']:::process
    DriveCheck -- Sudah Ada --> MemberCheck{8. Cek Folder Anggota:<br/><b>A0001_NamaAnggota</b>?}:::decision
    
    CreateRoot --> MemberCheck
    
    MemberCheck -- Belum Ada --> CreateMember[9. Buat Folder:<br/><b>A0001_NamaAnggota</b>]:::process
    MemberCheck -- Sudah Ada --> RouteCheck{10. Jenis Berkas?}:::decision
    
    CreateMember --> RouteCheck
    
    RouteCheck -- KTP / KK --> CheckProfile{11. Cek Folder 'profil'?}:::decision
    RouteCheck -- Form / Surat --> CheckLoan{12. Cek Folder 'pinjaman'?}:::decision
    
    CheckProfile -- Belum Ada --> CreateProfile[13. Buat Folder 'profil']:::process
    CheckProfile -- Sudah Ada --> UploadProfile[14. Upload File ke 'profil']:::process
    CreateProfile --> UploadProfile
    
    CheckLoan -- Belum Ada --> CreateLoan[15. Buat Folder 'pinjaman']:::process
    CheckLoan -- Sudah Ada --> UploadLoan[16. Upload File ke 'pinjaman']:::process
    CreateLoan --> UploadLoan
    
    UploadProfile --> SaveDB[17. Simpan File ID Drive ke Database]:::process
    UploadLoan --> SaveDB
    
    SaveDB --> Cleanup[18. Hapus File Sementara di Hosting]:::process
    Cleanup --> Finish([19. Sukses & Tampilkan Notifikasi]):::success

    class Start,Finish startEnd;
```

---

## 💻 3. Blueprint Implementasi Teknis (PHP & Google Drive SDK)

Untuk mempermudah integrasi, berikut adalah contoh struktur kode PHP menggunakan Google API Client Library untuk pembuatan folder bertingkat dan pengunggahan berkas:

### A. Setup Google Client & Service Account
```php
use Google\Client;
use Google\Service\Drive;

class GoogleDriveService {
    private $service;

    public function __construct() {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-credentials.json'));
        $client->addScope(Drive::DRIVE_FILE);
        $this->service = new Drive($client);
    }

    // Mendapatkan atau Membuat Folder di Drive
    public function getOrCreateFolder($folderName, $parentFolderId = null) {
        $query = "name = '$folderName' and mimeType = 'application/vnd.google-apps.folder' and trashed = false";
        if ($parentFolderId) {
            $query .= " and '$parentFolderId' in parents";
        }

        $results = $this->service->files->listFiles([
            'q' => $query,
            'fields' => 'files(id, name)'
        ]);

        if (count($results->getFiles()) > 0) {
            return $results->getFiles()[0]->getId();
        }

        // Jika tidak ada, buat folder baru
        $fileMetadata = new Drive\DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);
        if ($parentFolderId) {
            $fileMetadata->setParents([$parentFolderId]);
        }

        $folder = $this->service->files->create($fileMetadata, ['fields' => 'id']);
        return $folder->id;
    }

    // Mengunggah Berkas Fisik ke Folder Tertentu
    public function uploadFile($filePath, $fileName, $parentFolderId) {
        $fileMetadata = new Drive\DriveFile([
            'name' => $fileName,
            'parents' => [$parentFolderId]
        ]);

        $content = file_get_contents($filePath);
        $file = $this->service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/pdf',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return $file->id; // Mengembalikan ID Berkas di Google Drive
    }
}
```

### B. Controller Logika Konversi & Routing Berkas
```php
class AnggotaController {
    public function uploadDokumen($id, Request $request) {
        $anggota = Anggota::find($id);
        $noAnggota = $anggota->no_anggota; // e.g. "A0001"
        $namaAnggota = str_replace(' ', '_', strtolower($anggota->nama)); // e.g. "budi_santoso"
        $jenisDokumen = $request->input('jenis_dokumen'); // "ktp", "kk", "pengajuan", "perjanjian"
        
        $uploadedFile = $_FILES['berkas'];
        $tempPath = $uploadedFile['tmp_name'];
        $ext = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));

        // Tentukan Nama Baru
        $newFileName = "{$jenisDokumen}_{$noAnggota}_{$namaAnggota}.pdf";
        $finalLocalPath = "public/uploads/temp/" . $newFileName;

        // 1. Konversi ke PDF jika berupa Gambar
        if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
            $this->convertImageToPDF($tempPath, $finalLocalPath);
        } else {
            move_uploaded_file($tempPath, $finalLocalPath);
        }

        // 2. Inisialisasi Google Drive
        $drive = new GoogleDriveService();
        
        // Cek/Buat Folder Root KSP
        $rootId = $drive->getOrCreateFolder('KSP');

        // Cek/Buat Folder Anggota: A0001_Budi_Santoso
        $folderNameAnggota = "{$noAnggota}_{$anggota->nama}";
        $anggotaFolderId = $drive->getOrCreateFolder($folderNameAnggota, $rootId);

        // 3. Routing Subfolder berdasarkan Jenis Dokumen
        if (in_array($jenisDokumen, ['ktp', 'kk'])) {
            $subFolderId = $drive->getOrCreateFolder('profil', $anggotaFolderId);
        } else {
            $subFolderId = $drive->getOrCreateFolder('pinjaman', $anggotaFolderId);
        }

        // 4. Upload ke Google Drive
        $driveFileId = $drive->uploadFile($finalLocalPath, $newFileName, $subFolderId);

        // 5. Simpan ID Drive ke Database
        AnggotaDokumen::create([
            'anggota_id' => $anggota->id,
            'jenis_dokumen' => $jenisDokumen,
            'nama_file' => $newFileName,
            'drive_file_id' => $driveFileId // ID Referensi untuk download/preview dari Drive
        ]);

        // 6. Bersihkan hosting lokal dari file temp
        unlink($finalLocalPath);

        return redirect()->back()->with('success', 'Berkas berhasil dikonversi dan disimpan ke Google Drive!');
    }

    private function convertImageToPDF($sourceImagePath, $outputPDFPath) {
        // Implementasi konversi menggunakan library FPDF/FPDI atau Dompdf
        // Contoh konsep dasar:
        // $pdf = new FPDF();
        // $pdf->AddPage();
        // $pdf->Image($sourceImagePath, 10, 10, 190);
        // $pdf->Output('F', $outputPDFPath);
    }
}
```

---

## 💎 Keuntungan Arsitektur Ini
1. **Menghemat Penyimpanan Server:** Hosting lokal tetap ringan karena file fisik langsung dihapus setelah berhasil dipindahkan ke Google Drive.
2. **Kerapian Data:** File dikelompokkan per anggota dengan struktur subfolder `profil` dan `pinjaman` yang intuitif.
3. **Format Standar (PDF):** Menghindari masalah kompatibilitas format gambar saat pratinjau dokumen di browser.
4. **Keamanan Ekstra:** Menggunakan ID Google Drive tepercaya alih-alih mengekspose URL file fisik server.
