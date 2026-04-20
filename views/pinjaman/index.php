<div class="mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h2 class="page-title">Daftar Pinjaman</h2>
        <p class="text-muted small">Kelola pengajuan dan pencairan pinjaman.</p>
    </div>
    <?php if (in_array(Auth::role(), [ROLE_ANGGOTA, ROLE_ADMIN, ROLE_TELLER])): ?>
        <a href="<?= url('/pinjaman/ajukan') ?>" class="btn btn-primary px-4 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Ajukan Pinjaman
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Data Pinjaman</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tgl Pengajuan</th>
                        <th>Anggota</th>
                        <th class="text-end">Pokok</th>
                        <th>Tenor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pinjaman)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data pinjaman</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pinjaman as $item): ?>
                            <tr>
                                <td>
                                    <?= formatTanggalShort($item['tgl_pengajuan']) ?>
                                </td>
                                <td>
                                    <div class="fw-medium">
                                        <?= e($item['nama']) ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= e($item['no_anggota']) ?>
                                    </div>
                                </td>
                                <td class="text-end fw-semibold">
                                    <?= formatRupiah($item['pokok']) ?>
                                </td>
                                <td>
                                    <?= $item['tenor_bulan'] ?> Bulan
                                </td>
                                <td>
                                    <?= getStatusBadge($item['status'], 'pinjaman') ?>
                                </td>
                                <td>
                                    <a href="<?= url('/pinjaman/' . $item['id']) ?>" class="btn btn-outline btn-sm">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>