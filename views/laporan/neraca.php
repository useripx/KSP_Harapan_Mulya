<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>">Laporan</a></li>
                <li class="breadcrumb-item active">Neraca Keuangan</li>
            </ol>
        </nav>
        <h2 class="page-title"><?= e($pageTitle) ?></h2>
    </div>
</div>

<?php require '_filter_form.php'; ?>

<div class="card border-0 shadow-lg mb-4 bg-white" style="border-radius: 1rem;">
    <div class="card-body p-5">
        <div class="text-center mb-5 border-bottom border-2 border-dark pb-3">
            <h2 class="text-uppercase fw-bolder mb-1">KSP Harapan Mulya</h2>
            <p class="mb-0 text-muted">Laporan Neraca Keuangan</p>
            <p class="fw-bold text-primary mb-0">Per Tanggal: <?= e(date('d F Y')) ?> </p>
        </div>

        <div class="row g-5">
            <div class="col-md-6">
                <h5 class="fw-bold text-uppercase border-bottom pb-2 mb-4">Aset (Aktiva)</h5>
                
                <div class="mb-4">
                    <h6 class="fw-bold text-muted">Aset Lancar</h6>
                    <div class="d-flex justify-content-between border-bottom border-dashed py-2 px-2">
                        <span>Kas & Bank</span>
                        <span class="font-monospace"><?= formatRupiah($saldoKas ?? 0) ?></span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom border-dashed py-2 px-2">
                        <span>Piutang Pinjaman Anggota</span>
                        <span class="font-monospace"><?= formatRupiah($piutang ?? 0) ?></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded border border-primary border-opacity-25 mt-auto">
                    <span class="fw-bold text-primary">JUMLAH ASET</span>
                    <span class="font-monospace fw-bold fs-5 text-primary"><?= formatRupiah(($saldoKas ?? 0) + ($piutang ?? 0)) ?></span>
                </div>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold text-uppercase border-bottom pb-2 mb-4">Kewajiban & Ekuitas (Pasiva)</h5>
                
                <div class="mb-4">
                    <h6 class="fw-bold text-muted">Kewajiban</h6>
                    <div class="d-flex justify-content-between border-bottom border-dashed py-2 px-2">
                        <span>Total Simpanan Anggota</span>
                        <span class="font-monospace"><?= formatRupiah($totalSimpanan ?? 0) ?></span>
                    </div>
                </div>
                <div class="mb-4">
                    <h6 class="fw-bold text-muted">Ekuitas</h6>
                    <div class="d-flex justify-content-between border-bottom border-dashed py-2 px-2">
                        <span>Modal / SHU Berjalan</span>
                        <span class="font-monospace"><?= formatRupiah($ekuitas ?? 0) ?></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded border border-primary border-opacity-25 mt-auto">
                    <span class="fw-bold text-primary">JUMLAH PASIVA</span>
                    <span class="font-monospace fw-bold fs-5 text-primary"><?= formatRupiah($jumlahAset ?? 0) ?></span>
                </div>
            </div>

        <div class="d-none d-print-flex justify-content-between mt-5 pt-5">
            <div class="text-center" style="width: 200px;">
                <p class="mb-5">Ketua Koperasi,</p>
                <p class="fw-bold border-bottom border-dark pb-1 mb-0">Bpk. Haryanto, SE</p>
            </div>
            <div class="text-center" style="width: 200px;">
                <p class="mb-5">Bendahara,</p>
                <p class="fw-bold border-bottom border-dark pb-1 mb-0"><?= e($_SESSION['user_name'] ?? 'Admin') ?></p>
            </div>
        </div>
    </div>
</div>