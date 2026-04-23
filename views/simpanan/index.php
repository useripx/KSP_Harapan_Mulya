<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Simpanan Anggota</h2>
        <p class="text-muted small mb-0">Kelola dan pantau saldo simpanan anggota.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card shadow-sm border-0">
            <div class="stat-header">
                <span class="stat-label">Total Saldo</span>
                <i class="bi bi-bank stat-icon"></i>
            </div>
            <div class="stat-value">
                <?= formatRupiah($stats['total_saldo']) ?>
            </div>
            <div class="stat-footer text-success fw-medium">Saldo saat ini</div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card shadow-sm border-0">
            <div class="stat-header">
                <span class="stat-label">Total Setoran</span>
                <i class="bi bi-arrow-down-left stat-icon text-success"></i>
            </div>
            <div class="stat-value">
                <?= formatRupiah($stats['total_setor']) ?>
            </div>
            <div class="stat-footer text-muted">Akumulasi setoran</div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card shadow-sm border-0">
            <div class="stat-header">
                <span class="stat-label">Total Penarikan</span>
                <i class="bi bi-arrow-up-right stat-icon text-danger"></i>
            </div>
            <div class="stat-value text-danger">
                <?= formatRupiah($stats['total_tarik']) ?>
            </div>
            <div class="stat-footer text-muted">Akumulasi penarikan</div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom pt-4 pb-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-0 fw-bold text-gray-800">Riwayat Transaksi</h5>
            <p class="card-description small text-muted mt-1 mb-0">Daftar semua mutasi simpanan.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="simpananSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Nama/ID/Tanggal...">
            </div>
            <?php if (Auth::role() !== ROLE_ANGGOTA): ?>
                <a href="<?= url('/simpanan/setor') ?>" class="btn btn-success btn-sm shadow-sm fw-semibold">
                    <i class="bi bi-download me-1"></i> Setor
                </a>
                <a href="<?= url('/simpanan/tarik') ?>" class="btn btn-outline-danger btn-sm shadow-sm fw-semibold">
                    <i class="bi bi-upload me-1"></i> Tarik
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Anggota</th>
                        <th>Tipe</th>
                        <th class="text-end">Jumlah</th>
                        <th class="pe-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="mutasiTableBody">
                    <?php if (empty($transaksi)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted fst-italic">Belum ada transaksi</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transaksi as $trx): ?>
                            <tr class="mutasi-row">
                                <td class="align-middle ps-4">
                                    <span class="fw-medium text-gray-800"><?= formatDateTime($trx['tanggal']) ?></span>
                                </td>
                                <td class="align-middle">
                                    <div class="fw-medium text-gray-800">
                                        <?= e($trx['nama']) ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= e($trx['no_anggota']) ?>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge px-2 py-1 rounded-pill <?= $trx['tipe'] === 'SETOR' ? 'bg-success-subtle text-success border border-success-subtle' : ($trx['tipe'] === 'TARIK' ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-info-subtle text-info border border-info-subtle') ?>">
                                        <?= e($trx['tipe']) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-bold align-middle <?= $trx['tipe'] === 'SETOR' ? 'text-success' : ($trx['tipe'] === 'TARIK' ? 'text-danger' : 'text-gray-800') ?>">
                                    <?= $trx['tipe'] === 'TARIK' ? '-' : ($trx['tipe'] === 'SETOR' ? '+' : '') ?> <?= formatRupiah($trx['jumlah']) ?>
                                </td>
                                <td class="text-muted small align-middle pe-4">
                                    <?= e($trx['keterangan'] ?: '-') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($transaksi) && count($transaksi) > 5): ?>
        <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
            <div class="small fw-medium text-muted" id="mutasi-page-info">
                Menampilkan data...
            </div>
            <div class="btn-group shadow-sm">
                <button id="mutasi-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeMutasiPage(-1)">
                    <i class="bi bi-chevron-left me-1"></i> Prev
                </button>
                <button id="mutasi-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeMutasiPage(1)">
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
    const allRows = Array.from(document.querySelectorAll("#mutasiTableBody .mutasi-row"));
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

        // Sembunyikan semua baris dulu
        allRows.forEach(row => row.style.display = "none");

        // Tampilkan hanya baris yang masuk filter & halaman aktif
        filteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = "";
            }
        });

        // Update info text
        const infoText = document.getElementById("mutasi-page-info");
        if (infoText) {
            if (totalRows === 0) {
                infoText.innerText = "Tidak ada data yang cocok";
            } else {
                const currentEnd = Math.min(end, totalRows);
                infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${totalRows} mutasi`;
            }
        }

        // Update pagination buttons
        const prevBtn = document.getElementById("mutasi-prev-btn");
        const nextBtn = document.getElementById("mutasi-next-btn");
        const paginationContainer = document.querySelector(".btn-group.shadow-sm");

        if (prevBtn) prevBtn.disabled = (currentPage === 1);
        if (nextBtn) nextBtn.disabled = (currentPage === totalPages);
        
        // Sembunyikan pagination jika data cuma sedikit (opsional, tapi biar bersih)
        // if (paginationContainer) {
        //     paginationContainer.parentElement.style.display = totalRows <= rowsPerPage ? "none" : "flex";
        // }
    }

    // Fungsi Filter
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

    // Inisialisasi
    updateTable();

    // Fungsi klik tombol
    window.changeMutasiPage = function(step) {
        currentPage += step;
        updateTable();
    };
});
</script>

<style>
/* Desain tambahan untuk tombol pagination dan badge modern */
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