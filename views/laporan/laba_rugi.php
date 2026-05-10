<?php
$bunga = $pendapatan['bunga'] ?? 0;
$denda = $pendapatan['denda'] ?? 0;
$adm = $admin['admin'] ?? 0;
$totalPendapatan = $bunga + $denda + $adm;
$totalBeban = $beban['beban'] ?? 0;
$shu = $totalPendapatan - $totalBeban;
?>

<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>">Laporan</a></li>
                <li class="breadcrumb-item active">Laba Rugi</li>
            </ol>
        </nav>
        <h2 class="page-title mb-0"><?= e($pageTitle) ?></h2>
    </div>
    <div>
        <a href="<?= url('/laporan') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<?php require '_filter_form.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-0 shadow-lg mb-4 bg-white" style="border-radius: 1rem;">
            <div class="card-body p-5">
                <div class="text-center mb-5 border-bottom border-2 border-dark pb-3">
                    <h2 class="text-uppercase fw-bolder mb-1">Koperasi Harapan Mulya</h2>
                    <p class="mb-0 text-muted">Laporan Perhitungan Hasil Usaha (Laba/Rugi)</p>
                    <p class="fw-bold text-primary mb-0">Periode: <?= e($filterText ?? 'Semua Waktu') ?></p>
                </div>

                <h5 class="fw-bold text-uppercase text-primary border-bottom pb-2 mb-3">I. Pendapatan</h5>
                <div class="d-flex justify-content-between mb-2 px-3">
                    <span>Jasa Pinjaman (Bunga)</span>
                    <span class="font-monospace"><?= formatRupiah($bunga) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2 px-3">
                    <span>Provisi / Administrasi</span>
                    <span class="font-monospace"><?= formatRupiah($adm) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2 px-3">
                    <span>Pendapatan Denda</span>
                    <span class="font-monospace"><?= formatRupiah($denda) ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded mt-3 fw-bold border">
                    <span>TOTAL PENDAPATAN</span>
                    <span class="font-monospace text-primary fs-5"><?= formatRupiah($totalPendapatan) ?></span>
                </div>

                <h5 class="fw-bold text-uppercase text-danger border-bottom pb-2 mb-3 mt-5">II. Beban Operasional</h5>
                <div class="d-flex justify-content-between mb-2 px-3">
                    <span>Beban Operasional & Lainnya</span>
                    <span class="font-monospace"><?= formatRupiah($totalBeban) ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded mt-3 fw-bold border">
                    <span>TOTAL BEBAN</span>
                    <span class="font-monospace text-danger fs-5">(<?= formatRupiah($totalBeban) ?>)</span>
                </div>

                <div class="d-flex justify-content-between align-items-center bg-success p-4 rounded mt-5 text-white shadow-sm">
                    <h4 class="mb-0 fw-bolder text-uppercase">III. Sisa Hasil Usaha (SHU)</h4>
                    <h3 class="mb-0 font-monospace fw-bolder"><?= formatRupiah($shu) ?></h3>
                </div>

                <?php require '_print_signature.php'; ?>
            </div>
        </div>
    </div>
</div>