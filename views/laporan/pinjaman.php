<?php
$filterText = $filterText ?? 'Semua Waktu';
$loans = $loans ?? [];
?>

<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>">Laporan</a></li>
                <li class="breadcrumb-item active">Riwayat Pinjaman</li>
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
                        <th class="ps-4">Tgl Pengajuan</th>
                        <th>Kode/ID</th>
                        <th>Anggota</th>
                        <th class="text-end">Jumlah Pokok</th>
                        <th class="text-center">Tenor</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($loans)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data riwayat pinjaman pada periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($loans as $loan): ?>
                            <tr>
                                <td class="ps-4"><?= date('d/m/Y', strtotime($loan['created_at'])) ?></td>
                                <td><code>PJ-<?= str_pad($loan['id'], 5, '0', STR_PAD_LEFT) ?></code><br><small class="text-muted"><?= e($loan['no_anggota']) ?></small></td>
                                <td><div class="fw-bold"><?= e($loan['anggota_nama']) ?></div></td>
                                <td class="text-end fw-medium"><?= formatRupiah($loan['pokok']) ?></td>
                                <td class="text-center"><?= $loan['tenor_bulan'] ?> Bln</td>
                                <td class="text-center">
                                    <?php
                                    $statusClass = [
                                        'PENDING' => 'bg-warning',
                                        'DIVERIFIKASI' => 'bg-info',
                                        'DISETUJUI' => 'bg-primary',
                                        'DICAIRKAN' => 'bg-success',
                                        'DITOLAK' => 'bg-danger',
                                        'LUNAS' => 'bg-secondary'
                                    ][$loan['status']] ?? 'bg-light text-dark';
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= $loan['status'] ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
