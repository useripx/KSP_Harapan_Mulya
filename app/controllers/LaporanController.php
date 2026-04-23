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
        $db = db();
        // Tarik dari view v_tunggakan
        $sql = "SELECT * FROM v_tunggakan ORDER BY hari_telat DESC";
        $stmt = $db->query($sql);
        $tunggakan = $stmt->fetchAll();

        $this->view('laporan/tunggakan', [
            'pageTitle' => 'Laporan Tunggakan Pinjaman',
            'tunggakan' => $tunggakan
        ]);
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

    public function labaRugi()
    {
        $filter = $this->buildDateFilter('a.tanggal_bayar');
        $db = db();

        // 1. Pendapatan (Bunga & Denda dari Angsuran)
        $sqlPendapatan = "SELECT SUM(bunga_bayar) as bunga, SUM(denda) as denda 
                          FROM angsuran a WHERE " . $filter['where'];
        $stmtP = $db->prepare($sqlPendapatan);
        $stmtP->execute($filter['params']);
        $pendapatan = $stmtP->fetch();

        // 2. Pendapatan Administrasi (Potongan Pinjaman Cair)
        $sqlAdmin = "SELECT SUM(potongan_admin) as admin 
                     FROM pinjaman a WHERE status IN ('DICAIRKAN', 'BERJALAN', 'LUNAS') 
                     AND " . str_replace('a.tanggal_bayar', 'a.tgl_cair', $filter['where']);
        $stmtA = $db->prepare($sqlAdmin);
        $stmtA->execute($filter['params']);
        $admin = $stmtA->fetch();

        // 3. Beban Operasional (Kas Keluar)
        $sqlBeban = "SELECT SUM(jumlah) as beban FROM kas_transaksi a 
                     WHERE tipe = 'KAS_KELUAR' AND sumber = 'OPERASIONAL' 
                     AND " . str_replace('a.tanggal_bayar', 'a.tanggal', $filter['where']);
        $stmtB = $db->prepare($sqlBeban);
        $stmtB->execute($filter['params']);
        $beban = $stmtB->fetch();

        $this->view('laporan/laba_rugi', [
            'pageTitle' => 'Laporan Laba Rugi',
            'pendapatan' => $pendapatan,
            'admin' => $admin,
            'beban' => $beban,
            'filterText' => $filter['filterText']
        ]);
    }

    public function neraca()
    {
        $db = db();

        // --- 1. AKTIVA (Aset) ---
        $kasIn = $db->query("SELECT SUM(jumlah) FROM kas_transaksi WHERE tipe='KAS_MASUK'")->fetchColumn() ?: 0;
        $kasOut = $db->query("SELECT SUM(jumlah) FROM kas_transaksi WHERE tipe='KAS_KELUAR'")->fetchColumn() ?: 0;
        $saldoKas = $kasIn - $kasOut;

        $piutang = $db->query("SELECT SUM(sisa_pokok) FROM v_ringkasan_pinjaman WHERE status='BERJALAN'")->fetchColumn() ?: 0;

        $jumlahAset = $saldoKas + $piutang;


        // --- 2. PASIVA (Kewajiban & Ekuitas) ---
        // Total kewajiban koperasi = Uang simpanan anggota yang dititipkan
        $totalSimpanan = $db->query("SELECT SUM(saldo) FROM v_saldo_simpanan")->fetchColumn() ?: 0;

        // Ekuitas (Modal/SHU) = Total Aset dikurangi Kewajiban biar balance
        $ekuitas = $jumlahAset - $totalSimpanan;

        $this->view('laporan/neraca', [
            'pageTitle' => 'Laporan Neraca',
            'saldoKas' => $saldoKas,
            'piutang' => $piutang,
            'jumlahAset' => $jumlahAset,
            'totalSimpanan' => $totalSimpanan,
            'ekuitas' => $ekuitas
        ]);
    }

    public function shu()
    {
        $filter = $this->buildDateFilter('a.tanggal_bayar');
        $db = db();

        // Hitung SHU Bersih (Sama kayak Laba Rugi)
        $bunga = $db->query("SELECT SUM(bunga_bayar) FROM angsuran")->fetchColumn() ?: 0;
        $denda = $db->query("SELECT SUM(denda) FROM angsuran")->fetchColumn() ?: 0;
        $admin = $db->query("SELECT SUM(potongan_admin) FROM pinjaman WHERE status IN ('DICAIRKAN', 'BERJALAN', 'LUNAS')")->fetchColumn() ?: 0;
        $beban = $db->query("SELECT SUM(jumlah) FROM kas_transaksi WHERE tipe = 'KAS_KELUAR' AND sumber = 'OPERASIONAL'")->fetchColumn() ?: 0;

        $shuBersih = ($bunga + $denda + $admin) - $beban;

        $this->view('laporan/shu', [
            'pageTitle' => 'Distribusi SHU',
            'shuBersih' => $shuBersih
        ]);
    }
}
