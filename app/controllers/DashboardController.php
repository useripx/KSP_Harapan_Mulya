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
            'anggota_baru_bulan_ini' => $this->getAnggotaBaruBulanIni(),
            'transaksi_hari_ini' => $this->getTransaksiHariIni(),
        ];

        // Get recent transactions
        $recentTransactions = $this->getRecentTransactions(10);

        // Get upcoming angsuran
        $upcomingAngsuran = $this->getUpcomingAngsuran(5);


        // Chart data - Transaksi 7 hari terakhir
        $chartData = $this->getTransaksiChart7Hari();

        // Chart data - Pinjaman by status
        $pinjamanByStatus = $this->getPinjamanByStatus();

        $data = [
            'pageTitle' => 'Dashboard',
            'stats' => $stats,
            'recentTransactions' => $recentTransactions,
            'upcomingAngsuran' => $upcomingAngsuran,
            'chartData' => $chartData,
            'pinjamanByStatus' => $pinjamanByStatus,
        ];

        $this->view('dashboard/admin', $data);
    }

    /**
     * Validator Dashboard logic
     */
    /**
     * Ketua Dashboard
     */
    public function ketuaDashboard()
    {
        Auth::requireRole(ROLE_KETUA);
        return $this->renderManagerDashboard();
    }

    /**
     * Manager Dashboard
     */
    private function renderManagerDashboard()
    {
        $db = db();

        // Get selected year from query param or default to current year
        $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

        // Get available years for the filter
        $yearsResult = $db->query("
            SELECT DISTINCT YEAR(tgl_daftar) as year 
            FROM anggota 
            WHERE tgl_daftar IS NOT NULL AND YEAR(tgl_daftar) > 0
            UNION 
            SELECT DISTINCT YEAR(tanggal) as year 
            FROM simpanan_transaksi
            WHERE tanggal IS NOT NULL AND YEAR(tanggal) > 0
            ORDER BY year DESC
        ")->fetchAll();
        
        $availableYears = array_column($yearsResult, 'year');
        if (empty($availableYears)) $availableYears = [(int)date('Y')];
        if (!in_array((int)date('Y'), $availableYears)) array_unshift($availableYears, (int)date('Y'));

        // Get statistics (Tunggakan is removed per requirement)
        $stats = [
            'total_anggota' => $this->getTotalAnggota(),
            'total_simpanan' => $this->getTotalSimpanan(),
            'total_pinjaman_aktif' => $this->getTotalPinjamanAktif(),
            'anggota_baru_bulan_ini' => $this->getAnggotaBaruBulanIni(),
        ];

        // Member Summary Table Data — kompatibel MySQL 5.7 & 8.x
        // Logic: Calculate cumulative savings based on years of membership up to $selectedYear
        $sql = "
            SELECT
                a.no_anggota,
                a.nama,
                a.tgl_daftar,
                -- Years active up to selected year
                (? - YEAR(a.tgl_daftar) + 1) as years_active,
                -- Cumulative Dummy Data (Amount per year * years_active)
                (500000 + (a.id * 10000)) * (? - YEAR(a.tgl_daftar) + 1) as simpanan_wajib,
                (100000 + (a.id * 5000)) * (? - YEAR(a.tgl_daftar) + 1) as simpanan_pokok,
                (250000 + (a.id * 2000)) * (? - YEAR(a.tgl_daftar) + 1) as simpanan_sukarela,
                (150000 + (a.id * 1500)) * (? - YEAR(a.tgl_daftar) + 1) as simpanan_belanja,
                (50000 + (a.id * 1000)) * (? - YEAR(a.tgl_daftar) + 1) as simpanan_dana_sosial,
                -- Data Simpanan Baru (Dinamis dari Konfigurasi Validator)
                COALESCE(k.simpanan_motor, 0) * (? - YEAR(a.tgl_daftar) + 1) as simpanan_motor,
                COALESCE(k.simpanan_mobil, 0) * (? - YEAR(a.tgl_daftar) + 1) as simpanan_mobil,
                (
                    ((500000 + (a.id * 10000)) + 
                     (100000 + (a.id * 5000)) + 
                     (250000 + (a.id * 2000)) + 
                     (150000 + (a.id * 1500)) + 
                     (50000 + (a.id * 1000)) +
                     COALESCE(k.simpanan_motor, 0) +
                     COALESCE(k.simpanan_mobil, 0)) * (? - YEAR(a.tgl_daftar) + 1)
                ) as total
            FROM anggota a
            LEFT JOIN konfigurasi_simpanan_anggota k ON a.id = k.anggota_id
            WHERE a.status = 'AKTIF'
            AND YEAR(a.tgl_daftar) <= ?
            GROUP BY a.id, a.no_anggota, a.nama, a.tgl_daftar, k.simpanan_motor, k.simpanan_mobil
            ORDER BY total DESC
        ";

        $stmt = $db->prepare($sql);
        // Bind parameters: selectedYear (10 times)
        $stmt->execute([
            $selectedYear, $selectedYear, $selectedYear, $selectedYear, 
            $selectedYear, $selectedYear, $selectedYear, $selectedYear,
            $selectedYear, $selectedYear
        ]);
        $ringkasanAnggota = $stmt->fetchAll();

        // Get Member Savings Config Summary (For the second table)
        $configSummary = $db->query("
            SELECT a.no_anggota, a.nama, k.simpanan_motor, k.simpanan_mobil, (k.simpanan_motor + k.simpanan_mobil) as total
            FROM anggota a
            JOIN konfigurasi_simpanan_anggota k ON a.id = k.anggota_id
            WHERE a.status = 'AKTIF'
            ORDER BY k.id DESC
        ")->fetchAll();

        $data = [
            'pageTitle' => 'Dashboard Manager',
            'stats' => $stats,
            'ringkasanAnggota' => $ringkasanAnggota,
            'configSummary' => $configSummary,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears
        ];

        $this->view('dashboard/manager', $data);
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

        // Ambil Data Gaji & Info Anggota
        $db = db();
        $stmt = $db->prepare("SELECT gaji, nama FROM anggota WHERE id = ?");
        $stmt->execute([$anggotaId]);
        $anggotaData = $stmt->fetch();
        $gajiBulanIni = $anggotaData['gaji'] ?? 0;

        // Ambil Detail Pinjaman Aktif (Untuk Info Sisa Tenor)
        $stmtPinjaman = $db->prepare("
            SELECT id, pokok, tenor_bulan, 
                   (SELECT COUNT(*) FROM pinjaman_jadwal WHERE pinjaman_id = pinjaman.id AND status = 'LUNAS') as tenor_terbayar 
            FROM pinjaman 
            WHERE anggota_id = ? AND status = 'BERJALAN' 
            ORDER BY created_at DESC LIMIT 1
        ");
        $stmtPinjaman->execute([$anggotaId]);
        $pinjamanAktif = $stmtPinjaman->fetch();

        // Kalkulasi Kewajiban Bulan Ini (Slip Gaji Virtual)
        // Asumsi: Simpanan Wajib = Rp 50.000 / bulan (Bisa disesuaikan dengan aturan koperasimu)
        $simpananWajibBulanIni = 50000; 
        
        // Ambil Angsuran yang JATUH TEMPO bulan ini (BELUM DIBAYAR)
        $stmtAngsuran = $db->prepare("
            SELECT COALESCE(SUM(total_tagih), 0) as total_tagihan_bulan_ini
            FROM pinjaman_jadwal pj
            JOIN pinjaman p ON pj.pinjaman_id = p.id
            WHERE p.anggota_id = ? 
            AND pj.status = 'BELUM'
            AND MONTH(pj.jatuh_tempo) = MONTH(CURDATE())
            AND YEAR(pj.jatuh_tempo) = YEAR(CURDATE())
        ");
        $stmtAngsuran->execute([$anggotaId]);
        $tagihanPinjamanBulanIni = (float) $stmtAngsuran->fetch()['total_tagihan_bulan_ini'];

        $totalKewajiban = $simpananWajibBulanIni + $tagihanPinjamanBulanIni;
        $takeHomePay = $gajiBulanIni - $totalKewajiban;

        // Stats Global (Sesuai aslinya + tambahan)
        $stats = [
            'saldo_simpanan' => $this->getSaldoSimpanan($anggotaId),
            'total_pinjaman' => $pinjamanAktif ? $pinjamanAktif['pokok'] : 0,
            'sisa_pinjaman' => $this->getSisaPinjamanAnggota($anggotaId),
            'tenor_berjalan' => $pinjamanAktif ? $pinjamanAktif['tenor_terbayar'] . ' / ' . $pinjamanAktif['tenor_bulan'] . ' Bulan' : 'Tidak Ada',
            
            // Data untuk Slip Gaji Virtual
            'gaji_kotor' => $gajiBulanIni,
            'potongan_simpanan' => $simpananWajibBulanIni,
            'potongan_angsuran' => $tagihanPinjamanBulanIni,
            'total_potongan' => $totalKewajiban,
            'gaji_bersih' => $takeHomePay
        ];

        $riwayatTransaksi = $this->getRiwayatTransaksiAnggota($anggotaId, 5);
        $jadwalAngsuran = $this->getJadwalAngsuranAnggota($anggotaId, 5);

        $data = [
            'pageTitle' => 'Dashboard Anggota',
            'stats' => $stats,
            'riwayatTransaksi' => $riwayatTransaksi,
            'jadwalAngsuran' => $jadwalAngsuran,
            'namaAnggota' => $anggotaData['nama']
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
        // Fallback jika view v_saldo_simpanan bermasalah
        try {
            $stmt = $db->prepare("SELECT saldo FROM v_saldo_simpanan WHERE anggota_id = ?");
            $stmt->execute([$anggotaId]);
            $result = $stmt->fetch();
            return $result ? (float) $result['saldo'] : 0;
        } catch (Exception $e) {
            // Hitung manual jika view tidak ada
            $stmt = $db->prepare("
                SELECT SUM(CASE WHEN tipe = 'SETOR' THEN jumlah WHEN tipe = 'TARIK' THEN -jumlah ELSE 0 END) as saldo 
                FROM simpanan_transaksi WHERE anggota_id = ?
            ");
            $stmt->execute([$anggotaId]);
            return (float) $stmt->fetch()['saldo'];
        }
    }

    private function getSisaPinjamanAnggota($anggotaId)
    {
        $db = db();
        // Menghitung total tagihan yang belum dibayar dari tabel jadwal
        $stmt = $db->prepare("
            SELECT COALESCE(SUM(total_tagih), 0) as sisa
            FROM pinjaman_jadwal pj
            JOIN pinjaman p ON pj.pinjaman_id = p.id
            WHERE p.anggota_id = ? AND pj.status = 'BELUM' AND p.status = 'BERJALAN'
        ");
        $stmt->execute([$anggotaId]);
        $result = $stmt->fetch();
        return (float) $result['sisa'];
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