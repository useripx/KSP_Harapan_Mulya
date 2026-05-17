<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Pusat Laporan & Analitik</h2>
        <p class="text-muted small mb-0">Pilih jenis laporan yang ingin Anda lihat atau cetak.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/dashboard') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
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
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #0d6efd !important;">
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
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #198754 !important;">
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
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #0dcaf0 !important;">
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

    <?php if (Auth::role() === ROLE_KETUA): ?>
    <!-- Cetak BAU (Khusus Manager) -->
    <div class="col-12 mt-5">
        <h5 class="fw-bold mb-3 d-flex align-items-center">
            <i class="bi bi-file-earmark-bar-graph me-2" style="color: #6610f2;"></i> Cetak BAU
        </h5>
    </div>
    
    <div class="col-md-4">
        <a href="<?= url('/laporan/pembukuan') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #6610f2 !important;">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3" style="background-color: #f1e6ff; color: #6610f2;">
                            <i class="bi bi-journal-bookmark fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold">Pembukuan</h6>
                    </div>
                    <p class="card-text text-muted small">Kelola penyusunan, peninjauan, dan pengiriman berkas laporan kepada pihak BAU.</p>
                </div>
            </div>
        </a>
    </div>
    <?php endif; ?>

    <!-- Operasional -->
    <div class="col-12 mt-5">
        <h5 class="fw-bold mb-3 d-flex align-items-center">
            <i class="bi bi-clock-history me-2 text-info"></i> Riwayat & Log Transaksi
        </h5>
    </div>

    <div class="col-md-4">
        <a href="<?= url('/laporan/pinjaman') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-subtle p-3 rounded-3 me-3 text-primary">
                            <i class="bi bi-journal-text fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold">Riwayat Pinjaman</h6>
                    </div>
                    <p class="card-text text-muted small">History dan log semua pengajuan pinjaman anggota.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="<?= url('/laporan/angsuran') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #198754 !important;">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success-subtle p-3 rounded-3 me-3 text-success">
                            <i class="bi bi-receipt-cutoff fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold">Riwayat Pembayaran</h6>
                    </div>
                    <p class="card-text text-muted small">History dan log pembayaran angsuran masuk anggota.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="<?= url('/laporan/simpanan') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition" style="border-left: 4px solid #6c757d !important;">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light p-3 rounded-3 me-3 text-dark border">
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold">Log Simpanan</h6>
                    </div>
                    <p class="card-text text-muted small">History dan log setor & tarik simpanan anggota.</p>
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
