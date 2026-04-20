<?php
/**
 * SimpananTransaksi Model
 */

class SimpananTransaksi extends Model
{
    protected $table = 'simpanan_transaksi';

    /**
     * Get current saldo for a member
     */
    public function getSaldo($anggotaId)
    {
        $stmt = $this->db->prepare("SELECT saldo FROM v_saldo_simpanan WHERE anggota_id = ?");
        $stmt->execute([$anggotaId]);
        $row = $stmt->fetch();
        return $row ? (float) $row['saldo'] : 0;
    }

    /**
     * Log transaction to Buku Kas
     */
    public function logToKas($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO kas_transaksi (tanggal, tipe, sumber, ref_table, ref_id, jumlah, catatan, dibuat_oleh)
            VALUES (NOW(), ?, 'SIMPANAN', 'simpanan_transaksi', ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['tipe'],
            $data['ref_id'],
            $data['jumlah'],
            $data['catatan'],
            $data['dibuat_oleh']
        ]);
    }
}
