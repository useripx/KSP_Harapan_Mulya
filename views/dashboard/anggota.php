        <!-- Header -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="h3 mb-1 text-gray-800 fw-bold">Simpanan Anggota</h2>
                <p class="text-muted small mb-0">Kelola dan pantau saldo simpanan anggota.</p>
            </div>
            <div>
                <a href="<?= url('/simpanan') ?>" class="btn btn-outline-primary btn-sm">Lihat Validasi Mutasi</a>
            </div>
        </div>

        <!-- Cards Row Utama (Mengikuti Desain Gambar) -->
        <div class="row mb-5">
            <!-- Total Saldo -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.8rem; font-weight: 600;">
                                    TOTAL SALDO <i class="bi bi-bank ms-1"></i>
                                </div>
                                <div class="h2 mb-0 fw-bold text-gray-800 mt-2 mb-2" style="font-size: 2rem; color: #0f172a;">
                                    <?= formatRupiah($stats['saldo_simpanan']) ?>
                                </div>
                                <div class="text-success small mt-1" style="font-weight: 500;">Saldo saat ini</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Setoran -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.8rem; font-weight: 600;">
                                    TOTAL SETORAN <i class="bi bi-arrow-down-left text-success ms-1"></i>
                                </div>
                                <div class="h2 mb-0 fw-bold text-gray-800 mt-2 mb-2" style="font-size: 2rem; color: #0f172a;">
                                    <?= formatRupiah($stats['total_setoran']) ?>
                                </div>
                                <div class="text-muted small mt-1">Akumulasi setoran</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Penarikan -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.8rem; font-weight: 600;">
                                    TOTAL PENARIKAN <i class="bi bi-arrow-up-right text-dark ms-1"></i>
                                </div>
                                <div class="h2 mb-0 fw-bold text-gray-800 mt-2 mb-2" style="font-size: 2rem; color: #0f172a;">
                                    <?= formatRupiah($stats['total_penarikan']) ?>
                                </div>
                                <div class="text-muted small mt-1">Akumulasi penarikan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h2 class="h4 mb-0 text-gray-800 fw-bold">Ringkasan Beban Pinjaman</h2>
        </div>

        <!-- Tiga Informasi Tambahan (Pinjaman & Angsuran) -->
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #f6c23e;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pinjaman Diterima</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2"><?= formatRupiah($stats['total_pinjaman']) ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-wallet2 fa-2x text-gray-300 fs-2 text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #e74a3b;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Sisa Hutang Berjalan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2"><?= formatRupiah($stats['sisa_pinjaman']) ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-calculator fa-2x text-gray-300 fs-2 text-danger opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow-sm h-100 py-2" style="border-radius: 12px; border-left: 4px solid #36b9cc;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tagihan Bulan Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2"><?= formatRupiah($stats['angsuran_bulan_ini']) ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-calendar-check fa-2x text-gray-300 fs-2 text-info opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

