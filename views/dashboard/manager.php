<!-- Welcome Message -->
<?php
    // Cek apakah ada anggota yang memiliki konfigurasi motor/mobil (untuk show/hide kolom)
    $hasMotor = !empty($ringkasanAnggota) && array_sum(array_column($ringkasanAnggota, 'simpanan_motor')) > 0;
    $hasMobil = !empty($ringkasanAnggota) && array_sum(array_column($ringkasanAnggota, 'simpanan_mobil')) > 0;
    $colCount = 8 + ($hasMotor ? 1 : 0) + ($hasMobil ? 1 : 0);
?>
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
                    <p class="card-description-text">Data ringkasan saldo simpanan (Saldo Akhir) anggota pada tahun <?= $selectedYear ?>.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <!-- Year Filter -->
                    <div class="d-flex align-items-center gap-2 me-2">
                        <span class="text-muted small" style="white-space: nowrap;">Tahun:</span>
                        <select id="managerYearFilter" class="form-select form-select-sm shadow-sm" style="width: 100px;" onchange="window.location.href = '?year=' + this.value">
                            <?php foreach ($availableYears as $year): ?>
                                <option value="<?= $year ?>" <?= $selectedYear == $year ? 'selected' : '' ?>><?= $year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Rows Per Page -->
                    <div class="d-flex align-items-center gap-2 me-2">
                        <span class="text-muted small" style="white-space: nowrap;">Tampil:</span>
                        <select id="managerRowsPerPage" class="form-select form-select-sm shadow-sm" style="width: 70px;">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select>
                    </div>
                    <!-- Search Box -->
                    <div class="input-group input-group-sm shadow-sm" style="width: 240px;">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="managerSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Nama / No. Anggota...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="white-space: nowrap;">No. Anggota</th>
                                <th class="text-center" style="white-space: nowrap;">Nama</th>
                                <th class="text-center" style="white-space: nowrap;">Simpanan Wajib</th>
                                <th class="text-center" style="white-space: nowrap;">Simpanan Pokok</th>
                                <th class="text-center" style="white-space: nowrap;">Simpanan Sukarela</th>
                                <th class="text-center" style="white-space: nowrap;">Simpanan Belanja</th>
                                <th class="text-center" style="white-space: nowrap;">Simpanan Dana Sosial</th>
                                <?php if ($hasMotor): ?>
                                <th class="text-center" style="white-space: nowrap;">Simpanan Motor</th>
                                <?php endif; ?>
                                <?php if ($hasMobil): ?>
                                <th class="text-center" style="white-space: nowrap;">Simpanan Mobil</th>
                                <?php endif; ?>
                                <th class="text-center" style="white-space: nowrap;">Total Keseluruhan</th>
                            </tr>
                        </thead>
                        <tbody id="managerTableBody">
                            <?php if (empty($ringkasanAnggota)): ?>
                                <tr>
                                    <td colspan="<?= $colCount ?>" class="text-center py-5 text-muted">Belum ada data anggota</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($ringkasanAnggota as $anggota): ?>
                                    <tr class="manager-row">
                                        <td><div class="text-muted small"><?= e($anggota['no_anggota']) ?></div></td>
                                        <td><div class="fw-semibold"><?= e($anggota['nama']) ?></div></td>
                                        <td class="text-end">
                                            <span class="text-primary fw-semibold"><?= formatRupiah($anggota['simpanan_wajib'], false) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-success fw-semibold"><?= formatRupiah($anggota['simpanan_pokok'], false) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-info fw-semibold"><?= formatRupiah($anggota['simpanan_sukarela'], false) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-warning fw-semibold"><?= formatRupiah($anggota['simpanan_belanja'], false) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-danger fw-semibold"><?= formatRupiah($anggota['simpanan_dana_sosial'], false) ?></span>
                                        </td>
                                        <?php if ($hasMotor): ?>
                                        <td class="text-end">
                                            <span class="text-primary fw-semibold"><?= formatRupiah($anggota['simpanan_motor'], false) ?></span>
                                        </td>
                                        <?php endif; ?>
                                        <?php if ($hasMobil): ?>
                                        <td class="text-end">
                                            <span class="text-success fw-semibold"><?= formatRupiah($anggota['simpanan_mobil'], false) ?></span>
                                        </td>
                                        <?php endif; ?>
                                        <td class="text-end">
                                            <span class="fw-bold text-dark"><?= formatRupiah($anggota['total'], false) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($ringkasanAnggota)): ?>
                <div id="manager-pagination-container" class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
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

<div class="row g-4 mt-2">
    <!-- Member Savings Config Summary -->
    <div class="col-xl-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold">Ringkasan Konfigurasi Simpanan Anggota</h5>
                <p class="card-description-text mb-0 small text-muted">Data konfigurasi simpanan motor dan mobil yang telah diatur oleh Validator.</p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No. Anggota</th>
                                <th>Nama Anggota</th>
                                <th class="text-end">Simpanan Motor</th>
                                <th class="text-end">Simpanan Mobil</th>
                                <th class="text-end">Total Per Bulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($configSummary)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted italic">Belum ada data konfigurasi simpanan dari Validator.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($configSummary as $config): ?>
                                    <tr>
                                        <td class="text-center"><span class="badge bg-light text-dark"><?= e($config['no_anggota']) ?></span></td>
                                        <td class="fw-semibold text-dark"><?= e($config['nama']) ?></td>
                                        <td class="text-end text-primary fw-medium"><?= formatRupiah($config['simpanan_motor'], false) ?></td>
                                        <td class="text-end text-success fw-medium"><?= formatRupiah($config['simpanan_mobil'], false) ?></td>
                                        <td class="text-end fw-bold text-dark"><?= formatRupiah($config['total'], false) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("managerSearchInput");
    const rowsSelect  = document.getElementById("managerRowsPerPage");
    const allRows     = Array.from(document.querySelectorAll("#managerTableBody .manager-row"));
    let rowsPerPage   = parseInt(rowsSelect.value);
    let currentPage    = 1;
    let filteredRows   = [...allRows];

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

        // Hide pagination if all data fits in one page
        const paginationContainer = document.getElementById("manager-pagination-container");
        if (paginationContainer) {
            paginationContainer.style.display = (totalRows <= rowsPerPage) ? "none" : "flex";
        }
    }

    // Rows per page change
    if (rowsSelect) {
        rowsSelect.addEventListener("change", function () {
            rowsPerPage = parseInt(this.value);
            currentPage = 1;
            updateTable();
        });
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