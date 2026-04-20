<?php

class CreditScoreService
{
    /**
     * Menghitung Credit Score untuk menentukan kelayakan pinjaman
     * 
     * @param int $anggotaId ID Anggota
     * @param float $pokokPinjaman Nominal pinjaman yang diajukan
     * @return array Data score, status, dan riwayat
     */
    public static function calculateScore($anggotaId, $pokokPinjaman)
    {
        $db = db();
        $score = 100;
        $reasons = [];

        // 1. Cek Tunggakan Aktif saat ini
        $stmtTunggakan = $db->prepare("SELECT COUNT(*) as jml, SUM(total_tagih) as total 
                                     FROM v_tunggakan 
                                     WHERE anggota_id = ?");
        $stmtTunggakan->execute([$anggotaId]);
        $tunggakan = $stmtTunggakan->fetch();

        if ($tunggakan && $tunggakan['jml'] > 0) {
            $potongan = $tunggakan['jml'] * 30;
            $score -= $potongan;
            $reasons[] = [
                'type' => 'danger',
                'text' => "Memiliki {$tunggakan['jml']} tunggakan aktif sebesar " . formatRupiah($tunggakan['total']) . " (-{$potongan} Poin)"
            ];
        } else {
            $reasons[] = [
                'type' => 'success',
                'text' => "Tidak memiliki tunggakan/kredit macet saat ini."
            ];
        }

        // 2. Cek Riwayat Denda / Telat Pembayaran Masa Lalu
        $stmtDenda = $db->prepare("SELECT COUNT(*) as jml, SUM(denda) as total_denda 
                                 FROM angsuran a 
                                 JOIN pinjaman p ON a.pinjaman_id = p.id 
                                 WHERE p.anggota_id = ? AND a.denda > 0");
        $stmtDenda->execute([$anggotaId]);
        $riwayatDenda = $stmtDenda->fetch();

        if ($riwayatDenda && $riwayatDenda['jml'] > 0) {
            $potonganDenda = $riwayatDenda['jml'] * 10;
            $score -= $potonganDenda;
            $reasons[] = [
                'type' => 'warning',
                'text' => "Memiliki {$riwayatDenda['jml']} riwayat telat bayar / kena denda secara historis (-{$potonganDenda} Poin)."
            ];
        } else {
            $reasons[] = [
                'type' => 'success',
                'text' => "Riwayat pembayaran angsuran bersih dari denda/keterlambatan."
            ];
        }

        // 3. Rasio Saldo Simpanan vs Pokok Pinjaman
        $stmtSaldo = $db->prepare("SELECT saldo FROM v_saldo_simpanan WHERE anggota_id = ?");
        $stmtSaldo->execute([$anggotaId]);
        $saldoData = $stmtSaldo->fetch();
        $saldo = $saldoData ? $saldoData['saldo'] : 0;

        if ($pokokPinjaman > 0) {
            $rasio = $saldo / $pokokPinjaman;
            // Maksimal nambah 20 poin
            $bonusRasio = min(20, round($rasio * 20));
            $score += $bonusRasio;

            if ($bonusRasio > 0) {
                $reasons[] = [
                    'type' => 'info',
                    'text' => "Kekuatan saldo simpanan (" . formatRupiah($saldo) . ") memberikan tambahan poin (+{$bonusRasio} Poin)."
                ];
            } else {
                $reasons[] = [
                    'type' => 'secondary',
                    'text' => "Kekuatan saldo simpanan (" . formatRupiah($saldo) . ") tergolong minim dibanding pinjaman ini."
                ];
            }
        }

        if ($score < 0) {
            $score = 0;
        }

        // Tentukan Kategori & Rekomendasi
        $kategori = '';
        $kategoriColor = '';
        if ($score >= 80) {
            $kategori = 'Sangat Layak';
            $kategoriColor = 'success';
        } elseif ($score >= 60) {
            $kategori = 'Layak';
            $kategoriColor = 'primary';
        } elseif ($score >= 40) {
            $kategori = 'Beresiko / Dipertimbangkan';
            $kategoriColor = 'warning';
        } else {
            $kategori = 'Tidak Layak';
            $kategoriColor = 'danger';
        }

        return [
            'score' => $score,
            'kategori' => $kategori,
            'color' => $kategoriColor,
            'reasons' => $reasons,
            'saldo' => $saldo
        ];
    }
}
