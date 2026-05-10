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

    // ==========================================
    // FUNGSI PENGAJUAN BARU
    // ==========================================
    public function ajukan()
    {
        $nominalSimulasi = $_GET['nominal'] ?? '';
        $tenorSimulasi = $_GET['tenor'] ?? '';

        $db = db();

        if (Auth::role() === ROLE_ANGGOTA) {
            // 1. Satpam Simulasi
            if (empty($nominalSimulasi) || empty($tenorSimulasi)) {
                $this->redirect('/pinjaman/simulasi', 'Tolong isi form Simulasi terlebih dahulu sebelum mengajukan pinjaman!', 'warning');
            }

            // 2. Cek Sisa Hutang Otomatis di Database
            $stmt = $db->prepare("
                SELECT p.id, 
                       (SELECT SUM(total_tagih) FROM pinjaman_jadwal WHERE pinjaman_id = p.id AND status = 'BELUM') as sisa_hutang 
                FROM pinjaman p 
                JOIN anggota a ON p.anggota_id = a.id 
                WHERE a.user_id = ? AND p.status = 'BERJALAN'
            ");
            $stmt->execute([Auth::id()]);
            $pinjamanAktif = $stmt->fetch();

            // Jika ada hutang > 0, Lempar otomatis ke Top Up!
            if ($pinjamanAktif && $pinjamanAktif['sisa_hutang'] > 0) {
                $this->redirect('/pinjaman/topup?nominal=' . $nominalSimulasi . '&tenor=' . $tenorSimulasi, 'Anda terdeteksi memiliki sisa hutang. Pengajuan otomatis dialihkan ke jalur Top Up.', 'info');
            }
        }

        $anggota = [];
        if (Auth::role() !== ROLE_ANGGOTA) {
            $anggota = $db->query("SELECT * FROM anggota WHERE status = 'AKTIF' ORDER BY nama ASC")->fetchAll();
        }

        $settings = $db->query("SELECT bunga_jangka_pendek, bunga_jangka_panjang FROM setting_koperasi ORDER BY id DESC LIMIT 1")->fetch();

        $this->view('pinjaman/ajukan', [
            'pageTitle' => 'Pengajuan Pinjaman Baru',
            'anggota' => $anggota,
            'nominalOtomatis' => $nominalSimulasi,
            'tenorOtomatis' => $tenorSimulasi,
            'settings' => $settings ?: ['bunga_jangka_pendek' => 1.0, 'bunga_jangka_panjang' => 0.6]
        ]);
    }

    // ==========================================
    // FUNGSI STORE (SIMPAN DATA)
    // ==========================================
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
            
            // Tangkap pilihan metode dari form (Transfer/Tunai)
            $data['metode'] = $data['metode'] ?? 'TRANSFER';
        }

        $errors = $this->validate($data, [
            'anggota_id' => 'required',
            'pokok' => 'required|numeric|min_value:500000',
            'tenor_bulan' => 'required|numeric',
            'tujuan' => 'required'
        ]);

        // TANGKAP NOMINAL & TENOR BUAT OLEH-OLEH BALIK JIKA ERROR
        $nom = $data['pokok'] ?? '';
        $ten = $data['tenor_bulan'] ?? '';
        
        // Cek darimana form ini dikirim (Top Up atau Baru)
        $isTopUp = isset($data['jenis_pengajuan']) && $data['jenis_pengajuan'] === 'TOP_UP';
        $redirectPath = $isTopUp ? '/pinjaman/topup' : '/pinjaman/ajukan';

        if (!empty($errors)) {
            View::setErrors($errors);
            $this->redirect($redirectPath . '?nominal=' . $nom . '&tenor=' . $ten, 'Harap lengkapi form dengan benar.', 'error');
        }

        try {
            // Get interest rates from settings
            $db = db();
            $setting = $db->query("SELECT bunga_jangka_pendek, bunga_jangka_panjang FROM setting_koperasi ORDER BY id DESC LIMIT 1")->fetch();
            $tenor = (int)$data['tenor_bulan'];
            
            if ($setting) {
                $bunga = ($tenor === 1) ? $setting['bunga_jangka_pendek'] : $setting['bunga_jangka_panjang'];
            } else {
                $bunga = ($tenor === 1) ? 1.0 : 0.6; // Fallback
            }

            $pinjamanId = $this->pinjamanModel->insert([
                'anggota_id' => $data['anggota_id'],
                'tgl_pengajuan' => date('Y-m-d'),
                'pokok' => $data['pokok'],
                'tenor_bulan' => $data['tenor_bulan'],
                'metode' => $data['metode'] ?? 'TRANSFER',
                'bunga_persen_bln' => $bunga,
                'tujuan' => $data['tujuan'],
                'status' => 'DIAJUKAN'
            ]);

            if ($pinjamanId) {
                // Log action
                require_once APP_PATH . '/models/AuditLog.php';
                $audit = new AuditLog();
                $audit->log('PENGAJUAN_PINJAMAN', 'pinjaman', $pinjamanId, "Pengajuan pinjaman sebesar " . formatRupiah($data['pokok']));
                
                notifyRole([ROLE_TELLER, ROLE_ADMIN], 'warning', 'bi-file-earmark-plus', 'Pengajuan Baru', 'Terdapat pengajuan pinjaman sebesar ' . formatRupiah($data['pokok']), url('/pinjaman/' . $pinjamanId));
            }

            $this->redirect('/pinjaman/' . $pinjamanId, 'Pengajuan pinjaman berhasil dikirim.', 'success');
        } catch (Exception $e) {
            $this->redirect($redirectPath . '?nominal=' . $nom . '&tenor=' . $ten, 'Gagal mengirim pengajuan: ' . $e->getMessage(), 'error');
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

    public function simulasi()
    {
        Auth::requireLogin();
        
        $db = db();
        $settings = $db->query("SELECT bunga_pinjaman_persen_bln, bunga_jangka_pendek, bunga_jangka_panjang FROM setting_koperasi ORDER BY id DESC LIMIT 1")->fetch();

        $this->view('anggota/simulasi', [
            'pageTitle' => 'Simulasi Peminjaman',
            'settings' => $settings ?: [
                'bunga_jangka_pendek' => 1.0,
                'bunga_jangka_panjang' => 0.6
            ]
        ]);
    }

    public function topup()
    {
        $nominalSimulasi = $_GET['nominal'] ?? '';
        $tenorSimulasi = $_GET['tenor'] ?? '';
        
        $db = db();
        $sisaHutang = 0;

        if (Auth::role() === ROLE_ANGGOTA) {
            // 1. Satpam Simulasi
            if (empty($nominalSimulasi) || empty($tenorSimulasi)) {
                $this->redirect('/pinjaman/simulasi', 'Tolong isi form Simulasi terlebih dahulu sebelum mengajukan Top Up!', 'warning');
            }

            // 2. Ambil Sisa Hutang
            $stmt = $db->prepare("
                SELECT p.id, 
                       (SELECT SUM(total_tagih) FROM pinjaman_jadwal WHERE pinjaman_id = p.id AND status = 'BELUM') as sisa_hutang 
                FROM pinjaman p 
                JOIN anggota a ON p.anggota_id = a.id 
                WHERE a.user_id = ? AND p.status = 'BERJALAN'
            ");
            $stmt->execute([Auth::id()]);
            $pinjamanAktif = $stmt->fetch();

            if (!$pinjamanAktif || $pinjamanAktif['sisa_hutang'] <= 0) {
                $this->redirect('/pinjaman/ajukan?nominal=' . $nominalSimulasi . '&tenor=' . $tenorSimulasi, 'Sisa hutang Anda Rp 0. Silakan gunakan form Pinjaman Baru.', 'info');
            }

            $sisaHutang = $pinjamanAktif['sisa_hutang'];
        }

        $anggota = [];
        if (Auth::role() !== ROLE_ANGGOTA) {
            $anggota = $db->query("SELECT * FROM anggota WHERE status = 'AKTIF' ORDER BY nama ASC")->fetchAll();
        }

        $this->view('pinjaman/topup', [
            'pageTitle' => 'Pengajuan Top Up Pinjaman',
            'anggota' => $anggota,
            'nominalOtomatis' => $nominalSimulasi,
            'tenorOtomatis' => $tenorSimulasi,
            'sisaHutang' => $sisaHutang
        ]);
    }

    public function darurat()
    {
        $db = db();
        $sisaHutang = 0;

        if (Auth::role() === ROLE_ANGGOTA) {
            $stmt = $db->prepare("
                SELECT p.id, 
                       (SELECT SUM(total_tagih) FROM pinjaman_jadwal WHERE pinjaman_id = p.id AND status = 'BELUM') as sisa_hutang 
                FROM pinjaman p 
                JOIN anggota a ON p.anggota_id = a.id 
                WHERE a.user_id = ? AND p.status = 'BERJALAN'
            ");
            $stmt->execute([Auth::id()]);
            $pinjamanAktif = $stmt->fetch();

            if ($pinjamanAktif && $pinjamanAktif['sisa_hutang'] > 0) {
                $sisaHutang = $pinjamanAktif['sisa_hutang'];
            }
        }

        $anggota = [];
        if (Auth::role() !== ROLE_ANGGOTA) {
            $anggota = $db->query("SELECT * FROM anggota WHERE status = 'AKTIF' ORDER BY nama ASC")->fetchAll();
        }

        $this->view('pinjaman/darurat', [
            'pageTitle' => 'Pengajuan Pinjaman Darurat',
            'anggota' => $anggota,
            'sisaHutang' => $sisaHutang
        ]);
    }

    public function pernyataan()
    {
        $db = db();
        $userId = Auth::id();
        $userRole = Auth::role();

        $sql = "SELECT p.*, a.nama, a.no_anggota 
                FROM pinjaman p
                JOIN anggota a ON p.anggota_id = a.id";

        if ($userRole === ROLE_ANGGOTA) {
            $sql .= " WHERE a.user_id = " . (int)$userId;
        }

        $sql .= " ORDER BY p.created_at DESC";
        $pinjaman = $db->query($sql)->fetchAll();

        $this->view('pinjaman/pernyataan', [
            'pageTitle' => 'Cetak Surat Pernyataan',
            'pinjaman' => $pinjaman
        ]);
    }

    // ==========================================
    // FUNGSI PELUNASAN (UPDATE BARU)
    // ==========================================
    public function pelunasan()
    {
        Auth::requireLogin();
        $db = db();
        
        // Ambil ID Anggota berdasarkan User Login
        $stmtId = $db->prepare("SELECT id FROM anggota WHERE user_id = ?");
        $stmtId->execute([Auth::id()]);
        $anggota = $stmtId->fetch();
        $anggotaId = $anggota['id'] ?? 0;

        // Ambil data jadwal yang belum lunas untuk tabel di view pelunasan
        $stmt = $db->prepare("
            SELECT pj.* FROM pinjaman_jadwal pj
            JOIN pinjaman p ON pj.pinjaman_id = p.id
            WHERE p.anggota_id = ? AND pj.status = 'BELUM'
            ORDER BY pj.jatuh_tempo ASC
        ");
        $stmt->execute([$anggotaId]);
        $jadwalAngsuran = $stmt->fetchAll();

        $this->view('pinjaman/pelunasan', [
            'pageTitle' => 'Pelunasan Dipercepat',
            'jadwalAngsuran' => $jadwalAngsuran
        ]); 
    }

    // ==========================================
    // FUNGSI CETAK PDF (JALUR MULTI-PENCARIAN)
    // ==========================================
    public function cetakSurat($id)
    {
        $pinjaman = $this->pinjamanModel->findWithAnggota($id);
        
        if (!$pinjaman) {
            die("Data pinjaman tidak ditemukan.");
        }

        if (Auth::role() === ROLE_ANGGOTA) {
            $db = db();
            $stmt = $db->prepare("SELECT user_id FROM anggota WHERE id = ?");
            $stmt->execute([$pinjaman['anggota_id']]);
            $member = $stmt->fetch();
            if ($member['user_id'] != Auth::id()) {
                die("Akses ditolak.");
            }
        }

        // Kita tebar jaring: PHP akan mencoba satu per satu lokasi ini sampai ketemu file-nya
        $lokasiFile = [
            APP_PATH . '/views/pinjaman/cetak_surat_pdf.php',               // Standar MVC
            dirname(__DIR__) . '/views/pinjaman/cetak_surat_pdf.php',       // Naik 1 folder
            ROOT_PATH . '/views/pinjaman/cetak_surat_pdf.php'               // Di root (seperti foto VS code)
        ];

        $ketemu = false;
        foreach ($lokasiFile as $path) {
            if (file_exists($path)) {
                require_once $path;
                $ketemu = true;
                break; // Langsung stop pencarian kalau udah ketemu!
            }
        }

        if (!$ketemu) {
            die("File cetak_surat_pdf.php benar-benar tidak ditemukan di folder mana pun. Pastikan nama filenya tidak ada typo (seperti .php.php)!");
        }
    }
}