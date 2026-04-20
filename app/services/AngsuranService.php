<?php
/**
 * AngsuranService
 * Menangani logika pembayaran angsuran, denda, dan autodebet.
 */

class AngsuranService
{
    private $db;

    public function __construct()
    {
        $this->db = db();
    }

    /**
     * Memproses semua jadwal angsuran yang jatuh tempo hari ini atau sebelumnya
     * Jika saldo simpanan anggota mencukupi, sistem akan melakukan debet otomatis
     * 
     * @return array Report hasil pemrosesan
     */
    public function prosesAutodebetHarian()
    {
        // Panggil service lain yang dibutuhkan
        require_once APP_PATH . '/services/SimpananService.php';
        require_once APP_PATH . '/services/KasService.php';
        $simpananService = new SimpananService();
        $kasService = new KasService();

        $hasil = [
            'total_diperiksa' => 0,
            'berhasil_debet' => 0,
            'gagal_saldo_kurang' => 0,
            'errors' => []
        ];

        try {
            // Cari jadwal yang BELUM lunas dan tenggatnya sudah sampai hari ini atau lewat
            $sql = "SELECT pj.*, p.anggota_id, a.nama as nama_anggota 
                    FROM pinjaman_jadwal pj
                    JOIN pinjaman p ON pj.pinjaman_id = p.id
                    JOIN anggota a ON p.anggota_id = a.id
                    WHERE pj.status = 'BELUM' 
                    AND pj.jatuh_tempo <= CURRENT_DATE()
                    AND p.status = 'BERJALAN'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $jadwalJatuhTempo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $hasil['total_diperiksa'] = count($jadwalJatuhTempo);

            foreach ($jadwalJatuhTempo as $jadwal) {
                // Total tagihan bulan ini
                $totalTagih = $jadwal['total_tagih'];
                $anggotaId = $jadwal['anggota_id'];

                // 1. Cek saldo anggota
                $saldo = $simpananService->getSaldo($anggotaId);

                if ($saldo >= $totalTagih) {
                    try {
                        // Saldo CUKUP, lakukan autodebet
                        $this->db->beginTransaction();

                        // 2. Tarik simpanan anggota
                        $keteranganTarik = "Autodebet Angsuran ke-{$jadwal['angsuran_ke']} (Pinjaman ID:{$jadwal['pinjaman_id']})";
                        // null untuk admin/sistem, bisa disesuaikan siapa yang membuat (dibuatOleh)
                        $simpananService->tarik($anggotaId, $totalTagih, $keteranganTarik, null);

                        // 3. Catat pembayaran di tabel angsuran
                        $sqlBayar = "INSERT INTO angsuran (pinjaman_id, angsuran_ke, tanggal_bayar, pokok_bayar, bunga_bayar, denda, total, diterima_oleh, keterangan) 
                                     VALUES (?, ?, CURRENT_DATE(), ?, ?, 0, ?, NULL, ?)";
                        $stmtBayar = $this->db->prepare($sqlBayar);
                        $stmtBayar->execute([
                            $jadwal['pinjaman_id'], 
                            $jadwal['angsuran_ke'], 
                            $jadwal['pokok_tagih'], 
                            $jadwal['bunga_tagih'], 
                            $totalTagih, 
                            "Lunas by Autodebet Sistem"
                        ]);
                        $angsuranId = $this->db->lastInsertId();

                        // 4. Update status jadwal menjadi BAYAR
                        $sqlUpdate = "UPDATE pinjaman_jadwal SET status = 'BAYAR' WHERE id = ?";
                        $stmtUpdate = $this->db->prepare($sqlUpdate);
                        $stmtUpdate->execute([$jadwal['id']]);

                        // 5. Masukkan ke Buku Kas (KAS_MASUK dari sumber ANGSURAN)
                        $kasService->catat(
                            'KAS_MASUK', 
                            'ANGSURAN', 
                            'angsuran', 
                            $angsuranId, 
                            $totalTagih, 
                            "Pembayaran Autodebet An. {$jadwal['nama_anggota']} (Angsuran ke-{$jadwal['angsuran_ke']})", 
                            null
                        );

                        // Cek apakah ini angsuran terakhir / pinjaman sudah lunas semua
                        $this->cekPelunasanPinjaman($jadwal['pinjaman_id']);

                        $this->db->commit();
                        $hasil['berhasil_debet']++;

                    } catch (Exception $ex) {
                        if($this->db->inTransaction()) {
                            $this->db->rollBack();
                        }
                        $hasil['errors'][] = "Gagal memproses ID Jadwal {$jadwal['id']}: " . $ex->getMessage();
                    }
                } else {
                    // Saldo TIDAK CUKUP
                    $hasil['gagal_saldo_kurang']++;
                }
            }

            return $hasil;

        } catch (Exception $e) {
            $hasil['errors'][] = "Terjadi kesalahan sistem: " . $e->getMessage();
            return $hasil;
        }
    }

    /**
     * Memeriksa dan mengupdate status pinjaman jika seluruh jadwal sudah BAYAR
     */
    private function cekPelunasanPinjaman($pinjamanId)
    {
        $stmtCek = $this->db->prepare("SELECT COUNT(*) as sisa FROM pinjaman_jadwal WHERE pinjaman_id = ? AND status = 'BELUM'");
        $stmtCek->execute([$pinjamanId]);
        $sisa = $stmtCek->fetch(PDO::FETCH_ASSOC)['sisa'];

        if ($sisa == 0) {
            $stmtLunas = $this->db->prepare("UPDATE pinjaman SET status = 'LUNAS' WHERE id = ?");
            $stmtLunas->execute([$pinjamanId]);
        }
    }
}
