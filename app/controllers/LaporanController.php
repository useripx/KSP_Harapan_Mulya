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

        // --- 1. AKTIVA (Aset) Otomatis Sistem ---
        $kasIn = $db->query("SELECT SUM(jumlah) FROM kas_transaksi WHERE tipe='KAS_MASUK'")->fetchColumn() ?: 0;
        $kasOut = $db->query("SELECT SUM(jumlah) FROM kas_transaksi WHERE tipe='KAS_KELUAR'")->fetchColumn() ?: 0;
        $saldoKas = $kasIn - $kasOut;

        // Perhitungan Piutang (Sisa Pokok dari Pinjaman Berjalan)
        $piutang = $db->query("
            SELECT SUM(p.pokok - COALESCE(ang.total_pokok_bayar, 0))
            FROM pinjaman p
            LEFT JOIN (
                SELECT pinjaman_id, SUM(pokok_bayar) as total_pokok_bayar 
                FROM angsuran 
                GROUP BY pinjaman_id
            ) ang ON p.id = ang.pinjaman_id
            WHERE p.status = 'BERJALAN'
        ")->fetchColumn() ?: 0;
        $jumlahAset = $saldoKas + $piutang;

        // --- 2. PASIVA (Kewajiban & Ekuitas) Otomatis Sistem ---
        // Perhitungan Total Simpanan (Setor - Tarik)
        $totalSimpanan = $db->query("
            SELECT SUM(
                CASE 
                    WHEN tipe = 'SETOR' THEN jumlah 
                    WHEN tipe = 'TARIK' THEN -jumlah 
                    ELSE 0 
                END
            ) FROM simpanan_transaksi
        ")->fetchColumn() ?: 0;
        $ekuitas = $jumlahAset - $totalSimpanan;

        // --- 3. AMBIL DATA MANUAL NERACA ---
        // Filter berdasarkan tahun yang dipilih, default tahun ini
        $tahun = $_GET['tahun'] ?? date('Y');
        
        $sqlManual = "SELECT * FROM neraca_manual WHERE tahun = ?";
        $stmtManual = $db->prepare($sqlManual);
        $stmtManual->execute([$tahun]);
        $manualItems = $stmtManual->fetchAll();

        // Siapkan wadah (array) biar view nggak error
        $manualData = [
            'aset_lancar' => [],
            'aset_tetap'  => [],
            'kewajiban'   => [],
            'ekuitas'     => []
        ];

        // Pisah-pisahkan data ke kategorinya masing-masing
        if ($manualItems) {
            foreach ($manualItems as $item) {
                $manualData[$item['kategori']][] = $item;
            }
        }

        // --- 4. KIRIM SEMUA DATA KE VIEW ---
        $this->view('laporan/neraca', [
            'pageTitle' => 'Laporan Neraca',
            'saldoKas' => $saldoKas,
            'piutang' => $piutang,
            'jumlahAset' => $jumlahAset,
            'totalSimpanan' => $totalSimpanan,
            'ekuitas' => $ekuitas,
            'manualData' => $manualData // <- Ini yang bikin datanya nampil
        ]);
    }

    public function tambahNeracaManual() 
    {
        // 1. Tangkap data dari form modal
        // Pakai $_POST bawaan PHP biar aman kalau method custom nggak ada
        $kategori = $_POST['kategori'] ?? '';
        $nama_item = $_POST['nama_item'] ?? '';
        $nominal = $_POST['nominal'] ?? 0;
        $tahun = $_POST['tahun'] ?? date('Y');

        try {
            $db = db();
            // 2. Simpan ke tabel neraca_manual
            $sql = "INSERT INTO neraca_manual (kategori, nama_item, nominal, tahun) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$kategori, $nama_item, $nominal, $tahun]);

            // 3. Balikin ke halaman Neraca sesuai tahun yang lagi dibuka
            header("Location: " . url('/laporan/neraca?tahun=' . $tahun));
            exit;

        } catch (\Exception $e) {
            // Kalau gagal, matikan eksekusi dan kasih tau errornya
            die("Gagal menyimpan data manual: " . $e->getMessage());
        }
    }
    
    public function editNeracaManual() 
    {
        // Tangkap data dari modal edit
        $id = $_POST['id'] ?? '';
        $kategori = $_POST['kategori'] ?? '';
        $nama_item = $_POST['nama_item'] ?? '';
        $nominal = $_POST['nominal'] ?? 0;
        $tahun = $_POST['tahun'] ?? date('Y');

        try {
            $db = db();
            // Eksekusi update data ke tabel neraca_manual
            $sql = "UPDATE neraca_manual SET kategori = ?, nama_item = ?, nominal = ?, tahun = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$kategori, $nama_item, $nominal, $tahun, $id]);

            // Balikin ke halaman Neraca dengan tahun yang sama
            header("Location: " . url('/laporan/neraca?tahun=' . $tahun));
            exit;

        } catch (\Exception $e) {
            die("Gagal mengupdate data manual: " . $e->getMessage());
        }
    }

    public function hapusNeracaManual() 
    {
        // Tangkap ID yang mau dihapus dan tahun buat redirect
        $id = $_POST['id'] ?? '';
        $tahun = $_POST['tahun'] ?? date('Y');

        if ($id) {
            try {
                $db = db();
                $sql = "DELETE FROM neraca_manual WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$id]);

                // Balikin ke halaman Neraca sesuai tahun aktif
                header("Location: " . url('/laporan/neraca?tahun=' . $tahun));
                exit;

            } catch (\Exception $e) {
                die("Gagal menghapus data manual: " . $e->getMessage());
            }
        }
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

    /**
     * Memastikan hanya Manager (ROLE_KETUA) yang dapat mengakses halaman Pembukuan BAU
     */
    private function requireManagerOnly()
    {
        if (Auth::role() !== ROLE_KETUA) {
            $this->redirect('/laporan', 'Akses ditolak. Menu ini hanya dapat diakses oleh Manager.', 'error');
        }
    }

    public function pembukuan()
    {
        $this->requireManagerOnly();
        $this->view('laporan/pembukuan', [
            'pageTitle' => 'Pembukuan BAU'
        ]);
    }

    public function pembukuanBuat()
    {
        $this->requireManagerOnly();
        $this->view('laporan/pembukuan_buat', [
            'pageTitle' => 'Buat Laporan BAU'
        ]);
    }

    public function pembukuanLihat()
    {
        $this->requireManagerOnly();
        $this->view('laporan/pembukuan_lihat', [
            'pageTitle' => 'Daftar Laporan BAU'
        ]);
    }

    public function cetakAnggotaPembukuan()
    {
        $this->requireManagerOnly();
        
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');
        $bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('m');
        $_SESSION['dashboard_selected_year'] = $tahun;
        $_SESSION['dashboard_selected_month'] = $bulan;

        $db = db();
        
        // Query Ringkasan Anggota (kumulatif simpanan kumulatif bulanan)
        $sql = "
            SELECT
                a.no_anggota,
                a.nama,
                a.tgl_daftar,
                GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as months_active,
                (50000 + (a.id * 1000)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_wajib,
                (10000 + (a.id * 500)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_pokok,
                (65000 + COALESCE(k.simpanan_sukarela_tambahan, 0)) as simpanan_sukarela,
                (15000 + (a.id * 150)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_belanja,
                (5000 + (a.id * 100)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_dana_sosial,
                COALESCE(k.simpanan_motor, 0) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_motor,
                COALESCE(k.simpanan_mobil, 0) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_mobil,
                (
                    ((50000 + (a.id * 1000)) + 
                     (10000 + (a.id * 500)) + 
                     (15000 + (a.id * 150)) + 
                     (5000 + (a.id * 100)) +
                     COALESCE(k.simpanan_motor, 0) +
                     COALESCE(k.simpanan_mobil, 0)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1)
                    + (65000 + COALESCE(k.simpanan_sukarela_tambahan, 0))
                ) as total
            FROM anggota a
            LEFT JOIN konfigurasi_simpanan_anggota k ON a.id = k.anggota_id
            WHERE a.status = 'AKTIF'
            AND (YEAR(a.tgl_daftar) < :tahun OR (YEAR(a.tgl_daftar) = :tahun AND MONTH(a.tgl_daftar) <= :bulan))
            GROUP BY a.id, a.no_anggota, a.nama, a.tgl_daftar, k.simpanan_motor, k.simpanan_mobil, k.simpanan_sukarela_tambahan
            ORDER BY total DESC
        ";

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'tahun' => $tahun,
            'bulan' => $bulan
        ]);
        $ringkasanAnggota = $stmt->fetchAll();

        // Render printable view without main layout wrapping
        $this->viewOnly('laporan/cetak_anggota', [
            'pageTitle' => 'Cetak Ringkasan Anggota',
            'ringkasanAnggota' => $ringkasanAnggota,
            'tahun' => $tahun,
            'bulan' => $bulan
        ]);
    }

    public function excelAnggotaPembukuan()
    {
        $this->requireManagerOnly();
        
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');
        $bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('m');
        $_SESSION['dashboard_selected_year'] = $tahun;
        $_SESSION['dashboard_selected_month'] = $bulan;

        $db = db();
        
        $sql = "
            SELECT
                a.no_anggota,
                a.nama,
                a.tgl_daftar,
                GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as months_active,
                (50000 + (a.id * 1000)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_wajib,
                (10000 + (a.id * 500)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_pokok,
                (65000 + COALESCE(k.simpanan_sukarela_tambahan, 0)) as simpanan_sukarela,
                (15000 + (a.id * 150)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_belanja,
                (5000 + (a.id * 100)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_dana_sosial,
                COALESCE(k.simpanan_motor, 0) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_motor,
                COALESCE(k.simpanan_mobil, 0) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_mobil,
                (
                    ((50000 + (a.id * 1000)) + 
                     (10000 + (a.id * 500)) + 
                     (15000 + (a.id * 150)) + 
                     (5000 + (a.id * 100)) +
                     COALESCE(k.simpanan_motor, 0) +
                     COALESCE(k.simpanan_mobil, 0)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1)
                    + (65000 + COALESCE(k.simpanan_sukarela_tambahan, 0))
                ) as total
            FROM anggota a
            LEFT JOIN konfigurasi_simpanan_anggota k ON a.id = k.anggota_id
            WHERE a.status = 'AKTIF'
            AND (YEAR(a.tgl_daftar) < :tahun OR (YEAR(a.tgl_daftar) = :tahun AND MONTH(a.tgl_daftar) <= :bulan))
            GROUP BY a.id, a.no_anggota, a.nama, a.tgl_daftar, k.simpanan_motor, k.simpanan_mobil, k.simpanan_sukarela_tambahan
            ORDER BY total DESC
        ";

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'tahun' => $tahun,
            'bulan' => $bulan
        ]);
        $ringkasanAnggota = $stmt->fetchAll();

        // Mendapatkan nama bulan dalam Bahasa Indonesia untuk berkas excel
        $namaBulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $namaBulan = $namaBulanList[$bulan] ?? date('F', mktime(0, 0, 0, $bulan, 10));
        $fileName = 'Ringkasan_Data_Anggota_' . $namaBulan . '_' . $tahun . '.xlsx';

        // Load Helper XLSXWriter
        require_once APP_PATH . '/helpers/xlsxwriter.class.php';
        
        $writer = new \XLSXWriter();
        $writer->setAuthor('Manager KSP');
        
        // Define Column Widths & Header Formats
        $header = [
            'NO' => 'integer',
            'NO. ANGGOTA' => 'string',
            'NAMA ANGGOTA' => 'string',
            'TOTAL KESELURUHAN' => '#,##0'
        ];
        // Suppress default header row because we want custom title rows above it
        $writer->writeSheetHeader('Laporan Bulanan', $header, ['widths' => [8, 20, 35, 25], 'suppress_row' => true]);

        // Title Rows
        $writer->writeSheetRow('Laporan Bulanan', ['RINGKASAN DATA ANGGOTA & SALDO', '', '', ''], ['font-style' => 'bold', 'font-size' => 14, 'halign' => 'center']);
        $writer->markMergedCell('Laporan Bulanan', 0, 0, 0, 3);
        
        $writer->writeSheetRow('Laporan Bulanan', ['Bulan Buku Laporan Keuangan: ' . strtoupper($namaBulan) . ' ' . $tahun, '', '', ''], ['halign' => 'center']);
        $writer->markMergedCell('Laporan Bulanan', 1, 0, 1, 3);
        
        $writer->writeSheetRow('Laporan Bulanan', ['', '', '', '']); // Blank row
        
        // Manual Header Row
        $writer->writeSheetRow('Laporan Bulanan', ['NO', 'NO. ANGGOTA', 'NAMA ANGGOTA', 'TOTAL KESELURUHAN'], ['font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom']);

        $no = 1;
        $totalAll = 0;
        $rowIndex = 4; // Data starts at row index 4 (0-based)

        foreach ($ringkasanAnggota as $row) {
            $totalAll += (float)$row['total'];
            $writer->writeSheetRow('Laporan Bulanan', [
                $no++,
                $row['no_anggota'],
                $row['nama'],
                (float)$row['total']
            ], ['border' => 'left,right,top,bottom']);
            $rowIndex++;
        }

        // Baris Total
        $writer->writeSheetRow('Laporan Bulanan', [
            'TOTAL KESELURUHAN',
            '',
            '',
            $totalAll
        ], ['font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom']);
        $writer->markMergedCell('Laporan Bulanan', $rowIndex, 0, $rowIndex, 2);

        // Membersihkan semua output buffer yang tertinggal agar file XLSX (ZIP) tidak corrupt
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $writer->writeToStdOut();
        exit;
    }

    public function apiRingkasanAnggota()
    {
        $this->requireManagerOnly();
        
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');
        $bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('m');
        
        $db = db();
        
        $sql = "
            SELECT
                a.no_anggota,
                a.nama,
                a.tgl_daftar,
                GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as months_active,
                (50000 + (a.id * 1000)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_wajib,
                (10000 + (a.id * 500)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_pokok,
                (65000 + COALESCE(k.simpanan_sukarela_tambahan, 0)) as simpanan_sukarela,
                (15000 + (a.id * 150)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_belanja,
                (5000 + (a.id * 100)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_dana_sosial,
                COALESCE(k.simpanan_motor, 0) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_motor,
                COALESCE(k.simpanan_mobil, 0) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1) as simpanan_mobil,
                (
                    ((50000 + (a.id * 1000)) + 
                     (10000 + (a.id * 500)) + 
                     (15000 + (a.id * 150)) + 
                     (5000 + (a.id * 100)) +
                     COALESCE(k.simpanan_motor, 0) +
                     COALESCE(k.simpanan_mobil, 0)) * GREATEST((:tahun - YEAR(a.tgl_daftar)) * 12 + (:bulan - MONTH(a.tgl_daftar)) + 1, 1)
                    + (65000 + COALESCE(k.simpanan_sukarela_tambahan, 0))
                ) as total
            FROM anggota a
            LEFT JOIN konfigurasi_simpanan_anggota k ON a.id = k.anggota_id
            WHERE a.status = 'AKTIF'
            AND (YEAR(a.tgl_daftar) < :tahun OR (YEAR(a.tgl_daftar) = :tahun AND MONTH(a.tgl_daftar) <= :bulan))
            GROUP BY a.id, a.no_anggota, a.nama, a.tgl_daftar, k.simpanan_motor, k.simpanan_mobil, k.simpanan_sukarela_tambahan
            ORDER BY total DESC
        ";

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'tahun' => $tahun,
            'bulan' => $bulan
        ]);
        $ringkasanAnggota = $stmt->fetchAll();
        
        successResponse('Success', [
            'ringkasan' => $ringkasanAnggota,
            'tahun' => $tahun,
            'bulan' => $bulan
        ]);
    }

    public function pembukuanKirim()
    {
        $this->requireManagerOnly();
        $this->view('laporan/pembukuan_kirim', [
            'pageTitle' => 'Kirim Laporan ke BAU'
        ]);
    }
}

