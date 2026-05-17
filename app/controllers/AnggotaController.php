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

        $this->view('anggota/detail', [
            'pageTitle' => 'Detail Anggota',
            'anggota' => $anggota,
            'saldo' => $saldo,
            'totalPinjaman' => $totalPinjaman,
            'listDokumen' => $listDokumen
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
            $this->anggotaModel->delete($id);
            $this->redirect('/anggota', 'Anggota berhasil dihapus.', 'success');
        } catch (Exception $e) {
            $this->redirect('/anggota', 'Gagal menghapus anggota: ' . $e->getMessage(), 'error');
        }
    }

    public function lihatDokumen($id, $jenisDokumen) {
        $anggota = $this->anggotaModel->find($id);
        
        if (!$anggota) {
            $this->redirect('/anggota', 'Anggota tidak ditemukan', 'error');
        }

        // Ambil data file dari tabel anggota_dokumen
        $db = db();
        $stmt = $db->prepare("SELECT nama_file FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
        $stmt->execute([$id, $jenisDokumen]);
        $namaFile = $stmt->fetchColumn(); // Mengambil string nama file langsung

        // Set Label untuk halaman preview
        $labelDokumen = 'Dokumen';
        if ($jenisDokumen === 'ktp') $labelDokumen = 'KTP Anggota';
        if ($jenisDokumen === 'perjanjian') $labelDokumen = 'Surat Perjanjian';
        if ($jenisDokumen === 'pengajuan') $labelDokumen = 'Form Pengajuan';

        return $this->view('anggota/view_dokumen', [
            'pageTitle' => 'Lihat ' . $labelDokumen,
            'anggota' => $anggota,
            'namaFile' => $namaFile ? $namaFile : '', // Jika false/kosong ganti string kosong
            'labelDokumen' => $labelDokumen
        ]);
    }

    // METHOD UNTUK MEMPROSES UPLOAD DOKUMEN BARU (DARI HALAMAN EDIT)
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

        $cleanNoAnggota = str_replace(' ', '_', $anggota['no_anggota']);
        $newFileName = $jenisDokumen . '_' . $cleanNoAnggota . '_' . time() . '.' . $fileExtension;

        $uploadFileDir = APP_PATH . '/../public/uploads/dokumen/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        if (move_uploaded_file($fileTmpPath, $uploadFileDir . $newFileName)) {
            $db = db();
            $stmt = $db->prepare("INSERT INTO anggota_dokumen (anggota_id, jenis_dokumen, nama_file) VALUES (?, ?, ?)");
            $stmt->execute([$id, $jenisDokumen, $newFileName]);

            $this->redirect("/anggota/{$id}/edit", 'Dokumen berhasil diunggah.', 'success');
        } else {
            $this->redirect("/anggota/{$id}/edit", 'Gagal menyimpan berkas ke server.', 'error');
        }
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
    
    // METHOD UNTUK MENGHAPUS DOKUMEN DAN FILE FISIKNYA
    public function deleteDokumen($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect("/anggota/{$id}/edit");
        }

        $jenisDokumen = $_POST['jenis_dokumen'] ?? '';

        $db = db();
        // 1. Cari nama file di database terlebih dahulu sebelum dihapus
        $stmt = $db->prepare("SELECT nama_file FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
        $stmt->execute([$id, $jenisDokumen]);
        $namaFile = $stmt->fetchColumn();

        if ($namaFile) {
            // 2. Hapus file fisik dari folder penyimpanan server (public/uploads/dokumen/)
            $filePath = APP_PATH . '/../public/uploads/dokumen/' . $namaFile;
            if (file_exists($filePath)) {
                unlink($filePath); // Menghapus file asli secara permanen
            }

            // 3. Hapus baris data rekaman dari tabel database
            $stmtDelete = $db->prepare("DELETE FROM anggota_dokumen WHERE anggota_id = ? AND jenis_dokumen = ?");
            $stmtDelete->execute([$id, $jenisDokumen]);

            $this->redirect("/anggota/{$id}/edit", 'Dokumen kelengkapan berhasil dihapus.', 'success');
        } else {
            $this->redirect("/anggota/{$id}/edit", 'Gagal: Data dokumen tidak ditemukan.', 'error');
        }
    }
}
