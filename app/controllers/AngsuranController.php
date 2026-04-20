<?php
/**
 * AngsuranController
 */

class AngsuranController extends Controller
{
    private $angsuranModel;

    public function __construct()
    {
        parent::__construct();
        Auth::requireLogin();
        require_once APP_PATH . '/models/Angsuran.php';
        $this->angsuranModel = new Angsuran();
    }

    /**
     * List all installments
     */
    public function index()
    {
        $filters = [];
        if (Auth::role() === ROLE_ANGGOTA) {
            $db = db();
            $stmt = $db->prepare("SELECT id FROM anggota WHERE user_id = ?");
            $stmt->execute([Auth::id()]);
            $member = $stmt->fetch();
            if ($member) {
                $filters['anggota_id'] = $member['id'];
            }
        }

        $schedules = $this->angsuranModel->getSchedules($filters);

        $this->view('angsuran/index', [
            'pageTitle' => 'Daftar Angsuran / Tagihan',
            'schedules' => $schedules
        ]);
    }

    /**
     * Form to pay an installment
     */
    public function bayar($id)
    {
        if (!in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER])) {
            $this->redirect('/angsuran', 'Akses ditolak.', 'error');
        }

        $schedule = $this->angsuranModel->findSchedule($id);
        if (!$schedule) $this->redirect('/angsuran', 'Jadwal tidak ditemukan.', 'error');
        if ($schedule['status'] === 'BAYAR') $this->redirect('/angsuran', 'Angsuran sudah dibayar.', 'info');

        $this->view('angsuran/bayar', [
            'pageTitle' => 'Bayar Angsuran #' . $schedule['angsuran_ke'],
            'schedule' => $schedule
        ]);
    }

    /**
     * Process installment payment
     */
    public function proses()
    {
        if (!$this->isPost()) $this->redirect('/angsuran');
        if (!in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER])) $this->redirect('/angsuran', 'Akses ditolak.', 'error');

        $data = $this->post();
        $id = $data['schedule_id'];

        $schedule = $this->angsuranModel->findSchedule($id);
        if (!$schedule || $schedule['status'] === 'BAYAR') {
            $this->redirect('/angsuran', 'Data tidak valid.', 'error');
        }

        $db = db();
        try {
            $db->beginTransaction();

            // 1. Update Schedule Status
            $db->prepare("UPDATE pinjaman_jadwal SET status = 'BAYAR' WHERE id = ?")
               ->execute([$id]);

            // 2. Insert to angsuran table
            $db->prepare("INSERT INTO angsuran (pinjaman_id, angsuran_ke, tanggal_bayar, pokok_bayar, bunga_bayar, denda, total, diterima_oleh, keterangan) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")
               ->execute([
                   $schedule['pinjaman_id'],
                   $schedule['angsuran_ke'],
                   date('Y-m-d'),
                   $schedule['pokok_tagih'],
                   $schedule['bunga_tagih'],
                   0, // Denda set 0
                   $schedule['total_tagih'],
                   Auth::id(),
                   $data['metode_bayar'] ?? 'TUNAI'
               ]);
            
            $angsuranId = $db->lastInsertId();

            // 3. Log to Kas
            require_once APP_PATH . '/models/KasTransaksi.php';
            $kas = new KasTransaksi();
            $kas->log('KAS_MASUK', $schedule['total_tagih'], 'ANGSURAN', 
                     "Pembayaran Angsuran Ke-" . $schedule['angsuran_ke'] . " Pinjaman #" . $schedule['pinjaman_id'] . " - " . $schedule['anggota_nama'],
                     'angsuran', $angsuranId);

            // 4. Check if loan is finished
            $stmt = $db->prepare("SELECT COUNT(*) as sisa FROM pinjaman_jadwal WHERE pinjaman_id = ? AND status = 'BELUM'");
            $stmt->execute([$schedule['pinjaman_id']]);
            $check = $stmt->fetch();
            
            if ($check['sisa'] == 0) {
                $db->prepare("UPDATE pinjaman SET status = 'LUNAS' WHERE id = ?")
                   ->execute([$schedule['pinjaman_id']]);
            }

            // 5. Audit Log
            require_once APP_PATH . '/models/AuditLog.php';
            $audit = new AuditLog();
            $audit->log('BAYAR_ANGSURAN', 'angsuran', $angsuranId, "Pembayaran angsuran ke-" . $schedule['angsuran_ke'] . " untuk Pinjaman #" . $schedule['pinjaman_id']);

            $db->commit();
            $this->redirect('/angsuran/' . $angsuranId, 'Pembayaran berhasil diproses.', 'success');

        } catch (Exception $e) {
            $db->rollBack();
            $this->redirect('/angsuran/bayar/' . $id, 'Gagal memproses pembayaran: ' . $e->getMessage(), 'error');
        }
    }

    /**
     * Show payment receipt
     */
    public function detail($id)
    {
        $payment = $this->angsuranModel->findPayment($id);
        if (!$payment) $this->redirect('/angsuran', 'Data pembayaran tidak ditemukan.', 'error');

        $this->view('angsuran/detail', [
            'pageTitle' => 'Kuitansi Angsuran #' . $id,
            'payment' => $payment
        ]);
    }
}
