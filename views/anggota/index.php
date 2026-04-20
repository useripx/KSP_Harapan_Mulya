<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Anggota</h5>
        <a href="<?= url('/anggota/create') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah Anggota
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($anggota)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data anggota</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($anggota as $item): ?>
                            <tr>
                                <td>
                                    <?= e($item['no_anggota']) ?>
                                </td>
                                <td>
                                    <?= e($item['nama']) ?>
                                </td>
                                <td>
                                    <?= e($item['tipe']) ?>
                                </td>
                                <td>
                                    <?= e($item['no_hp']) ?>
                                </td>
                                <td>
                                    <?= getStatusBadge($item['status'], 'anggota') ?>
                                </td>
                                <td>
                                    <a href="<?= url('/anggota/' . $item['id']) ?>" class="btn btn-info btn-sm">Detail</a>
                                    <a href="<?= url('/anggota/' . $item['id'] . '/edit') ?>"
                                        class="btn btn-warning btn-sm">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>