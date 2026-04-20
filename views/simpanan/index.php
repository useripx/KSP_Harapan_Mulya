<div class="mb-4">
    <h2 class="page-title">Simpanan Anggota</h2>
    <p class="text-muted small">Kelola dan pantau saldo simpanan anggota.</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Saldo</span>
                <i class="bi bi-bank stat-icon"></i>
            </div>
            <div class="stat-value">
                <?= formatRupiah($stats['total_saldo']) ?>
            </div>
            <div class="stat-footer text-success">Saldo saat ini</div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Setoran</span>
                <i class="bi bi-arrow-down-left stat-icon text-success"></i>
            </div>
            <div class="stat-value">
                <?= formatRupiah($stats['total_setor']) ?>
            </div>
            <div class="stat-footer">Akumulasi setoran</div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Penarikan</span>
                <i class="bi bi-arrow-up-right stat-icon text-destructive"></i>
            </div>
            <div class="stat-value text-destructive">
                <?= formatRupiah($stats['total_tarik']) ?>
            </div>
            <div class="stat-footer">Akumulasi penarikan</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title">Riwayat Transaksi</h5>
            <p class="card-description">Daftar semua mutasi simpanan.</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (Auth::role() !== ROLE_ANGGOTA): ?>
                <a href="<?= url('/simpanan/setor') ?>" class="btn btn-primary btn-sm">Setor</a>
                <a href="<?= url('/simpanan/tarik') ?>" class="btn btn-outline btn-sm">Tarik</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Anggota</th>
                        <th>Tipe</th>
                        <th class="text-end">Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transaksi)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada transaksi</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transaksi as $trx): ?>
                            <tr>
                                <td>
                                    <?= formatDateTime($trx['tanggal']) ?>
                                </td>
                                <td>
                                    <div class="fw-medium">
                                        <?= e($trx['nama']) ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= e($trx['no_anggota']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge <?= $trx['tipe'] === 'SETOR' ? 'bg-success' : ($trx['tipe'] === 'TARIK' ? 'bg-danger' : 'bg-info') ?>">
                                        <?= e($trx['tipe']) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">
                                    <?= formatRupiah($trx['jumlah']) ?>
                                </td>
                                <td class="text-muted small">
                                    <?= e($trx['keterangan'] ?: '-') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>