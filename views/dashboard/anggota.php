<div class="container-fluid mb-5">
    
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-3">
        <div>
            <h2 class="h3 mb-1 text-gray-800 fw-bold">Dashboard</h2>
            <p class="text-muted small mb-0">Ringkasan Beban Pinjaman & Kewajiban Anda</p>
        </div>
        <div>
            <a href="<?= url('/pinjaman/ajukan') ?>" class="btn btn-primary btn-sm shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Ajukan Pinjaman
            </a>
        </div>
    </div>

    <div class="row mb-4">
        
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #4e73df;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 0.85rem;">
                                Total Pinjaman
                            </div>
                            <div class="h3 mb-0 fw-bold text-gray-800 mt-1">
                                <?= formatRupiah($stats['total_pinjaman'] ?? 0) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-wallet2 fa-2x text-gray-300 fs-1 text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #36b9cc;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 0.85rem;">
                                Total Tenor Pinjaman
                            </div>
                            <div class="h3 mb-0 fw-bold text-gray-800 mt-1">
                                <?= $stats['tenor_berjalan'] ?? '0 Bulan' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-event fa-2x text-gray-300 fs-1 text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #f6c23e;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.85rem;">
                                Total Angsuran
                            </div>
                            <div class="h3 mb-0 fw-bold text-gray-800 mt-1">
                                <?= formatRupiah($stats['potongan_angsuran'] ?? 0) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cash-coin fa-2x text-gray-300 fs-1 text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #e74a3b;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 0.85rem;">
                                Sisa Hutang
                            </div>
                            <div class="h3 mb-0 fw-bold text-gray-800 mt-1">
                                <?= formatRupiah($stats['sisa_pinjaman'] ?? 0) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calculator fa-2x text-gray-300 fs-1 text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="m-0 fw-bold text-gray-800"><i class="bi bi-receipt me-2 text-secondary"></i>Ringkasan Kewajiban</h5>
                    <p class="text-muted small mb-0 mt-1">Rincian potongan 5 jenis simpanan dan 1 angsuran pinjaman (Bulan Ini).</p>
                </div>
                <div class="card-body px-4 pb-4">
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-700">1. Simpanan Wajib</span>
                        <span class="fw-bold text-gray-800"><?= formatRupiah(50000) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-700">2. Simpanan Pokok <small class="text-muted">(Jika belum lunas)</small></span>
                        <span class="fw-bold text-gray-800"><?= formatRupiah(0) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-700">3. Simpanan Sukarela</span>
                        <span class="fw-bold text-gray-800"><?= formatRupiah(0) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-700">4. Simpanan Belanja</span>
                        <span class="fw-bold text-gray-800"><?= formatRupiah(0) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-700">5. Simpanan Dana Sosial</span>
                        <span class="fw-bold text-gray-800"><?= formatRupiah(0) ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-700">6. simpanan lainya</span>
                        <span class="fw-bold text-gray-800"><?= formatRupiah($stats['potongan_angsuran'] ?? 0) ?></span>
                    </div>

                    <hr class="border-secondary opacity-25 my-3">

                    <?php 
                        // Perhitungan Total Sesuai Rincian di atas
                        $totalSimpananBulanIni = 50000 + 0 + 0 + 0 + 0; // Ubah sesuai kewajiban simpanan aktif
                        $totalKewajiban = $totalSimpananBulanIni + ($stats['potongan_angsuran'] ?? 0);
                    ?>
                    <div class="d-flex justify-content-between align-items-center mt-2 p-3 rounded" style="background-color: #f8f9fc;">
                        <span class="fw-bold text-uppercase fs-6 text-gray-800">Total Kewajiban</span>
                        <h4 class="fw-bold text-danger m-0"><?= formatRupiah($totalKewajiban) ?></h4>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>