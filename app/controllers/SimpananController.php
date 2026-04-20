<?php
/**
 * SimpananController
 */

class SimpananController extends Controller
{
    private $simpananModel;
    private $anggotaModel;

    public function __construct()
    {
        parent::__construct();
        Auth::requireLogin();
        require_once APP_PATH . '/models/SimpananTransaksi.php';
        require_once APP_PATH . '/models/Anggota.php';
        $this->simpananModel = new SimpananTransaksi();
        $this->anggotaModel = new Anggota();
    }

    public function index()
    {
        $db = db();
        $userRole = Auth::role();
        $userId = Auth::id();

        $sql = "SELECT st.*, a.nama, a.no_anggota 
                FROM simpanan_transaksi st
                JOIN anggota a ON st.anggota_id = a.id";

        if ($userRole === ROLE_ANGGOTA) {
            $sql .= " WHERE a.user_id = " . (int) $userId;
        }

        $sql .= " ORDER BY st.tanggal DESC";

        $transaksi = $db->query($sql)->fetchAll();

        // Get Summary Stats
        $stats = [
            'total_saldo' => $this->getTotalSaldo($userRole, $userId),
            'total_setor' => $this->getTotalTipe('SETOR', $userRole, $userId),
            'total_tarik' => $this->getTotalTipe('TARIK', $userRole, $userId),
        ];

        $this->view('simpanan/index', [
            'pageTitle' => 'Transaksi Simpanan',
            'transaksi' => $transaksi,
            'stats' => $stats
        ]);
    }

    public function setor()
    {
        $anggota = $this->anggotaModel->all('nama ASC');
        $this->view('simpanan/setor', [
            'pageTitle' => 'Setor Simpanan',
            'anggota' => $anggota
        ]);
    }

    public function prosesSetor()
    {
        if (!$this->isPost()) $this->redirect('/simpanan');

        $data = $this->post();
        $errors = $this->validate($data, [
            'anggota_id' => 'required',
            'jumlah' => 'required|numeric'
        ]);

        if (!empty($errors)) {
            View::setErrors($errors);
            $this->redirect('/simpanan/setor', 'Harap lengkapi form dengan benar.', 'error');
        }

        try {
            $transId = $this->simpananModel->insert([
                'anggota_id' => $data['anggota_id'],
                'tipe' => 'SETOR',
                'tanggal' => date('Y-m-d H:i:s'),
                'jumlah' => $data['jumlah'],
                'keterangan' => $data['keterangan'] ?? '',
                'dibuat_oleh' => Auth::id()
            ]);

            if ($transId) {
                // Log to Kas
                $this->simpananModel->logToKas([
                    'tipe' => 'KAS_MASUK',
                    'ref_id' => $transId,
                    'jumlah' => $data['jumlah'],
                    'catatan' => "Setoran simpanan: " . ($data['keterangan'] ?? ''),
                    'dibuat_oleh' => Auth::id()
                ]);

                // Kirim Notifikasi ke Anggota ybs
                $anggotaData = $this->anggotaModel->find($data['anggota_id']);
                if ($anggotaData && !empty($anggotaData['user_id'])) {
                    sendNotifikasi(
                        $anggotaData['user_id'],
                        'success',
                        'bi-piggy-bank',
                        'Simpanan Berhasil Masuk',
                        "Selamat! Saldo Anda masuk sebesar " . formatRupiah($data['jumlah']),
                        url('/simpanan')
                    );
                }
            }

            $this->redirect('/simpanan', 'Setoran berhasil disimpan.', 'success');
        } catch (Exception $e) {
            $this->redirect('/simpanan/setor', 'Gagal menyimpan setoran: ' . $e->getMessage(), 'error');
        }
    }

    public function tarik()
    {
        $anggota = $this->anggotaModel->all('nama ASC');
        $this->view('simpanan/tarik', [
            'pageTitle' => 'Tarik Simpanan',
            'anggota' => $anggota
        ]);
    }

    public function prosesTarik()
    {
        if (!$this->isPost()) $this->redirect('/simpanan');

        $data = $this->post();
        $errors = $this->validate($data, [
            'anggota_id' => 'required',
            'jumlah' => 'required|numeric'
        ]);

        if (!empty($errors)) {
            View::setErrors($errors);
            $this->redirect('/simpanan/tarik', 'Harap lengkapi form dengan benar.', 'error');
        }

        // Check Saldo
        $currentSaldo = $this->simpananModel->getSaldo($data['anggota_id']);
        if ($currentSaldo < $data['jumlah']) {
            $this->redirect('/simpanan/tarik', 'Saldo tidak mencukupi. Saldo saat ini: ' . formatRupiah($currentSaldo), 'error');
        }

        try {
            $transId = $this->simpananModel->insert([
                'anggota_id' => $data['anggota_id'],
                'tipe' => 'TARIK',
                'tanggal' => date('Y-m-d H:i:s'),
                'jumlah' => $data['jumlah'],
                'keterangan' => $data['keterangan'] ?? '',
                'dibuat_oleh' => Auth::id()
            ]);

            if ($transId) {
                // Log to Kas
                $this->simpananModel->logToKas([
                    'tipe' => 'KAS_KELUAR',
                    'ref_id' => $transId,
                    'jumlah' => $data['jumlah'],
                    'catatan' => "Penarikan simpanan: " . ($data['keterangan'] ?? ''),
                    'dibuat_oleh' => Auth::id()
                ]);

                // Kirim Notifikasi ke Anggota ybs
                $anggotaData = $this->anggotaModel->find($data['anggota_id']);
                if ($anggotaData && !empty($anggotaData['user_id'])) {
                    sendNotifikasi(
                        $anggotaData['user_id'],
                        'danger',
                        'bi-cash-stack',
                        'Penarikan Berhasil',
                        "Anda telah menarik saldo sebesar " . formatRupiah($data['jumlah']),
                        url('/simpanan')
                    );
                }
            }

            $this->redirect('/simpanan', 'Penarikan berhasil disimpan.', 'success');
        } catch (Exception $e) {
            $this->redirect('/simpanan/tarik', 'Gagal menyimpan penarikan: ' . $e->getMessage(), 'error');
        }
    }

    private function getTotalSaldo($role, $userId)
    {
        $db = db();
        if ($role === ROLE_ANGGOTA) {
            $stmt = $db->prepare("SELECT saldo FROM v_saldo_simpanan v JOIN anggota a ON v.anggota_id = a.id WHERE a.user_id = ?");
            $stmt->execute([$userId]);
            $res = $stmt->fetch();
            return $res ? (float) $res['saldo'] : 0;
        } else {
            $res = $db->query("SELECT SUM(saldo) as total FROM v_saldo_simpanan")->fetch();
            return (float) $res['total'];
        }
    }

    private function getTotalTipe($tipe, $role, $userId)
    {
        $db = db();
        $sql = "SELECT SUM(jumlah) as total FROM simpanan_transaksi st";
        if ($role === ROLE_ANGGOTA) {
            $sql .= " JOIN anggota a ON st.anggota_id = a.id WHERE st.tipe = '$tipe' AND a.user_id = " . (int) $userId;
        } else {
            $sql .= " WHERE tipe = '$tipe'";
        }
        $res = $db->query($sql)->fetch();
        return (float) $res['total'];
    }
}
