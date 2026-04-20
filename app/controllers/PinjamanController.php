<?php
/**
 * PinjamanController
 */

class PinjamanController extends Controller
{
    private $pinjamanModel;

    public function __construct()
    {
        parent::__construct();
        Auth::requireLogin();
        require_once APP_PATH . '/models/Pinjaman.php';
        $this->pinjamanModel = new Pinjaman();
    }

    public function index()
    {
        $db = db();
        $userRole = Auth::role();
        $userId = Auth::id();

        $sql = "SELECT p.*, a.nama, a.no_anggota 
                FROM pinjaman p
                JOIN anggota a ON p.anggota_id = a.id";

        if ($userRole === ROLE_ANGGOTA) {
            $sql .= " WHERE a.user_id = " . (int) $userId;
        }

        $sql .= " ORDER BY p.created_at DESC";

        $pinjaman = $db->query($sql)->fetchAll();

        $this->view('pinjaman/index', [
            'pageTitle' => 'Daftar Pinjaman',
            'pinjaman' => $pinjaman
        ]);
    }

    public function detail($id)
    {
        $pinjaman = $this->pinjamanModel->findWithAnggota($id);
        
        if (!$pinjaman) {
            $this->redirect('/pinjaman', 'Data pinjaman tidak ditemukan.', 'error');
        }

        // Security check for members
        if (Auth::role() === ROLE_ANGGOTA) {
            $db = db();
            $stmt = $db->prepare("SELECT user_id FROM anggota WHERE id = ?");
            $stmt->execute([$pinjaman['anggota_id']]);
            $member = $stmt->fetch();
            
            if ($member['user_id'] != Auth::id()) {
                $this->redirect('/pinjaman', 'Anda tidak memiliki akses ke data ini.', 'error');
            }
        }

        $jadwal = $this->pinjamanModel->getJadwal($id);
        $summary = $this->pinjamanModel->getSummary($id);

        $this->view('pinjaman/detail', [
            'pageTitle' => 'Detail Pinjaman #' . $id,
            'pinjaman' => $pinjaman,
            'jadwal' => $jadwal,
            'summary' => $summary
        ]);
    }

    public function ajukan()
    {
        $db = db();
        $anggota = [];
        if (Auth::role() !== ROLE_ANGGOTA) {
            $anggota = $db->query("SELECT * FROM anggota WHERE status = 'AKTIF' ORDER BY nama ASC")->fetchAll();
        }

        $this->view('pinjaman/ajukan', [
            'pageTitle' => 'Ajukan Pinjaman',
            'anggota' => $anggota
        ]);
    }

    public function store()
    {
        if (!$this->isPost()) $this->redirect('/pinjaman');

        $data = $this->post();
        
        // Handle anggota_id for members
        if (Auth::role() === ROLE_ANGGOTA) {
            $db = db();
            $stmt = $db->prepare("SELECT id FROM anggota WHERE user_id = ?");
            $stmt->execute([Auth::id()]);
            $member = $stmt->fetch();
            if (!$member) {
                $this->redirect('/pinjaman', 'Data anggota tidak ditemukan.', 'error');
            }
            $data['anggota_id'] = $member['id'];
        }

        $errors = $this->validate($data, [
            'anggota_id' => 'required',
            'pokok' => 'required|numeric|min_value:500000',
            'tenor_bulan' => 'required|numeric',
            'metode' => 'required',
            'tujuan' => 'required'
        ]);

        if (!empty($errors)) {
            View::setErrors($errors);
            $this->redirect('/pinjaman/ajukan', 'Harap lengkapi form dengan benar.', 'error');
        }

        try {
            // Get current setting for bunga
            $db = db();
            $setting = $db->query("SELECT bunga_pinjaman_persen_bln FROM setting_koperasi ORDER BY id DESC LIMIT 1")->fetch();
            $bunga = $setting ? $setting['bunga_pinjaman_persen_bln'] : 1.5;

            $pinjamanId = $this->pinjamanModel->insert([
                'anggota_id' => $data['anggota_id'],
                'tgl_pengajuan' => date('Y-m-d'),
                'pokok' => $data['pokok'],
                'tenor_bulan' => $data['tenor_bulan'],
                'metode' => $data['metode'],
                'bunga_persen_bln' => $bunga,
                'tujuan' => $data['tujuan'],
                'status' => 'DIAJUKAN'
            ]);

            if ($pinjamanId) {
                // Log action
                require_once APP_PATH . '/models/AuditLog.php';
                $audit = new AuditLog();
                $audit->log('PENGAJUAN_PINJAMAN', 'pinjaman', $pinjamanId, "Pengajuan pinjaman baru sebesar " . formatRupiah($data['pokok']));
                
                notifyRole([ROLE_TELLER, ROLE_ADMIN], 'warning', 'bi-file-earmark-plus', 'Pengajuan Baru', 'Terdapat pengajuan pinjaman baru sebesar ' . formatRupiah($data['pokok']), url('/pinjaman/' . $pinjamanId));
            }

            $this->redirect('/pinjaman/' . $pinjamanId, 'Pengajuan pinjaman berhasil dikirim.', 'success');
        } catch (Exception $e) {
            $this->redirect('/pinjaman/ajukan', 'Gagal mengirim pengajuan: ' . $e->getMessage(), 'error');
        }
    }

    public function verifikasi($id)
    {
        if (!in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER])) {
            $this->redirect('/pinjaman', 'Hanya Staff yang dapat melakukan verifikasi.', 'error');
        }

        $pinjaman = $this->pinjamanModel->findWithAnggota($id);
        if (!$pinjaman) $this->redirect('/pinjaman', 'Data tidak ditemukan.', 'error');
        if ($pinjaman['status'] !== 'DIAJUKAN') $this->redirect('/pinjaman/' . $id, 'Status pinjaman tidak valid untuk verifikasi.', 'error');

        $this->view('pinjaman/verifikasi', [
            'pageTitle' => 'Verifikasi Pinjaman #' . $id,
            'pinjaman' => $pinjaman
        ]);
    }

    public function prosesVerifikasi($id)
    {
        if (!$this->isPost()) $this->redirect('/pinjaman/' . $id);
        if (!in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER])) {
            $this->redirect('/pinjaman', 'Akses ditolak.', 'error');
        }

        $data = $this->post();
        
        try {
            $this->pinjamanModel->update($id, [
                'status' => 'DIVERIFIKASI',
                'verifikasi_oleh' => Auth::id(),
                'tgl_verifikasi' => date('Y-m-d H:i:s'),
                'catatan_verifikasi' => $data['catatan'] ?? ''
            ]);

            // Log action
            require_once APP_PATH . '/models/AuditLog.php';
            $audit = new AuditLog();
            $audit->log('VERIFIKASI_PINJAMAN', 'pinjaman', $id, "Pinjaman #" . $id . " telah diverifikasi.");

            // Kirim Lonceng
            notifyRole(ROLE_KETUA, 'primary', 'bi-person-check', 'Approval Menunggu', "Pinjaman #$id divalidasi Teller & butuh persetujuan Anda.", url('/pinjaman/' . $id));
            
            $pData = $this->pinjamanModel->findWithAnggota($id);
            if ($pData && !empty($pData['user_id'])) {
                sendNotifikasi($pData['user_id'], 'info', 'bi-journal-check', 'Proses Verifikasi', "Pengajuan pinjaman Anda telah divalidasi Teller dan diteruskan ke Ketua.", url('/pinjaman/' . $id));
            }

            $this->redirect('/pinjaman/' . $id, 'Pinjaman berhasil diverifikasi.', 'success');
        } catch (Exception $e) {
            $this->redirect('/pinjaman/' . $id . '/verifikasi', 'Gagal memproses verifikasi: ' . $e->getMessage(), 'error');
        }
    }

    public function approval($id)
    {
        if (Auth::role() !== ROLE_KETUA) {
            $this->redirect('/pinjaman', 'Hanya Ketua yang dapat melakukan approval.', 'error');
        }

        $pinjaman = $this->pinjamanModel->findWithAnggota($id);
        if (!$pinjaman) $this->redirect('/pinjaman', 'Data tidak ditemukan.', 'error');
        if ($pinjaman['status'] !== 'DIVERIFIKASI') $this->redirect('/pinjaman/' . $id, 'Status pinjaman tidak valid untuk approval.', 'error');

        require_once APP_PATH . '/services/CreditScoreService.php';
        $creditScore = CreditScoreService::calculateScore($pinjaman['anggota_id'], $pinjaman['pokok']);

        $this->view('pinjaman/approval', [
            'pageTitle' => 'Approval Pinjaman #' . $id,
            'pinjaman' => $pinjaman,
            'creditScore' => $creditScore
        ]);
    }

    public function approve($id)
    {
        if (!$this->isPost()) $this->redirect('/pinjaman/' . $id);
        if (Auth::role() !== ROLE_KETUA) $this->redirect('/pinjaman', 'Akses ditolak.', 'error');

        $data = $this->post();
        
        try {
            $this->pinjamanModel->update($id, [
                'status' => 'DISETUJUI',
                'approve_oleh' => Auth::id(),
                'tgl_disetujui' => date('Y-m-d H:i:s'),
                'catatan_approve' => $data['catatan'] ?? ''
            ]);

            // Log action
            require_once APP_PATH . '/models/AuditLog.php';
            $audit = new AuditLog();
            $audit->log('APPROVE_PINJAMAN', 'pinjaman', $id, "Pinjaman #" . $id . " telah disetujui.");

            $pData = $this->pinjamanModel->findWithAnggota($id);
            if ($pData && !empty($pData['user_id'])) {
                sendNotifikasi($pData['user_id'], 'success', 'bi-check-circle', 'Pinjaman Disetujui', "Pengajuan #$id disetujui. Segera datangi Teller untuk menerima dana pencairan.", url('/pinjaman/' . $id));
            }
            notifyRole([ROLE_TELLER, ROLE_ADMIN], 'success', 'bi-cash-coin', 'Siap Dicairkan', "Pinjaman #$id milik ".($pData['nama']??'Anggota')." siap dicairkan.", url('/pinjaman/' . $id));

            $this->redirect('/pinjaman/' . $id, 'Pinjaman berhasil disetujui.', 'success');
        } catch (Exception $e) {
            $this->redirect('/pinjaman/' . $id . '/approval', 'Gagal memproses approval: ' . $e->getMessage(), 'error');
        }
    }

    public function reject($id)
    {
        if (!$this->isPost()) $this->redirect('/pinjaman/' . $id);
        if (Auth::role() !== ROLE_KETUA) $this->redirect('/pinjaman', 'Akses ditolak.', 'error');

        $data = $this->post();
        
        try {
            $this->pinjamanModel->update($id, [
                'status' => 'DITOLAK',
                'approve_oleh' => Auth::id(),
                'tgl_disetujui' => date('Y-m-d H:i:s'),
                'catatan_approve' => $data['catatan'] ?? ''
            ]);

            // Log action
            require_once APP_PATH . '/models/AuditLog.php';
            $audit = new AuditLog();
            $audit->log('REJECT_PINJAMAN', 'pinjaman', $id, "Pinjaman #" . $id . " telah ditolak.");

            $pData = $this->pinjamanModel->findWithAnggota($id);
            if ($pData && !empty($pData['user_id'])) {
                sendNotifikasi($pData['user_id'], 'danger', 'bi-x-circle', 'Pinjaman Ditolak', "Mohon maaf, pengajuan #$id tidak dapat disetujui oleh Ketua.", url('/pinjaman/' . $id));
            }

            $this->redirect('/pinjaman/' . $id, 'Pinjaman telah ditolak.', 'info');
        } catch (Exception $e) {
            $this->redirect('/pinjaman/' . $id . '/approval', 'Gagal memproses penolakan: ' . $e->getMessage(), 'error');
        }
    }

    public function pencairan($id)
    {
        if (!in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER])) {
            $this->redirect('/pinjaman', 'Hanya Staff yang dapat melakukan pencairan.', 'error');
        }

        $pinjaman = $this->pinjamanModel->findWithAnggota($id);
        if (!$pinjaman) $this->redirect('/pinjaman', 'Data tidak ditemukan.', 'error');
        if ($pinjaman['status'] !== 'DISETUJUI') $this->redirect('/pinjaman/' . $id, 'Status pinjaman tidak valid untuk pencairan.', 'error');

        // Bunga flat calculation preview
        $bungaTotal = ($pinjaman['pokok'] * ($pinjaman['bunga_persen_bln'] / 100)) * $pinjaman['tenor_bulan'];
        $totalTagihan = $pinjaman['pokok'] + $bungaTotal;
        $angsuranBln = $totalTagihan / $pinjaman['tenor_bulan'];

        $this->view('pinjaman/pencairan', [
            'pageTitle' => 'Pencairan Pinjaman #' . $id,
            'pinjaman' => $pinjaman,
            'preview' => [
                'bunga_total' => $bungaTotal,
                'total_tagihan' => $totalTagihan,
                'angsuran_per_bulan' => $angsuranBln
            ]
        ]);
    }

    public function cairkan($id)
    {
        if (!$this->isPost()) $this->redirect('/pinjaman/' . $id);
        if (!in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER])) $this->redirect('/pinjaman', 'Akses ditolak.', 'error');

        $pinjaman = $this->pinjamanModel->findWithAnggota($id);
        if (!$pinjaman || $pinjaman['status'] !== 'DISETUJUI') $this->redirect('/pinjaman/' . $id, 'Status tidak valid.', 'error');

        $db = db();
        try {
            $db->beginTransaction();

            $tglCair = date('Y-m-d');
            
            // 1. Update status pinjaman
            $this->pinjamanModel->update($id, [
                'status' => 'BERJALAN',
                'tgl_cair' => $tglCair,
                'cair_oleh' => Auth::id()
            ]);

            // 2. Generate Jadwal Angsuran (Flat)
            $pokokAngsuran = $pinjaman['pokok'] / $pinjaman['tenor_bulan'];
            $bungaAngsuran = ($pinjaman['pokok'] * ($pinjaman['bunga_persen_bln'] / 100));
            $totalAngsuran = $pokokAngsuran + $bungaAngsuran;

            for ($i = 1; $i <= $pinjaman['tenor_bulan']; $i++) {
                $jatuhTempo = date('Y-m-d', strtotime("+$i month", strtotime($tglCair)));
                
                $db->prepare("INSERT INTO pinjaman_jadwal (pinjaman_id, angsuran_ke, jatuh_tempo, pokok_tagih, bunga_tagih, total_tagih, status) 
                             VALUES (?, ?, ?, ?, ?, ?, 'BELUM')")
                   ->execute([$id, $i, $jatuhTempo, $pokokAngsuran, $bungaAngsuran, $totalAngsuran]);
            }

            // 3. Log to Kas (KAS_KELUAR)
            require_once APP_PATH . '/models/KasTransaksi.php';
            $kas = new KasTransaksi();
            $kas->log('KAS_KELUAR', $pinjaman['pokok'], 'PENCAIRAN_PINJAMAN', "Pencairan Pinjaman #" . $id . " - " . $pinjaman['nama'], 'pinjaman', $id);

            // 4. Audit Log
            require_once APP_PATH . '/models/AuditLog.php';
            $audit = new AuditLog();
            $audit->log('PENCAIRAN_PINJAMAN', 'pinjaman', $id, "Pinjaman #" . $id . " telah dicairkan.");

            $db->commit();
            $this->redirect('/pinjaman/' . $id, 'Pinjaman berhasil dicairkan dan jadwal angsuran telah dibuat.', 'success');
        } catch (Exception $e) {
            $db->rollBack();
            $this->redirect('/pinjaman/' . $id . '/pencairan', 'Gagal mencairkan pinjaman: ' . $e->getMessage(), 'error');
        }
    }
}
