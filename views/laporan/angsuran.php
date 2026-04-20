<?php
$filterText = $filterText ?? 'Semua Waktu';
$angsuran = $angsuran ?? [];
?>

<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>">Laporan</a></li>
                <li class="breadcrumb-item active">Riwayat Angsuran</li>
            </ol>
        </nav>
        <h2 class="page-title"><?= e($pageTitle) ?></h2>
    </div>
</div>

<?php require '_filter_form.php'; ?>

<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tgl Pembayaran</th>
                        <th>Kode TRX</th>
                        <th>Anggota</th>
                        <th class="text-center">Angsuran Ke</th>
                        <th class="text-end">Pokok</th>
                        <th class="text-end">Bunga</th>
                        <th class="text-end">Total Bayar</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($angsuran)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Tidak ada data angsuran pada periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($angsuran as $a): ?>
                            <tr>
                                <td class="ps-4"><?= date('d/m/Y', strtotime($a['tanggal_bayar'])) ?></td>
                                <td><code>ANG-<?= str_pad($a['id'], 5, '0', STR_PAD_LEFT) ?></code><br><small class="text-muted">PJ-<?= str_pad($a['pinjaman_id'], 5, '0', STR_PAD_LEFT) ?></small></td>
                                <td><div class="fw-bold"><?= e($a['anggota_nama']) ?></div><small class="text-muted"><?= e($a['no_anggota']) ?></small></td>
                                <td class="text-center"><span class="badge bg-secondary rounded-circle"><?= $a['angsuran_ke'] ?></span></td>
                                <td class="text-end"><?= formatRupiah($a['pokok_bayar']) ?></td>
                                <td class="text-end"><?= formatRupiah($a['bunga_bayar']) ?></td>
                                <td class="text-end fw-bold text-success"><?= formatRupiah($a['total']) ?></td>
                                <td><?= e($a['keterangan'] ?: '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
