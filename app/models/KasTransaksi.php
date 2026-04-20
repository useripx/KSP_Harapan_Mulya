<?php
/**
 * KasTransaksi Model
 */

class KasTransaksi extends Model
{
    protected $table = 'kas_transaksi';

    /**
     * Log a cash transaction
     * 
     * @param string $type Tipe: 'KAS_MASUK' atau 'KAS_KELUAR'
     * @param float $jumlah Nominal
     * @param string $sumber Sumber (e.g. 'SIMPANAN', 'PENCAIRAN_PINJAMAN')
     * @param string $keterangan Deskripsi
     * @param string|null $refTable Nama tabel referensi
     * @param int|null $refId ID referensi
     * @return int Insert ID
     */
    public function log($type, $jumlah, $sumber, $keterangan, $refTable = null, $refId = null)
    {
        // Insert transaction
        return $this->insert([
            'tanggal' => date('Y-m-d H:i:s'),
            'tipe' => $type,
            'sumber' => $sumber,
            'jumlah' => $jumlah,
            'catatan' => $keterangan,
            'ref_table' => $refTable,
            'ref_id' => $refId,
            'dibuat_oleh' => Auth::id()
        ]);
    }
}
