<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Daftar Pinjaman</h2>
        <p class="text-muted small mb-0">Kelola pengajuan dan pencairan pinjaman.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <?php if (in_array(Auth::role(), [ROLE_ANGGOTA, ROLE_ADMIN, ROLE_TELLER])): ?>
            <a href="<?= url('/pinjaman/ajukan') ?>" class="btn btn-primary btn-sm shadow-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Ajukan Pinjaman
            </a>
        <?php endif; ?>
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom pt-4 pb-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold text-gray-800">Data Pinjaman</h5>
        <div class="d-flex align-items-center gap-2">
            <!-- Rows Per Page -->
            <div class="d-flex align-items-center gap-2 me-2">
                <span class="text-muted small" style="white-space: nowrap;">Tampil:</span>
                <select id="pinjamanRowsPerPage" class="form-select form-select-sm shadow-sm" style="width: 70px;">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
            <!-- Status Filter -->
            <div class="d-flex align-items-center gap-2 me-2">
                <span class="text-muted small" style="white-space: nowrap;">Status:</span>
                <select id="pinjamanStatusFilter" class="form-select form-select-sm shadow-sm" style="width: 130px;">
                    <option value="ALL">Semua</option>
                    <option value="DIAJUKAN">Diajukan</option>
                    <option value="DIVERIFIKASI">Diverifikasi</option>
                    <option value="DISETUJUI">Disetujui</option>
                    <option value="BERJALAN">Berjalan</option>
                    <option value="LUNAS">Lunas</option>
                </select>
            </div>
            <!-- Search Box -->
            <div class="input-group input-group-sm shadow-sm" style="width: 240px;">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="pinjamanSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Nama/ID/Tanggal...">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tgl Pengajuan</th>
                        <th>Anggota</th>
                        <th class="text-end">Pokok</th>
                        <th>Tenor</th>
                        <th class="pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pinjamanTableBody">
                    <?php if (empty($pinjaman)): ?>
                        <tr class="empty-row">
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data pinjaman</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pinjaman as $item): ?>
                            <tr class="data-row" data-status="<?= e($item['status']) ?>">
                                <td class="align-middle ps-4">
                                    <?= formatTanggalShort($item['tgl_pengajuan']) ?>
                                </td>
                                <td class="align-middle">
                                    <div class="fw-medium text-gray-800">
                                        <?= e($item['nama']) ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= e($item['no_anggota']) ?>
                                    </div>
                                </td>
                                <td class="text-end fw-semibold align-middle text-gray-800">
                                    <?= formatRupiah($item['pokok']) ?>
                                </td>
                                <td class="align-middle">
                                    <?= $item['tenor_bulan'] ?> Bulan
                                </td>
                                <td class="align-middle pe-4 text-center">
                                    <a href="<?= url('/pinjaman/' . $item['id']) ?>" class="btn btn-primary btn-sm shadow-sm rounded">
                                        <i class="bi bi-eye-fill me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (!empty($pinjaman)): ?>
        <div id="pinjaman-pagination-container" class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
            <div class="small fw-medium text-muted" id="page-info">
                Menampilkan data...
            </div>
            <div class="btn-group shadow-sm">
                <button id="prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changePage(-1)">
                    <i class="bi bi-chevron-left me-1"></i> Prev
                </button>
                <button id="next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changePage(1)">
                    Next <i class="bi bi-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("pinjamanSearchInput");
    const rowsSelect = document.getElementById("pinjamanRowsPerPage");
    const allRows = Array.from(document.querySelectorAll("#pinjamanTableBody .data-row"));
    let rowsPerPage = parseInt(rowsSelect.value);
    let currentPage = 1;
    let filteredRows = [...allRows];

    function updateTable() {
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Sembunyikan semua baris dulu
        allRows.forEach(row => row.style.display = "none");

        // Tampilkan hanya baris yang masuk filter & halaman aktif
        filteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = "";
            }
        });

        // Update info text
        const infoText = document.getElementById("page-info");
        if (infoText) {
            if (totalRows === 0) {
                infoText.innerText = "Tidak ada data yang cocok";
            } else {
                const currentEnd = Math.min(end, totalRows);
                infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${totalRows} data`;
            }
        }

        // Update pagination buttons
        const prevBtn = document.getElementById("prev-btn");
        const nextBtn = document.getElementById("next-btn");

        if (prevBtn) prevBtn.disabled = (currentPage === 1);
        if (nextBtn) nextBtn.disabled = (currentPage === totalPages);

        const paginationContainer = document.getElementById("pinjaman-pagination-container");
        if (paginationContainer) {
            paginationContainer.style.display = (totalRows <= rowsPerPage) ? "none" : "flex";
        }
    }

    // Fungsi Filter
    function applyFilters() {
        const query = searchInput.value.toLowerCase();
        const status = document.getElementById("pinjamanStatusFilter").value;
        
        filteredRows = allRows.filter(row => {
            const rowText = row.innerText.toLowerCase();
            const rowStatus = row.getAttribute("data-status");
            
            const matchSearch = rowText.includes(query);
            const matchStatus = (status === "ALL" || rowStatus === status);
            
            return matchSearch && matchStatus;
        });

        currentPage = 1;
        updateTable();
    }

    if (searchInput) {
        searchInput.addEventListener("input", applyFilters);
    }

    const statusFilter = document.getElementById("pinjamanStatusFilter");
    if (statusFilter) {
        statusFilter.addEventListener("change", applyFilters);
    }

    if (rowsSelect) {
        rowsSelect.addEventListener("change", function() {
            rowsPerPage = parseInt(this.value);
            currentPage = 1;
            updateTable();
        });
    }

    // Inisialisasi
    updateTable();

    // Fungsi klik tombol
    window.changePage = function(step) {
        currentPage += step;
        updateTable();
    };
});
</script>

<style>
/* Mempercantik tombol pagination */
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