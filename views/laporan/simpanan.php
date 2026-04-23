<?php
$filterText = $filterText ?? 'Semua Waktu';
$transaksi = $transaksi ?? [];
?>

<div class="mb-4 no-print d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>" class="text-decoration-none">Laporan</a></li>
                <li class="breadcrumb-item active">Riwayat Simpanan</li>
            </ol>
        </nav>
        <h2 class="page-title mb-0"><?= e($pageTitle) ?></h2>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="simpananSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Kode/Anggota/Ket...">
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
                        <th class="ps-4">Tgl Transaksi</th>
                        <th>Kode/ID</th>
                        <th>Anggota</th>
                        <th>Tipe</th>
                        <th class="text-end">Jumlah</th>
                        <th class="pe-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="simpananTableBody">
                    <?php if (empty($transaksi)): ?>
                        <tr class="empty-row">
                            <td colspan="6" class="text-center py-5 text-muted">Tidak ada data transaksi simpanan pada periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($transaksi as $t): ?>
                            <tr class="simpanan-report-row">
                                <td class="ps-4 text-gray-800"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                                <td><code>TRX-<?= str_pad($t['id'], 5, '0', STR_PAD_LEFT) ?></code><br><small class="text-muted"><?= e($t['no_anggota']) ?></small></td>
                                <td><div class="fw-bold text-gray-800"><?= e($t['anggota_nama']) ?></div></td>
                                <td>
                                    <?php if ($t['tipe'] == 'SETOR'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">SETOR</span>
                                    <?php elseif ($t['tipe'] == 'TARIK'): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">TARIK</span>
                                    <?php else: ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-3">TRANSFER</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end fw-bold text-primary"><?= formatRupiah($t['jumlah']) ?></td>
                                <td class="pe-4"><?= e($t['keterangan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($transaksi) && count($transaksi) > 5): ?>
        <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
            <div class="small fw-medium text-muted" id="simpanan-report-page-info">
                Menampilkan data...
            </div>
            <div class="btn-group shadow-sm">
                <button id="simpanan-report-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeSimpananReportPage(-1)">
                    <i class="bi bi-chevron-left me-1"></i> Prev
                </button>
                <button id="simpanan-report-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeSimpananReportPage(1)">
                    Next <i class="bi bi-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("simpananSearchInput");
    const allRows = Array.from(document.querySelectorAll("#simpananTableBody .simpanan-report-row"));
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

        const infoText = document.getElementById("simpanan-report-page-info");
        if (infoText) {
            if (totalRows === 0) {
                infoText.innerText = "Tidak ada data yang cocok";
            } else {
                const currentEnd = Math.min(end, totalRows);
                infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${totalRows} data`;
            }
        }

        const prevBtn = document.getElementById("simpanan-report-prev-btn");
        const nextBtn = document.getElementById("simpanan-report-next-btn");
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

    window.changeSimpananReportPage = function(step) {
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
