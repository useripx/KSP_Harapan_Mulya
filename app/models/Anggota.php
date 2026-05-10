<?php
/**
 * Anggota Model
 */

class Anggota extends Model
{
    protected $table = 'anggota';

    public function getAllWithUser()
    {
        return $this->query("
            SELECT a.*, u.username, u.email as user_email
            FROM anggota a
            LEFT JOIN users u ON a.user_id = u.id
            ORDER BY a.no_anggota ASC
        ");
    }

    public function generateNoAnggota($nama = '')
    {
        $nama = trim($nama);
        $initials = !empty($nama) ? strtoupper(substr($nama, 0, 1)) : 'X';

        // Cari nomor anggota terakhir dengan inisial ini menggunakan REGEXP agar presisi
        $sql = "SELECT no_anggota FROM anggota 
                WHERE no_anggota REGEXP ?
                ORDER BY CAST(SUBSTRING(no_anggota, ?) AS UNSIGNED) DESC LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        // Pattern: Starts with initials, followed by numbers
        $stmt->execute(['^' . $initials . '[0-9]+$', strlen($initials) + 1]);
        $last = $stmt->fetch();

        if (!$last) {
            $num = 1;
        } else {
            $lastNumStr = substr($last['no_anggota'], strlen($initials));
            $num = (int)$lastNumStr + 1;
        }

        return $initials . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    public function search($query)
    {
        $sql = "SELECT id, no_anggota, nama FROM anggota 
                WHERE (nama LIKE ? OR no_anggota LIKE ?) AND status = 'AKTIF'
                LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%$query%", "%$query%"]);
        return $stmt->fetchAll();
    }
}
