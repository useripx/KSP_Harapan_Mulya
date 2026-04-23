<!-- Welcome Message -->
<div class="mb-5">
    <h2 class="page-title" style="font-size: 28px; letter-spacing: -0.04em;">Ringkasan Sistem</h2>
    <p class="text-muted" style="font-size: 15px;">Pantau performa koperasi dalam satu tampilan cerdas.</p>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-4 col-md-4">
        <div class="card stat-card h-100">
            <div class="stat-icon-wrapper">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="stat-label">Total Simpanan</div>
            <div class="stat-value"><?= formatRupiah($stats['total_simpanan']) ?></div>
            <div class="stat-footer mt-2">
                <span class="text-success fw-bold"><i class="bi bi-graph-up-arrow"></i> +12%</span>
                <span>pertumbuhan</span>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-4">
        <div class="card stat-card h-100">
            <div class="stat-icon-wrapper text-primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-label">Anggota Aktif</div>
            <div class="stat-value"><?= number_format($stats['total_anggota']) ?></div>
            <div class="stat-footer mt-2">
                <span class="badge bg-success-subtle">+<?= $stats['anggota_baru_bulan_ini'] ?> Baru</span>
                <span>bulan ini</span>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-4">
        <div class="card stat-card h-100">
            <div class="stat-icon-wrapper text-info">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="stat-label">Pinjaman Berjalan</div>
            <div class="stat-value"><?= number_format($stats['total_pinjaman_aktif']) ?></div>
            <div class="stat-footer mt-2">
                <span>Status: Aktif</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Member Data Summary -->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="card-title">Ringkasan Data Anggota</h5>
                    <p class="card-description-text">Data singkat iuran, cicilan, dan aktivitas terakhir anggota.</p>
                </div>
                <!-- Search Box -->
                <div class="input-group input-group-sm shadow-sm" style="width: 240px;">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="managerSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Nama / No. Anggota...">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th class="text-end">Iuran</th>
                                <th class="text-end">Cicilan</th>
                                <th>Aktivitas Terakhir</th>
                            </tr>
                        </thead>
                        <tbody id="managerTableBody">
                            <?php if (empty($ringkasanAnggota)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada data anggota</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($ringkasanAnggota as $anggota): ?>
                                    <tr class="manager-row">
                                        <td><div class="text-muted small"><?= e($anggota['no_anggota']) ?></div></td>
                                        <td><div class="fw-semibold"><?= e($anggota['nama']) ?></div></td>
                                        <td class="text-end fw-bold text-success">
                                            <?= formatRupiah($anggota['iuran'] ?? 0) ?>
                                        </td>
                                        <td class="text-end fw-bold text-danger">
                                            <?= formatRupiah($anggota['cicilan'] ?? 0) ?>
                                        </td>
                                        <td>
                                            <?= $anggota['aktivitas_terakhir'] ? formatTanggalShort($anggota['aktivitas_terakhir']) : '<span class="text-muted">-</span>' ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($ringkasanAnggota) && count($ringkasanAnggota) > 5): ?>
                <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
                    <div class="small fw-medium text-muted" id="manager-page-info">
                        Menampilkan data...
                    </div>
                    <div class="btn-group shadow-sm">
                        <button id="manager-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeManagerPage(-1)">
                            <i class="bi bi-chevron-left me-1"></i> Prev
                        </button>
                        <button id="manager-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeManagerPage(1)">
                            Next <i class="bi bi-chevron-right ms-1"></i>
                        </button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("managerSearchInput");
    const allRows    = Array.from(document.querySelectorAll("#managerTableBody .manager-row"));
    const rowsPerPage = 5;
    let currentPage   = 1;
    let filteredRows  = [...allRows];

    function updateTable() {
        const totalRows  = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const start = (currentPage - 1) * rowsPerPage;
        const end   = start + rowsPerPage;

        // Sembunyikan semua baris
        allRows.forEach(row => row.style.display = "none");

        // Tampilkan baris sesuai halaman
        filteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = "";
            }
        });

        // Update info teks
        const infoText = document.getElementById("manager-page-info");
        if (infoText) {
            if (totalRows === 0) {
                infoText.innerText = "Tidak ada data yang cocok";
            } else {
                const currentEnd = Math.min(end, totalRows);
                infoText.innerText = `Menampilkan ${start + 1}–${currentEnd} dari ${totalRows} anggota`;
            }
        }

        // Update tombol Prev / Next
        const prevBtn = document.getElementById("manager-prev-btn");
        const nextBtn = document.getElementById("manager-next-btn");
        if (prevBtn) prevBtn.disabled = (currentPage === 1);
        if (nextBtn) nextBtn.disabled = (currentPage === totalPages);
    }

    // Filter / Search
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const query = this.value.toLowerCase().trim();
            filteredRows = allRows.filter(row => row.innerText.toLowerCase().includes(query));
            currentPage  = 1;
            updateTable();
        });
    }

    // Load awal
    updateTable();

    // Ekspos fungsi ke scope global (dipanggil dari onclick)
    window.changeManagerPage = function (step) {
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