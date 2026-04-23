<?php
$filterText = $filterText ?? 'Semua Waktu';
$kas = $kas ?? [];
?>

<div class="mb-4 no-print d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>" class="text-decoration-none">Laporan</a></li>
                <li class="breadcrumb-item active">Arus Kas Utama</li>
            </ol>
        </nav>
        <h2 class="page-title mb-0"><?= e($pageTitle) ?></h2>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="kasSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Kode/Modul/Ket...">
        </div>
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
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
                        <th class="ps-4">Tanggal Pembukuan</th>
                        <th>Kode KAS</th>
                        <th>Jenis Arus</th>
                        <th>Sumber Modul</th>
                        <th>Referensi ID</th>
                        <th class="text-end">Jumlah M/K</th>
                        <th class="pe-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="kasTableBody">
                    <?php if (empty($kas)): ?>
                        <tr class="empty-row">
                            <td colspan="7" class="text-center py-5 text-muted">Tidak ada data pergerakan kas pada periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($kas as $k): ?>
                            <tr class="kas-row">
                                <td class="ps-4 text-gray-800"><?= date('d/m/Y H:i', strtotime($k['tanggal'])) ?></td>
                                <td><code>KAS-<?= str_pad($k['id'], 6, '0', STR_PAD_LEFT) ?></code></td>
                                <td>
                                    <?php if ($k['tipe'] == 'KAS_MASUK'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3"><i class="bi bi-arrow-down-left-circle me-1"></i> MASUK</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3"><i class="bi bi-arrow-up-right-circle me-1"></i> KELUAR</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?= e($k['sumber']) ?></span></td>
                                <td><small class="text-muted"><?= e($k['ref_id'] ?: '-') ?></small></td>
                                <td class="text-end fw-bold <?= $k['tipe'] == 'KAS_MASUK' ? 'text-success' : 'text-danger' ?>">
                                    <?= $k['tipe'] == 'KAS_MASUK' ? '+' : '-' ?> <?= formatRupiah($k['jumlah']) ?>
                                </td>
                                <td class="pe-4"><?= e($k['catatan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($kas) && count($kas) > 5): ?>
        <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
            <div class="small fw-medium text-muted" id="kas-page-info">
                Menampilkan data...
            </div>
            <div class="btn-group shadow-sm">
                <button id="kas-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeKasPage(-1)">
                    <i class="bi bi-chevron-left me-1"></i> Prev
                </button>
                <button id="kas-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeKasPage(1)">
                    Next <i class="bi bi-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("kasSearchInput");
    const allRows = Array.from(document.querySelectorAll("#kasTableBody .kas-row"));
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
            if (index >= start && index < end) {
                row.style.display = "";
            }
        });

        const infoText = document.getElementById("kas-page-info");
        if (infoText) {
            if (totalRows === 0) {
                infoText.innerText = "Tidak ada data yang cocok";
            } else {
                const currentEnd = Math.min(end, totalRows);
                infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${totalRows} data`;
            }
        }

        const prevBtn = document.getElementById("kas-prev-btn");
        const nextBtn = document.getElementById("kas-next-btn");

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

    window.changeKasPage = function(step) {
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
