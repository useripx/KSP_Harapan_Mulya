<?php
/**
 * AnggotaController
 */

require_once APP_PATH . '/models/Anggota.php';

class AnggotaController extends Controller
{
    private $anggotaModel;

    public function __construct()
    {
        parent::__construct();
        Auth::requireLogin();
        $this->anggotaModel = new Anggota();
    }

    public function index()
    {
        $anggota = $this->anggotaModel->getAllWithUser();
        $this->view('anggota/index', [
            'pageTitle' => 'Manajemen Anggota',
            'anggota' => $anggota,
            'userRole' => Auth::role()
        ]);
    }

    public function create()
    {
        $this->view('anggota/create', [
            'pageTitle' => 'Tambah Anggota Baru'
        ]);
    }

    public function store()
    {
        if (!$this->isPost())
            $this->redirect('/anggota');

        $data = $this->post();
        
        // Generate Nomor Anggota berdasarkan nama
        if (isset($data['nama'])) {
            $data['no_anggota'] = $this->anggotaModel->generateNoAnggota($data['nama']);
        }
        
        // Set otomatis username menggunakan Nomor Anggota
        $data['username'] = $data['no_anggota'] ?? '';
        
        $errors = $this->validate($data, [
            'nama' => 'required',
            'tipe' => 'required',
            'tgl_daftar' => 'required'
        ]);

        require_once APP_PATH . '/models/User.php';
        $userModel = new User();

        if (empty($errors)) {
            if ($userModel->usernameExists($data['username'])) {
                $errors['username'] = 'Gagal: Nomor Anggota ini (' . $data['username'] . ') sudah digunakan sebagai akun user di sistem.';
            }
        }

        if (!empty($errors)) {
            View::setErrors($errors);
            View::setOld($data);
            $this->redirect('/anggota/create', 'Harap perbaiki kesalahan pada form.', 'error');
        }

        try {
            $this->anggotaModel->beginTransaction();

            // 1. Buat Akun User (Password default mengikuti no_anggota yang sudah valid)
            $userId = $userModel->createUser([
                'name' => $data['nama'],
                'username' => $data['username'],
                'password' => $data['no_anggota'],
                'email' => strtolower(str_replace(' ', '', $data['username'])) . '@ksp.local',
                'role' => 'ANGGOTA',
                'is_active' => 1
            ]);

            // 2. Buat Data Anggota
            $this->anggotaModel->insert([
                'user_id' => $userId,
                'no_anggota' => $data['no_anggota'],
                'nama' => $data['nama'],
                'tipe' => $data['tipe'],
                'identitas_no' => $data['identitas_no'],
                'prodi_unit' => $data['prodi_unit'],
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
                'tgl_daftar' => $data['tgl_daftar'],
                'status' => 'AKTIF'
            ]);

            $this->anggotaModel->commit();
            $this->redirect('/anggota', 'Anggota dan Akun berhasil ditambahkan.', 'success');
        } catch (Exception $e) {
            $this->anggotaModel->rollback();
            $this->redirect('/anggota/create', 'Gagal menambahkan anggota: ' . $e->getMessage(), 'error');
        }
    }

    public function detail($id)
    {
        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            $this->redirect('/anggota', 'Anggota tidak ditemukan', 'error');
        }

        require_once APP_PATH . '/services/SimpananService.php';
        $simpananService = new SimpananService();
        $saldo = $simpananService->getSaldo($id);

        $db = db();
        $stmt = $db->prepare("SELECT COALESCE(SUM(pokok), 0) FROM pinjaman WHERE anggota_id = ? AND status IN ('DISETUJUI', 'DICAIRKAN', 'BERJALAN', 'LUNAS')");
        $stmt->execute([$id]);
        $totalPinjaman = $stmt->fetchColumn();

        // Ambil data dokumen agar muncul di view detail
        $stmtDokumen = $db->prepare("SELECT jenis_dokumen, nama_file FROM anggota_dokumen WHERE anggota_id = ?");
        $stmtDokumen->execute([$id]);
        $listDokumen = $stmtDokumen->fetchAll(PDO::FETCH_KEY_PAIR);

        // Kalkulasi Simpanan Sukarela Saat Ini
        $tahun = (int)date('Y');
        $bulan = (int)date('m');
        $tglDaftar = strtotime($anggota['tgl_daftar']);
        $tahunDaftar = (int)date('Y', $tglDaftar);
        $bulanDaftar = (int)date('m', $tglDaftar);
        $monthsActive = max((($tahun - $tahunDaftar) * 12) + ($bulan - $bulanDaftar) + 1, 1);
        $sukarelaDasar = 65000;

        $stmtKonf = $db->prepare("SELECT simpanan_sukarela_tambahan FROM konfigurasi_simpanan_anggota WHERE anggota_id = ?");
        $stmtKonf->execute([$id]);
        $konf = $stmtKonf->fetch();
        $sukarelaTambahan = $konf ? (float)$konf['simpanan_sukarela_tambahan'] : 0.0;

        $simpanan_sukarela_saat_ini = $sukarelaDasar + $sukarelaTambahan;

        $this->view('anggota/detail', [
            'pageTitle' => 'Detail Anggota',
            'anggota' => $anggota,
            'saldo' => $saldo,
            'totalPinjaman' => $totalPinjaman,
            'listDokumen' => $listDokumen,
            'simpanan_sukarela_saat_ini' => $simpanan_sukarela_saat_ini
        ]);
    }

    public function edit($id)
    {
        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            $this->redirect('/anggota', 'Anggota tidak ditemukan', 'error');
        }

        // Ambil data dokumen agar form upload tahu mana file yang sudah diisi/belum
        $db = db();
        $stmtDokumen = $db->prepare("SELECT jenis_dokumen, nama_file FROM anggota_dokumen WHERE anggota_id = ?");
        $stmtDokumen->execute([$id]);
        $listDokumen = $stmtDokumen->fetchAll(PDO::FETCH_KEY_PAIR);

        $this->view('anggota/edit', [
            'pageTitle' => 'Edit Anggota',
            'anggota' => $anggota,
            'listDokumen' => $listDokumen
        ]);
    }

    public function update($id)
    {
        if (!$this->isPost())
            $this->redirect('/anggota');

        $data = $this->post();
        $errors = $this->validate($data, [
            'nama' => 'required',
            'tipe' => 'required',
            'tgl_daftar' => 'required',
            'status' => 'required'
        ]);

        if (!empty($errors)) {
            View::setErrors($errors);
            View::setOld($data);
            $this->redirect("/anggota/{$id}/edit", 'Harap perbaiki kesalahan pada form.', 'error');
        }

        try {
            $this->anggotaModel->update($id, [
                'nama' => $data['nama'],
                'tipe' => $data['tipe'],
                'identitas_no' => $data['identitas_no'],
                'prodi_unit' => $data['prodi_unit'],
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
                'tgl_daftar' => $data['tgl_daftar'],
                'status' => $data['status']
            ]);

            $this->redirect('/anggota', 'Anggota berhasil diperbarui.', 'success');
        } catch (Exception $e) {
            $this->redirect("/anggota/{$id}/edit", 'Gagal memperbarui anggota: ' . $e->getMessage(), 'error');
        }
    }

    public function delete($id)
    {
        if (!$this->isPost())
            $this->redirect('/anggota');

        try {
            $db = db();
            // 1. Ambil semua berkas anggota dari Google Drive sebelum menghapus record anggota
            $stmtDocs = $db->prepare("SELECT drive_file_id, nama_file FROM anggota_dokumen WHERE anggota_id = ?");
            $stmtDocs->execute([$id]);
            $docs = $stmtDocs->fetchAll();

            if (count($docs) > 0) {
                try {
                    require_once APP_PATH . '/services/GoogleDriveService.php';
                    $drive = new GoogleDriveService();
                    foreach ($docs as $doc) {
                        if (!empty($doc['drive_file_id'])) {
                            $drive->deleteFile($doc['drive_file_id']);
                        }
                        // Hapus file fisik lokal jika tertinggal
                        $filePath = APP_PATH . '/../public/uploads/dokumen/' . $doc['nama_file'];
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                } catch (Exception $ex) {
                    error_log("Gagal menghapus berkas Google Drive saat menghapus anggota ID {$id}: " . $ex->getMessage());
                }
            }

            // 2. Hapus data anggota (cascade secara DDL akan menghapus baris anggota_dokumen)
            $this->anggotaModel->delete($id);
            $this->redirect('/anggota', 'Anggota dan berkas kelengkapannya berhasil dihapus.', 'success');
        } catch (Exception $e) {
            $this->redirect('/anggota', 'Gagal menghapus anggota: ' . $e->getMessage(), 'error');
        }
    }

    public function lihatDokumen($id, $jenisDokumen) {
        $anggota = $this->anggotaModel->find($id);
        
        if (!$anggota) {
            $this->redirect('/anggota', 'Anggota tidak ditemukan', 'error');
        }

        // Ambil data file & ID Drive dari tabel anggota_dokumen
        $db = db();
        $stmt = $db->prepare("SELECT nama_file, drive_file_id FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
        $stmt->execute([$id, $jenisDokumen]);
        $doc = $stmt->fetch();

        $namaFile = $doc ? $doc['nama_file'] : '';
        $driveFileId = $doc ? $doc['drive_file_id'] : '';

        // Set Label untuk halaman preview
        $labelDokumen = 'Dokumen';
        if ($jenisDokumen === 'ktp') $labelDokumen = 'KTP Anggota';
        if ($jenisDokumen === 'kk') $labelDokumen = 'Kartu Keluarga';
        if ($jenisDokumen === 'perjanjian') $labelDokumen = 'Surat Perjanjian';
        if ($jenisDokumen === 'pengajuan') $labelDokumen = 'Form Pengajuan';

        return $this->view('anggota/view_dokumen', [
            'pageTitle' => 'Lihat ' . $labelDokumen,
            'anggota' => $anggota,
            'namaFile' => $namaFile,
            'driveFileId' => $driveFileId,
            'labelDokumen' => $labelDokumen
        ]);
    }

    // METHOD UNTUK MEMPROSES UPLOAD DOKUMEN BARU (DARI HALAMAN EDIT DENGAN CONVERT PDF & GOOGLE DRIVE)
    public function uploadDokumen($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect("/anggota/{$id}/edit");
        }

        $jenisDokumen = $_POST['jenis_dokumen'] ?? '';
        
        if (!isset($_FILES['berkas_dokumen']) || $_FILES['berkas_dokumen']['error'] !== UPLOAD_ERR_OK) {
            $this->redirect("/anggota/{$id}/edit", 'Gagal: Berkas dokumen tidak valid.', 'error');
        }

        $fileTmpPath = $_FILES['berkas_dokumen']['tmp_name'];
        $fileName = $_FILES['berkas_dokumen']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            $this->redirect("/anggota/{$id}/edit", 'Gagal: Format harus JPG, PNG, atau PDF.', 'error');
        }

        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            $this->redirect('/anggota', 'Anggota tidak ditemukan', 'error');
        }

        // Standardisasi nama berkas: jenis_noanggota_namaanggota.pdf (tanpa spasi, huruf kecil semua)
        $noAnggotaClean = str_replace(' ', '_', strtolower($anggota['no_anggota']));
        $namaClean = str_replace(' ', '_', strtolower($anggota['nama']));
        $newFileName = "{$jenisDokumen}_{$noAnggotaClean}_{$namaClean}.pdf";

        // Tentukan direktori sementara lokal
        $tempDir = APP_PATH . '/../public/uploads/temp/';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $finalLocalPath = $tempDir . $newFileName;

        try {
            // 1. Konversi jika berupa gambar
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                $this->convertImageToPDF($fileTmpPath, $finalLocalPath, $fileExtension);
            } else {
                if (!move_uploaded_file($fileTmpPath, $finalLocalPath)) {
                    throw new Exception("Gagal memindahkan berkas unggahan ke direktori sementara lokal.");
                }
            }

            $driveUploaded = false;
            $driveFileId = null;

            try {
                // 2. Hubungkan ke Google Drive API
                require_once APP_PATH . '/services/GoogleDriveService.php';
                $drive = new GoogleDriveService();

                // Cek/buat folder utama 'KSP'
                $rootId = $drive->getOrCreateFolder('KSP');

                // Cek/buat folder Anggota: noanggota_nama
                $folderNameAnggota = "{$anggota['no_anggota']}_{$anggota['nama']}";
                $anggotaFolderId = $drive->getOrCreateFolder($folderNameAnggota, $rootId);

                // Tentukan Subfolder berdasarkan jenis dokumen
                if (in_array($jenisDokumen, ['ktp', 'kk'])) {
                    $subFolderId = $drive->getOrCreateFolder('profil', $anggotaFolderId);
                } else {
                    $subFolderId = $drive->getOrCreateFolder('pinjaman', $anggotaFolderId);
                }

                $db = db();
                // Cek apakah dokumen jenis ini sudah ada untuk mengarsipkannya ke KSP_Trash di Google Drive
                $stmtExist = $db->prepare("SELECT drive_file_id, nama_file FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
                $stmtExist->execute([$id, $jenisDokumen]);
                $oldDoc = $stmtExist->fetch(PDO::FETCH_ASSOC);

                if ($oldDoc) {
                    $waktuHapus = date('d-m-Y_H-i');
                    $archiveFolderName = "{$anggota['no_anggota']}_{$anggota['nama']}";
                    $subFolder = in_array($jenisDokumen, ['ktp', 'kk']) ? 'profil' : 'pinjaman';

                    if (!empty($oldDoc['drive_file_id'])) {
                        $drive->archiveFile($oldDoc['drive_file_id'], $archiveFolderName, $subFolder);
                    }
                    if (!empty($oldDoc['nama_file'])) {
                        $oldLocalPath = APP_PATH . '/../public/uploads/dokumen/' . $oldDoc['nama_file'];
                        if (file_exists($oldLocalPath)) {
                            $localTrashDir = APP_PATH . '/../public/uploads/KSP_Trash/' . $archiveFolderName . '/' . $subFolder . '/';
                            if (!is_dir($localTrashDir)) {
                                mkdir($localTrashDir, 0755, true);
                            }
                            $originalName = $oldDoc['nama_file'];
                            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                            $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                            $newArchivedName = "{$filenameWithoutExt}_{$waktuHapus}.{$ext}";
                            rename($oldLocalPath, $localTrashDir . $newArchivedName);
                        }
                    }
                    // Hapus record lama
                    $stmtDel = $db->prepare("DELETE FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
                    $stmtDel->execute([$id, $jenisDokumen]);
                }

                // 3. Unggah Berkas PDF Baru ke Google Drive
                $driveFileId = $drive->uploadFile($finalLocalPath, $newFileName, $subFolderId);
                $driveUploaded = true;

            } catch (Exception $driveEx) {
                // Catat log error Google Drive
                error_log("Google Drive upload failed, falling back to local storage: " . $driveEx->getMessage());
                $driveUploaded = false;
                $driveFileId = null;
            }

            $db = db();
            if ($driveUploaded) {
                // 4. Simpan Referensi ke Database
                $stmtInsert = $db->prepare("INSERT INTO anggota_dokumen (anggota_id, jenis_dokumen, nama_file, drive_file_id) VALUES (?, ?, ?, ?)");
                $stmtInsert->execute([$id, $jenisDokumen, $newFileName, $driveFileId]);

                // 5. Bersihkan Berkas Fisik Lokal di Server
                if (file_exists($finalLocalPath)) {
                    unlink($finalLocalPath);
                }

                $this->redirect("/anggota/{$id}/edit", 'Dokumen kelengkapan berhasil diunggah dan disimpan ke Google Drive!', 'success');
            } else {
                // LOCAL FALLBACK
                $destDir = APP_PATH . '/../public/uploads/dokumen/';
                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }
                $finalDestPath = $destDir . $newFileName;

                // Pastikan untuk mengarsipkan file lama jika ada di DB lokal
                $stmtExist = $db->prepare("SELECT nama_file, drive_file_id FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
                $stmtExist->execute([$id, $jenisDokumen]);
                $oldDoc = $stmtExist->fetch(PDO::FETCH_ASSOC);

                if ($oldDoc) {
                    $waktuHapus = date('d-m-Y_H-i');
                    $archiveFolderName = "{$anggota['no_anggota']}_{$anggota['nama']}";
                    $subFolder = in_array($jenisDokumen, ['ktp', 'kk']) ? 'profil' : 'pinjaman';

                    if (!empty($oldDoc['nama_file'])) {
                        $oldLocalPath = $destDir . $oldDoc['nama_file'];
                        if (file_exists($oldLocalPath)) {
                            $localTrashDir = APP_PATH . '/../public/uploads/KSP_Trash/' . $archiveFolderName . '/' . $subFolder . '/';
                            if (!is_dir($localTrashDir)) {
                                mkdir($localTrashDir, 0755, true);
                            }
                            $originalName = $oldDoc['nama_file'];
                            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                            $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                            $newArchivedName = "{$filenameWithoutExt}_{$waktuHapus}.{$ext}";
                            rename($oldLocalPath, $localTrashDir . $newArchivedName);
                        }
                    }
                    if (!empty($oldDoc['drive_file_id'])) {
                        try {
                            require_once APP_PATH . '/services/GoogleDriveService.php';
                            $drive = new GoogleDriveService();
                            $drive->archiveFile($oldDoc['drive_file_id'], $archiveFolderName, $subFolder);
                        } catch (Exception $e) {
                            // Abaikan error Google Drive saat fallback
                        }
                    }
                    // Hapus record lama
                    $stmtDel = $db->prepare("DELETE FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
                    $stmtDel->execute([$id, $jenisDokumen]);
                }

                // Pindahkan file dari temp ke folder dokumen permanen
                if (!rename($finalLocalPath, $finalDestPath)) {
                    if (copy($finalLocalPath, $finalDestPath)) {
                        unlink($finalLocalPath);
                    } else {
                        throw new Exception("Gagal memindahkan file ke penyimpanan lokal permanen.");
                    }
                }

                // Simpan Referensi ke Database dengan drive_file_id = NULL
                $stmtInsert = $db->prepare("INSERT INTO anggota_dokumen (anggota_id, jenis_dokumen, nama_file, drive_file_id) VALUES (?, ?, ?, NULL)");
                $stmtInsert->execute([$id, $jenisDokumen, $newFileName]);

                $this->redirect("/anggota/{$id}/edit", 'Dokumen berhasil disimpan secara lokal (Penyimpanan Google Drive penuh/tidak tersedia).', 'success');
            }

        } catch (Exception $e) {
            // Bersihkan jika ada berkas yang tersisa saat terjadi error
            if (file_exists($finalLocalPath)) {
                unlink($finalLocalPath);
            }
            $this->redirect("/anggota/{$id}/edit", 'Gagal memproses berkas: ' . $e->getMessage(), 'error');
        }
    }

    /**
     * Konversi Gambar ke berkas PDF secara proporsional menggunakan FPDF
     */
    private function convertImageToPDF($sourceImagePath, $outputPDFPath, $imageType) {
        if (!class_exists('FPDF')) {
            if (class_exists('Fpdf\\Fpdf')) {
                class_alias('Fpdf\\Fpdf', 'FPDF');
            } else {
                $fallbackPath = APP_PATH . '/../vendor/fpdf/fpdf/fpdf.php';
                if (file_exists($fallbackPath)) {
                    require_once $fallbackPath;
                } else {
                    // Try to load modern composer path if composer autoloader hasn't fired it
                    $modernPath = APP_PATH . '/../vendor/fpdf/fpdf/src/Fpdf/Fpdf.php';
                    if (file_exists($modernPath)) {
                        require_once $modernPath;
                        class_alias('Fpdf\\Fpdf', 'FPDF');
                    } else {
                        throw new Exception("Pustaka FPDF tidak ditemukan. Silakan jalankan 'composer require fpdf/fpdf' di terminal Laragon Anda.");
                    }
                }
            }
        }

        $pdf = new FPDF();
        $pdf->AddPage();
        
        $size = getimagesize($sourceImagePath);
        if ($size === false) {
            throw new Exception("Gagal membaca dimensi gambar sumber.");
        }
        $originalWidth = $size[0];
        $originalHeight = $size[1];
        
        // Lebar halaman A4 efektif = 190mm (210mm - 20mm margin)
        // Tinggi halaman A4 efektif = 277mm (297mm - 20mm margin)
        $targetWidth = 190;
        $targetHeight = ($originalHeight / $originalWidth) * $targetWidth;
        
        if ($targetHeight > 277) {
            $targetHeight = 277;
            $targetWidth = ($originalWidth / $originalHeight) * $targetHeight;
        }

        // Render di tengah halaman secara horizontal
        $x = 10 + (190 - $targetWidth) / 2;
        $y = 10;

        // FPDF requires image format type if the file extension is not known (like .tmp)
        $type = strtoupper($imageType);
        if ($type === 'JPG') {
            $type = 'JPEG';
        }

        $pdf->Image($sourceImagePath, $x, $y, $targetWidth, $targetHeight, $type);
        $pdf->Output('F', $outputPDFPath);
    }

    /**
     * API: Search members by name or number
     */
    public function search() {
        $q = $_GET['q'] ?? '';
        $db = db();
        
        // Mencari anggota aktif berdasarkan nama, nomor identitas, atau nomor anggota (ID)
        $stmt = $db->prepare("SELECT id as anggota_id, user_id, nama, no_anggota, identitas_no 
                            FROM anggota 
                            WHERE status = 'AKTIF' 
                            AND (nama LIKE ? OR identitas_no LIKE ? OR no_anggota LIKE ?) 
                            LIMIT 10");
        
        $searchTerm = "%$q%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }

    public function search_ajax() {
        $q = $_GET['q'] ?? '';
        $db = db();
        // Query hanya mengambil anggota AKTIF
        $stmt = $db->prepare("SELECT user_id, nama FROM anggota WHERE status = 'AKTIF' AND nama LIKE ? LIMIT 5");
        $stmt->execute(["%$q%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }

    /**
     * API: Get member saldo
     */
    public function getSaldo($id)
    {
        require_once APP_PATH . '/models/SimpananTransaksi.php';
        $simpananModel = new SimpananTransaksi();
        $saldo = $simpananModel->getSaldo($id);
        
        return $this->json([
            'anggota_id' => $id,
            'saldo' => $saldo,
            'saldo_formatted' => formatRupiah($saldo)
        ]);
    }
    
    // METHOD UNTUK MENGHAPUS DOKUMEN DAN SINKRONISASI DENGAN GOOGLE DRIVE (PENGARSIPAN KSP_Trash)
    public function deleteDokumen($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect("/anggota/{$id}/edit");
        }

        $jenisDokumen = $_POST['jenis_dokumen'] ?? '';

        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            $this->redirect('/anggota', 'Anggota tidak ditemukan', 'error');
        }

        try {
            $db = db();
            // 1. Cari record berkas di database
            $stmt = $db->prepare("SELECT nama_file, drive_file_id FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
            $stmt->execute([$id, $jenisDokumen]);
            $doc = $stmt->fetch();

            if ($doc) {
                $waktuHapus = date('d-m-Y_H-i');
                $archiveFolderName = "{$anggota['no_anggota']}_{$anggota['nama']}";
                $subFolder = in_array($jenisDokumen, ['ktp', 'kk']) ? 'profil' : 'pinjaman';

                // 2. Arsipkan berkas dari Google Drive jika drive_file_id tersedia
                if (!empty($doc['drive_file_id'])) {
                    require_once APP_PATH . '/services/GoogleDriveService.php';
                    $drive = new GoogleDriveService();
                    $drive->archiveFile($doc['drive_file_id'], $archiveFolderName, $subFolder);
                }

                // Arsipkan berkas fisik lokal ke KSP_Trash jika ada/tertinggal
                $filePath = APP_PATH . '/../public/uploads/dokumen/' . $doc['nama_file'];
                if (file_exists($filePath)) {
                    $localTrashDir = APP_PATH . '/../public/uploads/KSP_Trash/' . $archiveFolderName . '/' . $subFolder . '/';
                    if (!is_dir($localTrashDir)) {
                        mkdir($localTrashDir, 0755, true);
                    }
                    $originalName = $doc['nama_file'];
                    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                    $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                    $newArchivedName = "{$filenameWithoutExt}_{$waktuHapus}.{$ext}";
                    rename($filePath, $localTrashDir . $newArchivedName);
                }

                // 3. Hapus baris data rekaman dari tabel database
                $stmtDelete = $db->prepare("DELETE FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
                $stmtDelete->execute([$id, $jenisDokumen]);

                $this->redirect("/anggota/{$id}/edit", 'Dokumen telah diarsipkan anda bisa cek di Drive anda.', 'success');
            } else {
                $this->redirect("/anggota/{$id}/edit", 'Gagal: Data dokumen tidak ditemukan.', 'error');
            }
        } catch (Exception $e) {
            $this->redirect("/anggota/{$id}/edit", 'Terjadi kesalahan saat mengarsipkan berkas: ' . $e->getMessage(), 'error');
        }
    }
}
