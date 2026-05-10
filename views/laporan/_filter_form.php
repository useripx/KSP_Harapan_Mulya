<?php 
// Tangkap flag dari file parent (misal neraca.php). Kalau nggak ada, defaultnya false
$isYearlyOnly = $isYearlyOnly ?? false;

// Kalau dipaksa tahunan, otomatis set ke 'tahunan'
$periode = $isYearlyOnly ? 'tahunan' : ($_GET['periode'] ?? 'semua');
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$bulan = $_GET['bulan'] ?? date('Y-m');
$tahun = $_GET['tahun'] ?? date('Y');
?>
<div class="card mb-4 no-print border-0 shadow-sm align-items-center flex-row">
    <div class="card-body">
        <form method="GET" action="" class="row g-3 align-items-end">
            
            <?php if(!$isYearlyOnly): ?>
            <div class="col-md-3">
                <label class="form-label text-muted small">Filter Periode</label>
                <select name="periode" class="form-select" id="periodeSelect" onchange="toggleFilterInputs()">
                    <option value="semua" <?= $periode == 'semua' ? 'selected' : '' ?>>Semua Waktu</option>
                    <option value="harian" <?= $periode == 'harian' ? 'selected' : '' ?>>Harian</option>
                    <option value="bulanan" <?= $periode == 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
                    <option value="tahunan" <?= $periode == 'tahunan' ? 'selected' : '' ?>>Tahunan</option>
                </select>
            </div>
            
            <div class="col-md-3" id="filterHarian" style="display: <?= $periode == 'harian' ? 'block' : 'none' ?>;">
                <label class="form-label text-muted small">Pilih Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?= e($tanggal) ?>">
            </div>
            
            <div class="col-md-3" id="filterBulanan" style="display: <?= $periode == 'bulanan' ? 'block' : 'none' ?>;">
                <label class="form-label text-muted small">Pilih Bulan</label>
                <input type="month" name="bulan" class="form-control" value="<?= e($bulan) ?>">
            </div>
            <?php else: ?>
            <input type="hidden" name="periode" value="tahunan">
            <?php endif; ?>
            
            <div class="col-md-3" id="filterTahunan" style="display: <?= $periode == 'tahunan' ? 'block' : 'none' ?>;">
                <label class="form-label text-muted small">Pilih Tahun Laporan</label>
                <input type="number" name="tahun" class="form-control" min="2020" max="2100" value="<?= e($tahun) ?>">
            </div>
            
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Terapkan Filter
                </button>
            </div>
            
            <div class="col-md-3 ms-auto text-end">
                <button type="button" onclick="window.print()" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-printer me-1"></i> Cetak PDF
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleFilterInputs() {
    const p = document.getElementById('periodeSelect').value;
    document.getElementById('filterHarian').style.display = (p === 'harian') ? 'block' : 'none';
    document.getElementById('filterBulanan').style.display = (p === 'bulanan') ? 'block' : 'none';
    document.getElementById('filterTahunan').style.display = (p === 'tahunan') ? 'block' : 'none';
}
</script>

<div class="print-header d-none mb-4 text-center">
    <h3 class="fw-bold mb-1">KOPERASI HARAPAN MULYA</h3>
    <p class="mb-1 text-muted">Jl. Contoh Koperasi No. 123, Kota Harapan</p>
    <hr style="border-top: 2px solid #000;">
    <h4 class="fw-bold mt-3"><?= e($pageTitle) ?></h4>
    <p class="text-muted">Periode Laporan: <strong><?= e($filterText ?? 'Semua Waktu') ?></strong></p>
</div>

<style>
    @media print {
        .sidebar, .topbar, .no-print, .btn, .breadcrumb {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .print-header {
            display: block !important;
        }
        body {
            background-color: white !important;
        }
        .ttd-container {
            page-break-inside: avoid;
            break-inside: avoid;
        }
    }
</style>
