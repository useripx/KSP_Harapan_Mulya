<?php
/**
 * LaporanController
 */

class LaporanController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::requireAnyRole([ROLE_ADMIN, ROLE_KETUA, ROLE_TELLER]);
    }

    /**
     * Reports Index / Dashboard
     */
    public function index()
    {
        $this->view('laporan/index', [
            'pageTitle' => 'Laporan & Analitik'
        ]);
    }

    /**
     * Helper untuk membuat SQL filtering waktu dari GET request
     */
    private function buildDateFilter($dateColumnName)
    {
        $periode = $_GET['periode'] ?? 'semua';
        $where = "1=1";
        $params = [];
        $filterText = "Semua Periode";

        if ($periode === 'harian' && !empty($_GET['tanggal'])) {
            $where = "DATE($dateColumnName) = ?";
            $params[] = $_GET['tanggal'];
            $filterText = "Tanggal: " . date('d F Y', strtotime($_GET['tanggal']));
        } elseif ($periode === 'bulanan' && !empty($_GET['bulan'])) {
            $where = "DATE_FORMAT($dateColumnName, '%Y-%m') = ?";
            $params[] = $_GET['bulan'];
            $filterText = "Bulan: " . date('F Y', strtotime($_GET['bulan'] . '-01'));
        } elseif ($periode === 'tahunan' && !empty($_GET['tahun'])) {
            $where = "YEAR($dateColumnName) = ?";
            $params[] = $_GET['tahun'];
            $filterText = "Tahun: " . $_GET['tahun'];
        }

        return [
            'where' => $where,
            'params' => $params,
            'filterText' => $filterText,
            'periode' => $periode
        ];
    }

    public function simpanan()
    {
        $filter = $this->buildDateFilter('st.created_at');
        $db = db();
        $sql = "SELECT st.*, a.nama as anggota_nama, a.no_anggota 
               FROM simpanan_transaksi st 
               JOIN anggota a ON st.anggota_id = a.id 
               WHERE {$filter['where']} 
               ORDER BY st.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($filter['params']);
        $transaksi = $stmt->fetchAll();

        $this->view('laporan/simpanan', [
            'pageTitle' => 'Laporan Transaksi Simpanan',
            'transaksi' => $transaksi,
            'filterText' => $filter['filterText'],
            'periode' => $filter['periode']
        ]);
    }

    public function pinjaman()
    {
        $filter = $this->buildDateFilter('p.created_at');
        $db = db();
        $sql = "SELECT p.*, a.nama as anggota_nama, a.no_anggota 
               FROM pinjaman p 
               JOIN anggota a ON p.anggota_id = a.id 
               WHERE {$filter['where']} 
               ORDER BY p.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($filter['params']);
        $loans = $stmt->fetchAll();

        $this->view('laporan/pinjaman', [
            'pageTitle' => 'Laporan Riwayat Pinjaman',
            'loans' => $loans,
            'filterText' => $filter['filterText'],
            'periode' => $filter['periode']
        ]);
    }

    public function angsuran()
    {
        $filter = $this->buildDateFilter('a.tanggal_bayar');
        $db = db();
        $sql = "SELECT a.*, p.anggota_id, ang.nama as anggota_nama, ang.no_anggota 
               FROM angsuran a 
               JOIN pinjaman p ON a.pinjaman_id = p.id 
               JOIN anggota ang ON p.anggota_id = ang.id
               WHERE {$filter['where']} 
               ORDER BY a.tanggal_bayar DESC, a.id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($filter['params']);
        $angsuran = $stmt->fetchAll();

        $this->view('laporan/angsuran', [
            'pageTitle' => 'Laporan Riwayat Angsuran',
            'angsuran' => $angsuran,
            'filterText' => $filter['filterText'],
            'periode' => $filter['periode']
        ]);
    }

    public function tunggakan()
    {
        $this->view('laporan/tunggakan', ['pageTitle' => 'Laporan Tunggakan']);
    }

    public function kas()
    {
        $filter = $this->buildDateFilter('tanggal');
        $db = db();
        $sql = "SELECT * FROM kas_transaksi WHERE {$filter['where']} ORDER BY tanggal DESC, id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($filter['params']);
        $kas = $stmt->fetchAll();

        $this->view('laporan/kas', [
            'pageTitle' => 'Laporan Arus Kas Utama',
            'kas' => $kas,
            'filterText' => $filter['filterText'],
            'periode' => $filter['periode']
        ]);
    }

    public function neraca()
    {
        $this->view('laporan/neraca', ['pageTitle' => 'Laporan Neraca']);
    }

    public function labaRugi()
    {
        $this->view('laporan/laba_rugi', ['pageTitle' => 'Laporan Laba Rugi']);
    }

    public function shu()
    {
        $this->view('laporan/shu', ['pageTitle' => 'Laporan SHU']);
    }
}
