<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Daftar Angsuran & Tagihan</h2>
        <p class="text-muted small mb-0">Monitor jadwal jatuh tempo dan status pembayaran angsuran.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <div class="input-group input-group-sm shadow-sm" style="width: 280px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="angsuranSearchInput" class="form-control border-start-0 ps-0" placeholder="Cari Nama/ID/Tanggal...">
        </div>
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
                        <th>Nama Anggota</th>
                        <th>Pinj #</th>
                        <th>Ke</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody id="angsuranTableBody">
                    <?php if (empty($schedules)): ?>
                        <tr class="empty-row">
                            <td colspan="8" class="text-center py-5 text-muted">Tidak ada data angsuran.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($schedules as $row): ?>
                            <tr class="angsuran-row">
                                <td class="ps-4"><code><?= e($row['no_anggota']) ?></code></td>
                                <td>
                                    <div class="fw-bold text-gray-800"><?= e($row['anggota_nama']) ?></div>
                                </td>
                                <td>#<?= $row['pinjaman_id'] ?></td>
                                <td><span class="badge bg-light text-dark"><?= $row['angsuran_ke'] ?></span></td>
                                <td>
                                    <?php 
                                        $isOverdue = ($row['status'] === 'BELUM' && $row['jatuh_tempo'] < date('Y-m-d'));
                                    ?>
                                    <span class="<?= $isOverdue ? 'text-danger fw-bold' : 'text-gray-800' ?>">
                                        <?= formatTanggalShort($row['jatuh_tempo']) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-medium text-gray-800"><?= formatRupiah($row['total_tagih']) ?></td>
                                <td class="text-center">
                                    <?php if ($row['status'] === 'BAYAR'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">LUNAS</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">BELUM</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if ($row['status'] === 'BELUM' && in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER])): ?>
                                        <a href="<?= url('/angsuran/bayar/' . $row['id']) ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-cash me-1"></i> Bayar
                                        </a>
                                    <?php elseif ($row['status'] === 'BAYAR'): ?>
                                        <a href="<?= url('/angsuran/' . $row['payment_id']) ?>" class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-printer me-1"></i> Lihat Kuitansi
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($schedules) && count($schedules) > 5): ?>
        <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
            <div class="small fw-medium text-muted" id="angsuran-page-info">
                Menampilkan data...
            </div>
            <div class="btn-group shadow-sm">
                <button id="angsuran-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeAngsuranPage(-1)">
                    <i class="bi bi-chevron-left me-1"></i> Prev
                </button>
                <button id="angsuran-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeAngsuranPage(1)">
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
    const allRows = Array.from(document.querySelectorAll("#angsuranTableBody .angsuran-row"));
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
        const infoText = document.getElementById("angsuran-page-info");
        if (infoText) {
            if (totalRows === 0) {
                infoText.innerText = "Tidak ada data yang cocok";
            } else {
                const currentEnd = Math.min(end, totalRows);
                infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${totalRows} data`;
            }
        }

        // Update pagination buttons
        const prevBtn = document.getElementById("angsuran-prev-btn");
        const nextBtn = document.getElementById("angsuran-next-btn");

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

    window.changeAngsuranPage = function(step) {
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
