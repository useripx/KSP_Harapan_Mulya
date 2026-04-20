<?php
/**
 * KasService
 * Menangani pencatatan transaksi kas koperasi.
 */

class KasService
{
    private $db;

    public function __construct()
    {
        $this->db = db();
    }

    /**
     * Mencatat transaksi kas
     * 
     * @param string $tipe KAS_MASUK / KAS_KELUAR
     * @param string $sumber Sumber transaksi (SIMPANAN, ANGSURAN, PENCAIRAN_PINJAMAN, OPERASIONAL)
     * @param string $refTable Tabel referensi sumber (opsional)
     * @param int $refId ID transaksi rujukan (opsional)
     * @param float $jumlah Nominal transaksi
     * @param string $catatan Keterangan
     * @param int $dibuatOleh ID User yang mencatat
     */
    public function catat($tipe, $sumber, $refTable, $refId, $jumlah, $catatan = null, $dibuatOleh = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO kas_transaksi (tipe, sumber, ref_table, ref_id, jumlah, catatan, dibuat_oleh, tanggal)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        return $stmt->execute([
            $tipe,
            $sumber,
            $refTable,
            $refId,
            $jumlah,
            $catatan,
            $dibuatOleh
        ]);
    }
}
