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

    public function generateNoAnggota()
    {
        $datePrefix = date('ymd'); // Format: YYMMDD
        $yearPrefix = date('y');   // Format: YY

        // Cari nomor anggota terakhir di tahun yang sama dengan format 11 digit
        $sql = "SELECT no_anggota FROM anggota 
                WHERE no_anggota LIKE ? AND LENGTH(no_anggota) = 11 
                ORDER BY no_anggota DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$yearPrefix . '%']);
        $last = $stmt->fetch();

        if (!$last) {
            $num = 1;
        } else {
            // Ambil 5 digit terakhir sebagai nomor urutan di tahun ini
            $num = (int) substr($last['no_anggota'], 6) + 1;
        }

        return $datePrefix . str_pad($num, 5, '0', STR_PAD_LEFT);
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
