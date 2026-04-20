<!-- Welcome Message -->
<div class="mb-5">
    <h2 class="page-title" style="font-size: 28px; letter-spacing: -0.04em;">Ringkasan Sistem</h2>
    <p class="text-muted" style="font-size: 15px;">Pantau performa koperasi dalam satu tampilan cerdas.</p>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="stat-icon-wrapper">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="stat-label">Total Simpanan</div>
            <div class="stat-value"><?= formatRupiah($stats['total_simpanan']) ?></div>
            <div class="stat-footer mt-2">
                <span class="text-success fw-bold"><i class="bi bi-graph-up-arrow"></i> +12%</span>
                <span>pertumbuhan</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="stat-icon-wrapper text-primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-label">Anggota Aktif</div>
            <div class="stat-value"><?= number_format($stats['total_anggota']) ?></div>
            <div class="stat-footer mt-2">
                <span class="badge bg-success-subtle">+<?= $stats['anggota_baru_bulan_ini'] ?> Baru</span>
                <span>bulan ini</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="stat-icon-wrapper text-info">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="stat-label">Pinjaman Berjalan</div>
            <div class="stat-value"><?= number_format($stats['total_pinjaman_aktif']) ?></div>
            <div class="stat-footer mt-2">
                <span>Status: Aktif</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="stat-icon-wrapper text-danger">
                <i class="bi bi-exclamation-circle"></i>
            </div>
            <div class="stat-label">Total Tunggakan</div>
            <div class="stat-value text-danger"><?= number_format($stats['total_tunggakan']) ?></div>
            <div class="stat-footer mt-2">
                <span>Butuh perhatian</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Transactions -->
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Aktivitas Terakhir</h5>
                    <p class="card-description-text">Simpanan, Angsuran, dan Pencairan terbaru.</p>
                </div>
                <a href="<?= url('/laporan') ?>" class="btn btn-outline text-primary border-primary">Lihat Laporan</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th>Tipe</th>
                                <th>Tanggal</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentTransactions)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Belum ada transaksi</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recentTransactions as $trx): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-semibold"><?= e($trx['nama']) ?></div>
                                            <div class="text-muted small"><?= e($trx['no_anggota']) ?></div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <span class="badge border bg-light text-dark"
                                                    style="font-size: 10px; width: fit-content;"><?= e($trx['kategori']) ?></span>
                                                <?php
                                                $badgeClass = 'bg-info';
                                                if ($trx['tipe'] === 'SETOR' || $trx['tipe'] === 'MASUK')
                                                    $badgeClass = 'bg-success';
                                                if ($trx['tipe'] === 'TARIK' || $trx['tipe'] === 'KELUAR')
                                                    $badgeClass = 'bg-danger';
                                                ?>
                                                <span class="badge <?= $badgeClass ?>" style="width: fit-content;">
                                                    <?= e($trx['tipe']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td><?= formatTanggalShort($trx['tanggal']) ?></td>
                                        <td
                                            class="text-end fw-bold <?= ($trx['tipe'] === 'TARIK' || $trx['tipe'] === 'KELUAR') ? 'text-danger' : 'text-success' ?>">
                                            <?= ($trx['tipe'] === 'TARIK' || $trx['tipe'] === 'KELUAR') ? '-' : '+' ?>
                                            <?= formatRupiah($trx['jumlah']) ?>
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

    <!-- Quick Actions -->
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Aksi Cepat</h5>
                <p class="card-description-text">Lakukan transaksi dengan satu klik.</p>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="<?= url('/simpanan/setor') ?>"
                            class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center gap-2 shadow-sm">
                            <i class="bi bi-plus-circle fs-4"></i>
                            <span>Setor Simpanan</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= url('/simpanan/tarik') ?>"
                            class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center gap-2 shadow-sm">
                            <i class="bi bi-dash-circle fs-4"></i>
                            <span>Tarik Simpanan</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= url('/pinjaman/ajukan') ?>"
                            class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center gap-2 shadow-sm">
                            <i class="bi bi-file-earmark-plus fs-4"></i>
                            <span>Ajukan Pinjaman</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= url('/angsuran/bayar') ?>"
                            class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center gap-2 shadow-sm">
                            <i class="bi bi-cash-stack fs-4"></i>
                            <span>Bayar Angsuran</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Status Pinjaman</h5>
                <p class="card-description-text">Perbandingan status pinjaman.</p>
            </div>
            <div class="card-body">
                <canvas id="pinjamanChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pinjamanCtx = document.getElementById('pinjamanChart').getContext('2d');
        const pinjamanData = <?= json_encode($pinjamanByStatus) ?>;

        new Chart(pinjamanCtx, {
            type: 'doughnut',
            data: {
                labels: pinjamanData.map(d => d.status),
                datasets: [{
                    data: pinjamanData.map(d => d.jumlah),
                    backgroundColor: [
                        '#2563eb',
                        '#3b82f6',
                        '#60a5fa',
                        '#93c5fd',
                        '#bfdbfe',
                        '#dbeafe',
                        '#eff6ff'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            font: { size: 11, family: 'Inter' }
                        }
                    }
                },
                cutout: '75%'
            }
        });
    });
</script>