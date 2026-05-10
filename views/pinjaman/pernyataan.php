<div class="container-fluid mb-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class="h3 mb-0 text-gray-800 fw-bold"><i class="bi bi-printer text-primary me-2"></i>Cetak Surat Pernyataan</h2>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pengajuan</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Tenor</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($pinjaman)): ?>
                            <tr><td colspan="6" class="text-center text-muted">Belum ada riwayat pengajuan pinjaman.</td></tr>
                        <?php else: ?>
                            <?php foreach($pinjaman as $row): ?>
                            <tr>
                                <td class="fw-bold">#<?= $row['id'] ?></td>
                                <td><?= date('d M Y', strtotime($row['tgl_pengajuan'])) ?></td>
                                <td class="text-success fw-bold"><?= formatRupiah($row['pokok']) ?></td>
                                <td><?= $row['tenor_bulan'] ?> Bulan</td>
                                <td>
                                    <span class="badge bg-<?= $row['status'] === 'DIAJUKAN' ? 'warning' : ($row['status'] === 'DISETUJUI' ? 'primary' : ($row['status'] === 'BERJALAN' ? 'success' : 'secondary')) ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Buka Tab Baru untuk Print -->
                                    <a href="<?= url('/pinjaman/cetaksurat/' . $row['id']) ?>" target="_blank" class="btn btn-sm btn-outline-primary fw-medium">
                                        <i class="bi bi-file-pdf-fill me-1"></i> Cetak PDF
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>