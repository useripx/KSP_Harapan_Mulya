<?php
/**
 * DashboardController
 * Handle dashboard display and statistics
 */

class DashboardController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        // Check if user is logged in
        Auth::requireLogin();
    }

    /**
     * Display dashboard based on user role
     */
    public function index()
    {
        $userRole = Auth::role();

        switch ($userRole) {
            case ROLE_ADMIN:
                return $this->adminDashboard();
            case ROLE_TELLER:
                return $this->tellerDashboard();
            case ROLE_KETUA:
                return $this->ketuaDashboard();
            case ROLE_ANGGOTA:
                return $this->anggotaDashboard();
            default:
                $this->redirect('/login', 'Role tidak valid', 'error');
        }
    }

    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        Auth::requireRole(ROLE_ADMIN);
        return $this->renderAdminDashboard();
    }

    /**
     * Teller Dashboard
     */
    public function tellerDashboard()
    {
        Auth::requireRole(ROLE_TELLER);
        return $this->renderAdminDashboard();
    }

    /**
     * Internal Admin/Teller Dashboard logic
     */
    private function renderAdminDashboard()
    {
        $db = db();

        // Get statistics
        $stats = [
            'total_anggota' => $this->getTotalAnggota(),
            'total_simpanan' => $this->getTotalSimpanan(),
            'total_pinjaman_aktif' => $this->getTotalPinjamanAktif(),
            'total_tunggakan' => $this->getTotalTunggakan(),
            'anggota_baru_bulan_ini' => $this->getAnggotaBaruBulanIni(),
            'transaksi_hari_ini' => $this->getTransaksiHariIni(),
        ];

        // Get recent transactions
        $recentTransactions = $this->getRecentTransactions(10);

        // Get upcoming angsuran
        $upcomingAngsuran = $this->getUpcomingAngsuran(5);

        // Get tunggakan list
        $tunggakan = $this->getTunggakanList(5);

        // Chart data - Transaksi 7 hari terakhir
        $chartData = $this->getTransaksiChart7Hari();

        // Chart data - Pinjaman by status
        $pinjamanByStatus = $this->getPinjamanByStatus();

        $data = [
            'pageTitle' => 'Dashboard',
            'stats' => $stats,
            'recentTransactions' => $recentTransactions,
            'upcomingAngsuran' => $upcomingAngsuran,
            'tunggakan' => $tunggakan,
            'chartData' => $chartData,
            'pinjamanByStatus' => $pinjamanByStatus,
        ];

        $this->view('dashboard/admin', $data);
    }

    /**
     * Ketua Dashboard
     */
    public function ketuaDashboard()
    {
        Auth::requireRole(ROLE_KETUA);
        // Similar to admin but focused on reports
        return $this->renderAdminDashboard();
    }

    /**
     * Anggota Dashboard
     */
    public function anggotaDashboard()
    {
        Auth::requireRole(ROLE_ANGGOTA);
        $anggotaId = $this->getAnggotaIdByUserId(Auth::id());

        if (!$anggotaId) {
            $this->redirect('/login', 'Data anggota tidak ditemukan', 'error');
        }

        $stats = [
            'saldo_simpanan' => $this->getSaldoSimpanan($anggotaId),
            'total_setoran' => $this->getTotalSetoranAnggota($anggotaId),
            'total_penarikan' => $this->getTotalPenarikanAnggota($anggotaId),
            'total_pinjaman' => $this->getTotalPinjamanAnggota($anggotaId),
            'sisa_pinjaman' => $this->getSisaPinjamanAnggota($anggotaId),
            'angsuran_bulan_ini' => $this->getAngsuranBulanIni($anggotaId),
        ];

        $riwayatTransaksi = $this->getRiwayatTransaksiAnggota($anggotaId, 10);
        $jadwalAngsuran = $this->getJadwalAngsuranAnggota($anggotaId, 5);

        $data = [
            'pageTitle' => 'Dashboard Anggota',
            'stats' => $stats,
            'riwayatTransaksi' => $riwayatTransaksi,
            'jadwalAngsuran' => $jadwalAngsuran,
        ];

        $this->view('dashboard/anggota', $data);
    }

    // ========== Helper Methods ==========

    private function getTotalAnggota()
    {
        $db = db();
        $result = $db->query("SELECT COUNT(*) as total FROM anggota WHERE status = 'AKTIF'")->fetch();
        return (int) $result['total'];
    }

    private function getTotalSimpanan()
    {
        $db = db();
        $result = $db->query("
            SELECT COALESCE(SUM(
                CASE 
                    WHEN tipe = 'SETOR' THEN jumlah
                    WHEN tipe = 'TARIK' THEN -jumlah
                    WHEN tipe = 'TRANSFER' THEN 0
                END
            ), 0) as total 
            FROM simpanan_transaksi
        ")->fetch();
        return (float) $result['total'];
    }

    private function getTotalPinjamanAktif()
    {
        $db = db();
        $result = $db->query("
            SELECT COUNT(*) as total 
            FROM pinjaman 
            WHERE status IN ('BERJALAN', 'DICAIRKAN')
        ")->fetch();
        return (int) $result['total'];
    }

    private function getTotalTunggakan()
    {
        $db = db();
        $result = $db->query("SELECT COUNT(*) as total FROM v_tunggakan")->fetch();
        return (int) $result['total'];
    }

    private function getAnggotaBaruBulanIni()
    {
        $db = db();
        $result = $db->query("
            SELECT COUNT(*) as total 
            FROM anggota 
            WHERE MONTH(tgl_daftar) = MONTH(CURDATE()) 
            AND YEAR(tgl_daftar) = YEAR(CURDATE())
        ")->fetch();
        return (int) $result['total'];
    }

    private function getTransaksiHariIni()
    {
        $db = db();
        $result = $db->query("
            SELECT COUNT(*) as total 
            FROM simpanan_transaksi 
            WHERE DATE(tanggal) = CURDATE()
        ")->fetch();
        return (int) $result['total'];
    }

    private function getRecentTransactions($limit = 10)
    {
        $db = db();
        $sql = "
            (SELECT 'SIMPANAN' as kategori, st.tipe, st.tanggal, st.jumlah, a.nama, a.no_anggota
             FROM simpanan_transaksi st
             JOIN anggota a ON st.anggota_id = a.id)
            UNION ALL
            (SELECT 'ANGSURAN' as kategori, 'MASUK' as tipe, ans.created_at as tanggal, ans.total as jumlah, a.nama, a.no_anggota
             FROM angsuran ans
             JOIN pinjaman p ON ans.pinjaman_id = p.id
             JOIN anggota a ON p.anggota_id = a.id)
            UNION ALL
            (SELECT 'PINJAMAN' as kategori, 'KELUAR' as tipe, p.created_at as tanggal, p.pokok as jumlah, a.nama, a.no_anggota
             FROM pinjaman p
             JOIN anggota a ON p.anggota_id = a.id
             WHERE p.status IN ('DICAIRKAN', 'LUNAS'))
            ORDER BY tanggal DESC
            LIMIT ?
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    private function getUpcomingAngsuran($limit = 5)
    {
        $db = db();
        $stmt = $db->prepare("
            SELECT pj.*, p.anggota_id, a.nama, a.no_anggota
            FROM pinjaman_jadwal pj
            JOIN pinjaman p ON pj.pinjaman_id = p.id
            JOIN anggota a ON p.anggota_id = a.id
            WHERE pj.status = 'BELUM' 
            AND pj.jatuh_tempo >= CURDATE()
            ORDER BY pj.jatuh_tempo ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    private function getTunggakanList($limit = 5)
    {
        $db = db();
        $stmt = $db->prepare("
            SELECT * FROM v_tunggakan
            ORDER BY hari_telat DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    private function getTransaksiChart7Hari()
    {
        $db = db();
        $result = $db->query("
            SELECT 
                DATE(tanggal) as tanggal,
                SUM(CASE WHEN tipe = 'SETOR' THEN jumlah ELSE 0 END) as setor,
                SUM(CASE WHEN tipe = 'TARIK' THEN jumlah ELSE 0 END) as tarik
            FROM simpanan_transaksi
            WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE(tanggal)
            ORDER BY tanggal ASC
        ")->fetchAll();

        return $result;
    }

    private function getPinjamanByStatus()
    {
        $db = db();
        $result = $db->query("
            SELECT status, COUNT(*) as jumlah
            FROM pinjaman
            GROUP BY status
        ")->fetchAll();

        return $result;
    }

    private function getAnggotaIdByUserId($userId)
    {
        $db = db();
        $stmt = $db->prepare("SELECT id FROM anggota WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return $result ? $result['id'] : null;
    }

    private function getSaldoSimpanan($anggotaId)
    {
        $db = db();
        $stmt = $db->prepare("SELECT saldo FROM v_saldo_simpanan WHERE anggota_id = ?");
        $stmt->execute([$anggotaId]);
        $result = $stmt->fetch();
        return $result ? (float) $result['saldo'] : 0;
    }

    private function getTotalSetoranAnggota($anggotaId)
    {
        $db = db();
        $stmt = $db->prepare("SELECT COALESCE(SUM(jumlah), 0) as total FROM simpanan_transaksi WHERE anggota_id = ? AND tipe = 'SETOR'");
        $stmt->execute([$anggotaId]);
        $result = $stmt->fetch();
        return (float) $result['total'];
    }

    private function getTotalPenarikanAnggota($anggotaId)
    {
        $db = db();
        $stmt = $db->prepare("SELECT COALESCE(SUM(jumlah), 0) as total FROM simpanan_transaksi WHERE anggota_id = ? AND tipe = 'TARIK'");
        $stmt->execute([$anggotaId]);
        $result = $stmt->fetch();
        return (float) $result['total'];
    }

    private function getTotalPinjamanAnggota($anggotaId)
    {
        $db = db();
        $stmt = $db->prepare("
            SELECT COALESCE(SUM(pokok), 0) as total 
            FROM pinjaman 
            WHERE anggota_id = ? AND status IN ('BERJALAN', 'DICAIRKAN', 'LUNAS')
        ");
        $stmt->execute([$anggotaId]);
        $result = $stmt->fetch();
        return (float) $result['total'];
    }

    private function getSisaPinjamanAnggota($anggotaId)
    {
        $db = db();
        $stmt = $db->prepare("
            SELECT COALESCE(SUM(sisa_pokok), 0) as sisa
            FROM v_ringkasan_pinjaman
            WHERE anggota_id = ? AND status IN ('BERJALAN', 'DICAIRKAN')
        ");
        $stmt->execute([$anggotaId]);
        $result = $stmt->fetch();
        return (float) $result['sisa'];
    }

    private function getAngsuranBulanIni($anggotaId)
    {
        $db = db();
        $stmt = $db->prepare("
            SELECT COALESCE(SUM(total), 0) as total
            FROM angsuran a
            JOIN pinjaman p ON a.pinjaman_id = p.id
            WHERE p.anggota_id = ?
            AND MONTH(a.tanggal_bayar) = MONTH(CURDATE())
            AND YEAR(a.tanggal_bayar) = YEAR(CURDATE())
        ");
        $stmt->execute([$anggotaId]);
        $result = $stmt->fetch();
        return (float) $result['total'];
    }

    private function getRiwayatTransaksiAnggota($anggotaId, $limit = 10)
    {
        $db = db();
        $stmt = $db->prepare("
            SELECT * FROM simpanan_transaksi
            WHERE anggota_id = ? OR tujuan_anggota_id = ?
            ORDER BY tanggal DESC
            LIMIT ?
        ");
        $stmt->execute([$anggotaId, $anggotaId, $limit]);
        return $stmt->fetchAll();
    }

    private function getJadwalAngsuranAnggota($anggotaId, $limit = 5)
    {
        $db = db();
        $stmt = $db->prepare("
            SELECT pj.*
            FROM pinjaman_jadwal pj
            JOIN pinjaman p ON pj.pinjaman_id = p.id
            WHERE p.anggota_id = ? AND pj.status = 'BELUM'
            ORDER BY pj.jatuh_tempo ASC
            LIMIT ?
        ");
        $stmt->execute([$anggotaId, $limit]);
        return $stmt->fetchAll();
    }
}