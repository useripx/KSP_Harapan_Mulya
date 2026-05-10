<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Manajemen Anggota</h2>
        <p class="text-muted small mb-0">Kelola data seluruh anggota koperasi.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="anggotaSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Nama/ID...">
        </div>
        <?php if ($userRole === ROLE_ADMIN): ?>
        <a href="<?= url('/anggota/create') ?>" class="btn btn-primary btn-sm shadow-sm px-3">
            <i class="bi bi-person-plus me-1"></i> Tambah Anggota
        </a>
        <?php endif; ?>
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No. Anggota</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>HP</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody id="anggotaTableBody">
                    <?php if (empty($anggota)): ?>
                        <tr class="empty-row">
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data anggota</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($anggota as $item): ?>
                            <tr class="anggota-row">
                                <td class="ps-4">
                                    <code class="fw-bold text-primary"><?= e($item['no_anggota']) ?></code>
                                </td>
                                <td>
                                    <div class="fw-bold text-gray-800"><?= e($item['nama']) ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= e($item['tipe']) ?></span>
                                </td>
                                <td>
                                    <?= e($item['no_hp'] ?: '-') ?>
                                </td>
                                <td class="text-center">
                                    <?= getStatusBadge($item['status'], 'anggota') ?>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?= url('/anggota/' . $item['id']) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <?php if ($userRole === ROLE_ADMIN): ?>
                                    <a href="<?= url('/anggota/' . $item['id'] . '/edit') ?>" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($anggota) && count($anggota) > 5): ?>
        <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
            <div class="small fw-medium text-muted" id="anggota-page-info">
                Menampilkan data...
            </div>
            <div class="btn-group shadow-sm">
                <button id="anggota-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeAnggotaPage(-1)">
                    <i class="bi bi-chevron-left me-1"></i> Prev
                </button>
                <button id="anggota-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeAnggotaPage(1)">
                    Next <i class="bi bi-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("anggotaSearchInput");
    const allRows = Array.from(document.querySelectorAll("#anggotaTableBody .anggota-row"));
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

        // Hide all rows
        allRows.forEach(row => row.style.display = "none");

        // Show only matching rows for current page
        filteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = "";
            }
        });

        // Update info text
        const infoText = document.getElementById("anggota-page-info");
        if (infoText) {
            if (totalRows === 0) {
                infoText.innerText = "Tidak ada data yang cocok";
            } else {
                const currentEnd = Math.min(end, totalRows);
                infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${totalRows} anggota`;
            }
        }

        // Update pagination buttons
        const prevBtn = document.getElementById("anggota-prev-btn");
        const nextBtn = document.getElementById("anggota-next-btn");

        if (prevBtn) prevBtn.disabled = (currentPage === 1);
        if (nextBtn) nextBtn.disabled = (currentPage === totalPages);
    }

    // Filter Logic
    if (searchInput) {
        searchInput.addEventListener("input", function() {
            const query = this.value.toLowerCase();
            
            filteredRows = allRows.filter(row => {
                const text = row.innerText.toLowerCase();
                return text.includes(query);
            });

            currentPage = 1;
            updateTable();
        });
    }

    // Initial load
    updateTable();

    window.changeAnggotaPage = function(step) {
        currentPage += step;
        updateTable();
    };
});
</script>

<style>
.btn-white {
    background-color: #ffffff;
}
.btn-white:hover:not(:disabled) {
    background-color: #f8fafc;
    color: #1e40af !important;
}
.btn-white:disabled {
    background-color: #f1f5f9;
    color: #94a3b8 !important;
    cursor: not-allowed;
}
</style>