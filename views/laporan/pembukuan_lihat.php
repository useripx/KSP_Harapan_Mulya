<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0" style="color: #4f46e5; font-weight: 700;"><i class="bi bi-journal-richtext me-2"></i><?= $pageTitle ?></h2>
        <p class="text-muted small mb-0">Tinjau log berkas laporan pembukuan bulanan yang telah difinalisasi dalam sistem.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/laporan/pembukuan') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-4">
        <!-- Filter & Search Bar -->
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-md-6 d-flex gap-2">
                <select id="filterTahun" class="form-select form-select-sm" style="max-width: 120px;" onchange="applyFilters()">
                    <option value="semua">Semua Tahun</option>
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                </select>
                <select id="filterStatus" class="form-select form-select-sm" style="max-width: 150px;" onchange="applyFilters()">
                    <option value="semua">Semua Status</option>
                    <option value="Draf">Draf</option>
                    <option value="Final">Final</option>
                    <option value="Terkirim ke BAU">Terkirim ke BAU</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="searchKeyword" class="form-control border-start-0" placeholder="Cari periode..." onkeyup="applyFilters()">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Periode</th>
                        <th>Tahun Buku</th>
                        <th>Tanggal Dibuat</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Data will be populated via JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Pratinjau Mock -->
<div class="modal fade" id="modalPratinjauLaporan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom py-3 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Pratinjau Laporan Pembukuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="bg-white p-5 shadow-sm border rounded-3 text-center mx-auto" style="max-width: 700px; font-family: 'Courier New', Courier, monospace;">
                    <h4 class="fw-bold mb-1">KSP HARAPAN MULYA</h4>
                    <p class="small mb-4 border-bottom pb-2">LAPORAN KEUANGAN & PEMBUKUAN BULANAN</p>
                    
                    <div class="text-start mb-4 small">
                        <div class="row mb-1">
                            <div class="col-4">Periode</div>
                            <div class="col-8">: <span id="modalPeriode" class="fw-bold"> Mei 2026</span></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Tahun Buku</div>
                            <div class="col-8">: <span id="modalTahun">2026</span></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Penyusun</div>
                            <div class="col-8">: Manager Koperasi</div>
                        </div>
                    </div>

                    <table class="table table-sm table-bordered text-start small">
                        <thead>
                            <tr class="table-secondary">
                                <th>Deskripsi Keuangan</th>
                                <th class="text-end">Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A. Total Simpanan Anggota</td>
                                <td class="text-end">55.850.000,00</td>
                            </tr>
                            <tr>
                                <td>B. Total Piutang Berjalan</td>
                                <td class="text-end">120.400.000,00</td>
                            </tr>
                            <tr>
                                <td>C. Total Pendapatan Operasional</td>
                                <td class="text-end">8.950.000,00</td>
                            </tr>
                            <tr class="fw-bold table-light">
                                <td>D. Sisa Hasil Usaha (SHU) Bersih</td>
                                <td class="text-end text-success">3.450.000,00</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="mt-5 d-flex justify-content-between small">
                        <div>
                            <p class="mb-5">Disetujui Oleh,<br>Validator Koperasi</p>
                            <p class="fw-bold">( __________________ )</p>
                        </div>
                        <div>
                            <p class="mb-5">Disusun Oleh,<br>Manager Koperasi</p>
                            <p class="fw-bold">( Yogi Ario )</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top px-4 py-3">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded px-3" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-sm rounded px-3" onclick="alert('Mencetak draf laporan pembukuan...');" style="background: #4f46e5; border-color: #4f46e5;">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #edf2f7;
        padding-top: 14px;
        padding-bottom: 14px;
    }
    .custom-table td {
        padding-top: 14px;
        padding-bottom: 14px;
        font-size: 0.9rem;
    }
    
    /* Badges */
    .badge-draf {
        background-color: #e2e8f0;
        color: #475569;
    }
    .badge-final {
        background-color: #d1fae5;
        color: #065f46;
    }
    .badge-terkirim {
        background-color: #ede9fe;
        color: #5b21b6;
    }
</style>

<script>
    // Data bawaan awal (mock)
    const initialData = [
        {
            periode: 'April 2026',
            tahun: '2026',
            dibuat: '30 April 2026',
            status: 'Terkirim ke BAU'
        },
        {
            periode: 'Maret 2026',
            tahun: '2026',
            dibuat: '31 Maret 2026',
            status: 'Terkirim ke BAU'
        },
        {
            periode: 'Februari 2026',
            tahun: '2026',
            dibuat: '28 Februari 2026',
            status: 'Final'
        },
        {
            periode: 'Januari 2026',
            tahun: '2026',
            dibuat: '31 Januari 2026',
            status: 'Final'
        }
    ];

    // Load data dari localStorage jika ada, gabungkan dengan initialData
    let drafList = JSON.parse(localStorage.getItem('pembukuan_draf_list')) || [];
    let currentData = [...drafList, ...initialData];

    function renderTable(data) {
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';

        if (data.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-file-earmark-excel text-danger display-4 mb-3 d-block"></i>
                        Tidak ada berkas laporan pembukuan yang ditemukan.
                    </td>
                </tr>
            `;
            return;
        }

        data.forEach((row, index) => {
            let statusBadge = '';
            if (row.status === 'Draf') {
                statusBadge = `<span class="badge badge-draf rounded-pill px-3 py-1 fw-bold">Draf</span>`;
            } else if (row.status === 'Final') {
                statusBadge = `<span class="badge badge-final rounded-pill px-3 py-1 fw-bold">Final</span>`;
            } else {
                statusBadge = `<span class="badge badge-terkirim rounded-pill px-3 py-1 fw-bold">Terkirim ke BAU</span>`;
            }

            tableBody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td class="fw-bold text-dark">${escapeHtml(row.periode)}</td>
                    <td><span class="badge bg-light border text-dark">${escapeHtml(row.tahun)}</span></td>
                    <td>${escapeHtml(row.dibuat)}</td>
                    <td>${statusBadge}</td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <button class="btn btn-outline-primary btn-xs px-2 py-1 rounded" onclick="openPreview('${escapeJs(row.periode)}', '${escapeJs(row.tahun)}')" title="Buka Pratinjau">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-xs px-2 py-1 rounded" onclick="alert('Mencetak Laporan ${escapeJs(row.periode)}...')" title="Cetak">
                                <i class="bi bi-printer"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-xs px-2 py-1 rounded" onclick="deleteRow(${index})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    function openPreview(periode, tahun) {
        document.getElementById('modalPeriode').innerText = ' ' + periode;
        document.getElementById('modalTahun').innerText = tahun;
        const myModal = new bootstrap.Modal(document.getElementById('modalPratinjauLaporan'));
        myModal.show();
    }

    function deleteRow(idx) {
        if (confirm("Apakah Anda yakin ingin menghapus berkas laporan pembukuan ini?")) {
            // Hapus dari array lokal dan localStorage
            // Cari tahu apakah item ini berada di drafList (bagian atas)
            if (idx < drafList.length) {
                drafList.splice(idx, 1);
                localStorage.setItem('pembukuan_draf_list', JSON.stringify(drafList));
            } else {
                // Menghapus data mock initial
                const mockIndex = idx - drafList.length;
                initialData.splice(mockIndex, 1);
            }
            currentData = [...drafList, ...initialData];
            applyFilters();
        }
    }

    function applyFilters() {
        const tahun = document.getElementById('filterTahun').value;
        const status = document.getElementById('filterStatus').value;
        const keyword = document.getElementById('searchKeyword').value.toLowerCase();

        let filtered = currentData.filter(row => {
            const matchesTahun = (tahun === 'semua' || row.tahun === tahun);
            const matchesStatus = (status === 'semua' || row.status === status);
            const matchesKeyword = row.periode.toLowerCase().includes(keyword);
            return matchesTahun && matchesStatus && matchesKeyword;
        });

        renderTable(filtered);
    }

    function escapeHtml(str) {
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    function escapeJs(str) {
        return str.replace(/'/g, "\\'");
    }

    // Render tabel pertama kali
    window.onload = function() {
        renderTable(currentData);
    };
</script>
