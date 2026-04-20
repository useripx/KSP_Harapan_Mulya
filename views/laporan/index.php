<div class="mb-4">
    <h2 class="page-title">Pusat Laporan & Analitik</h2>
    <p class="text-muted">Pilih jenis laporan yang ingin Anda lihat atau cetak.</p>
</div>

<div class="row g-4">
    <!-- Keuangan & Akunting -->
    <div class="col-12 mt-4">
        <h5 class="fw-bold mb-3 d-flex align-items-center">
            <i class="bi bi-calculator me-2 text-primary"></i> Keuangan & Akunting
        </h5>
    </div>
    
    <div class="col-md-4">
        <a href="<?= url('/laporan/neraca') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-subtle p-3 rounded-3 me-3">
                            <i class="bi bi-file-earmark-spreadsheet text-primary fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold">Laporan Neraca</h6>
                    </div>
                    <p class="card-text text-muted small">Posisi keuangan, aset, kewajiban, dan ekuitas koperasi.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="<?= url('/laporan/laba-rugi') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success-subtle p-3 rounded-3 me-3">
                            <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold">Laba Rugi</h6>
                    </div>
                    <p class="card-text text-muted small">Rangkuman pendapatan dan beban pada periode tertentu.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="<?= url('/laporan/kas') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info-subtle p-3 rounded-3 me-3">
                            <i class="bi bi-cash-stack text-info fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold">Arus Kas</h6>
                    </div>
                    <p class="card-text text-muted small">Catatan detail uang masuk dan keluar pada Buku Kas.</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Operasional -->
    <div class="col-12 mt-5">
        <h5 class="fw-bold mb-3 d-flex align-items-center">
            <i class="bi bi-clock-history me-2 text-info"></i> Riwayat & Log Transaksi
        </h5>
    </div>

    <div class="col-md-3">
        <a href="<?= url('/laporan/pinjaman') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body py-4 text-center">
                    <div class="bg-primary-subtle p-3 rounded-circle d-inline-flex mb-3">
                        <i class="bi bi-journal-text text-primary fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Riwayat Pinjaman</h6>
                    <small class="text-muted">History semua pengajuan</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="<?= url('/laporan/angsuran') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #198754 !important;">
                <div class="card-body py-4 text-center">
                    <div class="bg-success-subtle p-3 rounded-circle d-inline-flex mb-3">
                        <i class="bi bi-receipt-cutoff text-success fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Riwayat Pembayaran</h6>
                    <small class="text-muted">History angsuran masuk</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="<?= url('/laporan/simpanan') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-body py-4 text-center">
                    <div class="bg-light p-3 rounded-circle d-inline-flex mb-3">
                        <i class="bi bi-wallet2 text-dark fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Log Simpanan</h6>
                    <small class="text-muted">History setor & tarik</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="<?= url('/laporan/tunggakan') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-body py-4 text-center">
                    <div class="bg-light p-3 rounded-circle d-inline-flex mb-3">
                        <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Tunggakan</h6>
                    <small class="text-muted">Monitor kredit macet</small>
                </div>
            </div>
        </a>
    </div>
</div>

<style>
    .transition {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
