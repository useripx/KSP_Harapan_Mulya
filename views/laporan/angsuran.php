<?php
$filterText = $filterText ?? 'Semua Waktu';
$angsuran = $angsuran ?? [];
?>

<div class="mb-4 no-print d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>" class="text-decoration-none">Laporan</a></li>
                <li class="breadcrumb-item active">Riwayat Pembayaran</li>
            </ol>
        </nav>
        <h2 class="page-title mb-0"><?= e($pageTitle) ?></h2>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="angsuranSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Kode/Anggota/Ket...">
        </div>
        <a href="<?= url('/laporan') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<?php require '_filter_form.php'; ?>

<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tgl Pembayaran</th>
                        <th>Kode TRX</th>
                        <th>Anggota</th>
                        <th class="text-center">Angsuran Ke</th>
                        <th class="text-end">Pokok</th>
                        <th class="text-end">Bunga</th>
                        <th class="text-end">Total Bayar</th>
                        <th class="pe-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="angsuranTableBody">
                    <?php if (empty($angsuran)): ?>
                        <tr class="empty-row">
                            <td colspan="8" class="text-center py-5 text-muted">Tidak ada data angsuran pada periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($angsuran as $a): ?>
                            <tr class="angsuran-report-row">
                                <td class="ps-4 text-gray-800"><?= date('d/m/Y', strtotime($a['tanggal_bayar'])) ?></td>
                                <td><code>ANG-<?= str_pad($a['id'], 5, '0', STR_PAD_LEFT) ?></code><br><small class="text-muted">PJ-<?= str_pad($a['pinjaman_id'], 5, '0', STR_PAD_LEFT) ?></small></td>
                                <td><div class="fw-bold text-gray-800"><?= e($a['anggota_nama']) ?></div><small class="text-muted"><?= e($a['no_anggota']) ?></small></td>
                                <td class="text-center"><span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-circle"><?= $a['angsuran_ke'] ?></span></td>
                                <td class="text-end"><?= formatRupiah($a['pokok_bayar']) ?></td>
                                <td class="text-end"><?= formatRupiah($a['bunga_bayar']) ?></td>
                                <td class="text-end fw-bold text-success"><?= formatRupiah($a['total']) ?></td>
                                <td class="pe-4"><?= e($a['keterangan'] ?: '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div> 
        <?php require '_print_signature.php'; ?>

        <?php if (!empty($angsuran) && count($angsuran) > 5): ?>
        <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
            <div class="small fw-medium text-muted" id="angsuran-report-page-info">
                Menampilkan data...
            </div>
            <div class="btn-group shadow-sm">
                <button id="angsuran-report-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeAngsuranReportPage(-1)">
                    <i class="bi bi-chevron-left me-1"></i> Prev
                </button>
                <button id="angsuran-report-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeAngsuranReportPage(1)">
                    Next <i class="bi bi-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("angsuranSearchInput");
    const allRows = Array.from(document.querySelectorAll("#angsuranTableBody .angsuran-report-row"));
    const rowsPerPage = 5;
    let currentPage = 1;
    let filteredRows = [...allRows];

    function updateTable() {
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        allRows.forEach(row => row.style.display = "none");
        filteredRows.forEach((row, index) => {
            if (index >= start && index < end) row.style.display = "";
        });

        const infoText = document.getElementById("angsuran-report-page-info");
        if (infoText) {
            if (totalRows === 0) {
                infoText.innerText = "Tidak ada data yang cocok";
            } else {
                const currentEnd = Math.min(end, totalRows);
                infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${totalRows} data`;
            }
        }

        const prevBtn = document.getElementById("angsuran-report-prev-btn");
        const nextBtn = document.getElementById("angsuran-report-next-btn");
        if (prevBtn) prevBtn.disabled = (currentPage === 1);
        if (nextBtn) nextBtn.disabled = (currentPage === totalPages);
    }

    if (searchInput) {
        searchInput.addEventListener("input", function() {
            const query = this.value.toLowerCase();
            filteredRows = allRows.filter(row => row.innerText.toLowerCase().includes(query));
            currentPage = 1;
            updateTable();
        });
    }

    updateTable();

    window.changeAngsuranReportPage = function(step) {
        currentPage += step;
        updateTable();
    };
});
</script>

<style>
.btn-white { background-color: #ffffff; }
.btn-white:hover:not(:disabled) { background-color: #f8fafc; color: #1e40af !important; }
.btn-white:disabled { background-color: #f1f5f9; color: #94a3b8 !important; cursor: not-allowed; }
</style>
