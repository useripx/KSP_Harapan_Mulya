<div class="container-fluid mb-4">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h3 mb-1 text-gray-800 fw-bold">Ringkasan Beban Pinjaman</h2>
            <p class="text-muted small mb-0">Pantau total pinjaman, sisa hutang, dan tenor Anda saat ini.</p>
        </div>
        <div>
            <a href="<?= url('/pinjaman') ?>" class="btn btn-outline-primary btn-sm">Lihat Detail Pinjaman</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #4e73df;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.8rem; font-weight: 600;">
                                Total Pinjaman Diterima
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-800 mt-2" style="font-size: 2rem; color: #0f172a;">
                                <?= formatRupiah($stats['total_pinjaman']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-wallet2 fa-2x text-gray-300 fs-1 text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #e74a3b;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.8rem; font-weight: 600;">
                                Sisa Hutang Berjalan
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-800 mt-2" style="font-size: 2rem; color: #0f172a;">
                                <?= formatRupiah($stats['sisa_pinjaman']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calculator fa-2x text-gray-300 fs-1 text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #36b9cc;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.8rem; font-weight: 600;">
                                Tenor Pinjaman
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-800 mt-2" style="font-size: 2rem; color: #0f172a;">
                                <?= isset($pinjaman['tenor_bulan']) ? $pinjaman['tenor_bulan'] . ' Bulan' : '0 Bulan' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-event fa-2x text-gray-300 fs-1 text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>