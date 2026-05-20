<?php
/**
 * Pinjaman Model
 */

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    /**
     * Get loan with member details
     */
    public function findWithAnggota($id)
    {
        $sql = "SELECT p.*, a.nama, a.no_anggota, a.tipe as anggota_tipe, a.identitas_no, a.no_hp, a.tgl_daftar,
                       u1.name as verifikasi_oleh_nama,
                       u2.name as approve_oleh_nama,
                       u3.name as cair_oleh_nama
                FROM pinjaman p
                JOIN anggota a ON p.anggota_id = a.id
                LEFT JOIN users u1 ON p.verifikasi_oleh = u1.id
                LEFT JOIN users u2 ON p.approve_oleh = u2.id
                LEFT JOIN users u3 ON p.cair_oleh = u3.id
                WHERE p.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get loan schedule
     */
    public function getJadwal($pinjamanId)
    {
        $sql = "SELECT * FROM pinjaman_jadwal 
                WHERE pinjaman_id = ? 
                ORDER BY angsuran_ke ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$pinjamanId]);
        return $stmt->fetchAll();
    }

    /**
     * Get loan summary from view
     */
    public function getSummary($id)
    {
        $sql = "SELECT * FROM v_ringkasan_pinjaman WHERE pinjaman_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
