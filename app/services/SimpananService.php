<?php
/**
 * SimpananService
 * Menangani logika transaksi simpanan (Setor, Tarik, Transfer).
 */

class SimpananService
{
    private $db;

    public function __construct()
    {
        $this->db = db();
    }

    public function setor($anggotaId, $jumlah, $keterangan = null, $dibuatOleh = null)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                INSERT INTO simpanan_transaksi (anggota_id, tipe, jumlah, keterangan, dibuat_oleh)
                VALUES (?, 'SETOR', ?, ?, ?)
            ");
            $stmt->execute([$anggotaId, $jumlah, $keterangan, $dibuatOleh]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function tarik($anggotaId, $jumlah, $keterangan = null, $dibuatOleh = null)
    {
        try {
            // Cek saldo
            $saldo = $this->getSaldo($anggotaId);
            if ($saldo < $jumlah) {
                throw new Exception("Saldo tidak mencukupi. Saldo saat ini: " . formatRupiah($saldo));
            }

            $isNested = $this->db->inTransaction();
            if (!$isNested) {
                $this->db->beginTransaction();
            }

            $stmt = $this->db->prepare("
                INSERT INTO simpanan_transaksi (anggota_id, tipe, jumlah, keterangan, dibuat_oleh)
                VALUES (?, 'TARIK', ?, ?, ?)
            ");
            $stmt->execute([$anggotaId, $jumlah, $keterangan, $dibuatOleh]);

            if (!$isNested) {
                $this->db->commit();
            }
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    public function getSaldo($anggotaId)
    {
        $stmt = $this->db->prepare("SELECT saldo FROM v_saldo_simpanan WHERE anggota_id = ?");
        $stmt->execute([$anggotaId]);
        $result = $stmt->fetch();
        return $result ? (float) $result['saldo'] : 0;
    }
}
