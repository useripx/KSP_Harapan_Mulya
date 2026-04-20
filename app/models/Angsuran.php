<?php
/**
 * Angsuran Model
 * Handles loan schedules and payment records
 */

class Angsuran extends Model
{
    /**
     * Get all schedules with member & loan details
     */
    public function getSchedules($filters = [])
    {
        $sql = "SELECT j.*, p.pokok, p.tenor_bulan, a.nama as anggota_nama, a.no_anggota, ans.id as payment_id
                FROM pinjaman_jadwal j
                JOIN pinjaman p ON j.pinjaman_id = p.id
                JOIN anggota a ON p.anggota_id = a.id
                LEFT JOIN angsuran ans ON (ans.pinjaman_id = j.pinjaman_id AND ans.angsuran_ke = j.angsuran_ke)";
        
        $params = [];
        if (!empty($filters)) {
            $clauses = [];
            foreach ($filters as $key => $val) {
                if ($key === 'status') {
                    $clauses[] = "j.status = ?";
                    $params[] = $val;
                } elseif ($key === 'anggota_id') {
                    $clauses[] = "p.anggota_id = ?";
                    $params[] = $val;
                }
            }
            if (!empty($clauses)) {
                $sql .= " WHERE " . implode(" AND ", $clauses);
            }
        }

        $sql .= " ORDER BY j.jatuh_tempo ASC, j.id ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Find a specific schedule by ID with loan info
     */
    public function findSchedule($id)
    {
        $sql = "SELECT j.*, p.pokok, p.bunga_persen_bln, a.nama as anggota_nama, a.no_anggota, a.id as anggota_id
                FROM pinjaman_jadwal j
                JOIN pinjaman p ON j.pinjaman_id = p.id
                JOIN anggota a ON p.anggota_id = a.id
                WHERE j.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get payment record by ID
     */
    public function findPayment($id)
    {
        $sql = "SELECT ans.*, p.id as pinjaman_id, a.nama as anggota_nama, a.no_anggota, u.name as penerima_nama
                FROM angsuran ans
                JOIN pinjaman p ON ans.pinjaman_id = p.id
                JOIN anggota a ON p.anggota_id = a.id
                LEFT JOIN users u ON ans.diterima_oleh = u.id
                WHERE ans.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
