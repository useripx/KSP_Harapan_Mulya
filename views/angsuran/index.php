<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="page-title">Daftar Angsuran & Tagihan</h2>
        <p class="text-muted">Monitor jadwal jatuh tempo dan status pembayaran angsuran.</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No. Anggota</th>
                        <th>Nama Anggota</th>
                        <th>Pinj #</th>
                        <th>Ke</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($schedules)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Tidak ada data angsuran.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($schedules as $row): ?>
                            <tr>
                                <td class="ps-4"><code><?= e($row['no_anggota']) ?></code></td>
                                <td>
                                    <div class="fw-bold"><?= e($row['anggota_nama']) ?></div>
                                </td>
                                <td>#<?= $row['pinjaman_id'] ?></td>
                                <td><span class="badge bg-light text-dark"><?= $row['angsuran_ke'] ?></span></td>
                                <td>
                                    <?php 
                                        $isOverdue = ($row['status'] === 'BELUM' && $row['jatuh_tempo'] < date('Y-m-d'));
                                    ?>
                                    <span class="<?= $isOverdue ? 'text-danger fw-bold' : '' ?>">
                                        <?= formatTanggalShort($row['jatuh_tempo']) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-medium"><?= formatRupiah($row['total_tagih']) ?></td>
                                <td class="text-center">
                                    <?php if ($row['status'] === 'BAYAR'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">LUNAS</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">BELUM</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if ($row['status'] === 'BELUM' && in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER])): ?>
                                        <a href="<?= url('/angsuran/bayar/' . $row['id']) ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                                            <i class="bi bi-cash me-1"></i> Bayar
                                        </a>
                                    <?php elseif ($row['status'] === 'BAYAR'): ?>
                                        <a href="<?= url('/angsuran/' . $row['payment_id']) ?>" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                            <i class="bi bi-printer me-1"></i> Lihat Kuitansi
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
