<?php
$filterText = $filterText ?? 'Semua Waktu';
$kas = $kas ?? [];
?>

<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>">Laporan</a></li>
                <li class="breadcrumb-item active">Arus Kas Utama</li>
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
                        <th class="ps-4">Tanggal Pembukuan</th>
                        <th>Kode KAS</th>
                        <th>Jenis Arus</th>
                        <th>Sumber Modul</th>
                        <th>Referensi ID</th>
                        <th class="text-end">Jumlah M/K</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kas)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada data pergerakan kas pada periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($kas as $k): ?>
                            <tr>
                                <td class="ps-4"><?= date('d/m/Y H:i', strtotime($k['tanggal'])) ?></td>
                                <td><code>KAS-<?= str_pad($k['id'], 6, '0', STR_PAD_LEFT) ?></code></td>
                                <td>
                                    <?php if ($k['tipe'] == 'KAS_MASUK'): ?>
                                        <span class="badge bg-success"><i class="bi bi-arrow-down-left-circle me-1"></i> MASUK</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bi bi-arrow-up-right-circle me-1"></i> KELUAR</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?= e($k['sumber']) ?></span></td>
                                <td><small class="text-muted"><?= e($k['ref_id'] ?: '-') ?></small></td>
                                <td class="text-end fw-bold <?= $k['tipe'] == 'KAS_MASUK' ? 'text-success' : 'text-danger' ?>">
                                    <?= $k['tipe'] == 'KAS_MASUK' ? '+' : '-' ?> <?= formatRupiah($k['jumlah']) ?>
                                </td>
                                <td><?= e($k['catatan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
