<?php
$filterText = $filterText ?? 'Semua Waktu';
$transaksi = $transaksi ?? [];
?>

<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>">Laporan</a></li>
                <li class="breadcrumb-item active">Riwayat Simpanan</li>
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
                        <th>Tgl Transaksi</th>
                        <th>Kode/ID</th>
                        <th>Anggota</th>
                        <th>Tipe</th>
                        <th class="text-end">Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transaksi)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data transaksi simpanan pada periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($transaksi as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                                <td><code>TRX-<?= str_pad($t['id'], 5, '0', STR_PAD_LEFT) ?></code><br><small class="text-muted"><?= e($t['no_anggota']) ?></small></td>
                                <td><div class="fw-bold"><?= e($t['anggota_nama']) ?></div></td>
                                <td>
                                    <?php if ($t['tipe'] == 'SETOR'): ?>
                                        <span class="badge bg-success">SETOR</span>
                                    <?php elseif ($t['tipe'] == 'TARIK'): ?>
                                        <span class="badge bg-danger">TARIK</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">TRANSFER</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end fw-medium"><?= formatRupiah($t['jumlah']) ?></td>
                                <td><?= e($t['keterangan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
