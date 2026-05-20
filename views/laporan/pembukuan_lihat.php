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
        <!-- Filter Bar -->
        <div class="d-flex align-items-center gap-2 mb-4">
            <label for="filterTahun" class="form-label fw-bold text-secondary mb-0">Tahun Buku:</label>
            <select id="filterTahun" class="form-select form-select-sm" style="max-width: 140px;" onchange="applyFilters()">
                <?php 
                $currentYear = (int)date('Y');
                $startYear = 1999; // Tahun koperasi pertama kali menggunakan sistem
                $maxYear = max($currentYear, 2026); // Memastikan minimal menampilkan sampai tahun saat ini
                
                for ($y = $maxYear; $y >= $startYear; $y--): 
                ?>
                    <option value="<?= $y ?>" <?= $y == $currentYear ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Bulan</th>
                        <th>Tanggal Buat</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 280px;">Aksi</th>
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="modal-title fw-bold text-dark mb-0"><i class="bi bi-people-fill me-2 text-primary"></i>Pratinjau Ringkasan Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 bg-light">
                <div class="bg-white p-4 shadow-sm border rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 border-bottom pb-3">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">
                                <i class="bi bi-calendar3 text-primary me-2"></i>Periode: <span id="modalPeriode" class="text-primary fw-bold"></span> 
                                <span class="text-muted fs-6 mx-2">|</span> 
                                <i class="bi bi-calendar-check text-success me-2"></i>Tahun Buku: <span id="modalTahun" class="text-success fw-bold"></span>
                            </h5>
                            <p class="text-muted small mb-0 mt-1">Rincian saldo simpanan kumulatif anggota aktif pada periode tahun buku terpilih.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button onclick="downloadExcelPreview()" class="btn btn-premium-excel btn-sm rounded fw-semibold px-3 py-2 shadow-sm">
                                <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel
                            </button>
                        </div>
                    </div>
                    
                    <!-- Spinner Loader -->
                    <div id="anggota-loader" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted small mt-2 mb-0">Mengambil data simpanan kumulatif anggota...</p>
                    </div>
                    
                    <!-- Dynamic Table Area -->
                    <div id="anggota-table-area" class="table-responsive d-none">
                        <table class="table table-hover table-sm align-middle small border custom-table-preview">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Anggota</th>
                                    <th>Nama</th>
                                    <th class="text-end">Simpanan Wajib</th>
                                    <th class="text-end">Simpanan Pokok</th>
                                    <th class="text-end">Simpanan Sukarela</th>
                                    <th class="text-end">Simpanan Belanja</th>
                                    <th class="text-end">Simpanan Sosial</th>
                                    <th class="text-end" id="th-motor" style="display:none;">Simpanan Motor</th>
                                    <th class="text-end" id="th-mobil" style="display:none;">Simpanan Mobil</th>
                                    <th class="text-end fw-bold">Total Keseluruhan</th>
                                </tr>
                            </thead>
                            <tbody id="anggota-preview-body">
                                <!-- Data populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer border-top px-4 py-3">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded px-3" data-bs-dismiss="modal">Tutup</button>
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
        background-color: #e2e8f0 !important;
        color: #475569 !important;
    }
    .badge-final {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
    }
    .badge-terkirim {
        background-color: #ede9fe !important;
        color: #5b21b6 !important;
    }

    /* High-contrast and modern translucent styling for Dark Mode status badges */
    [data-theme="dark"] .badge-draf {
        background-color: rgba(71, 85, 105, 0.2) !important;
        color: #94a3b8 !important;
        border: 1px solid rgba(148, 163, 184, 0.3) !important;
    }
    [data-theme="dark"] .badge-final {
        background-color: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
        border: 1px solid rgba(52, 211, 153, 0.3) !important;
    }
    [data-theme="dark"] .badge-terkirim {
        background-color: rgba(139, 92, 246, 0.2) !important;
        color: #a78bfa !important;
        border: 1px solid rgba(167, 139, 250, 0.3) !important;
    }

    /* Premium Tabs Styles */
    .nav-pills .nav-link {
        color: #64748b;
        background-color: #f1f5f9;
        border-radius: 8px;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }
    .nav-pills .nav-link:hover {
        color: #1e293b;
        background-color: #e2e8f0;
    }
    .nav-pills .nav-link.active {
        background-color: #4f46e5 !important;
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
    }

    /* Premium Action Buttons */
    .btn-premium-excel {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-premium-excel:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        color: white;
    }
    .btn-premium-print {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: white;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-premium-print:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        color: white;
    }

    /* Preview Table Inside Modal */
    .custom-table-preview th {
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        padding: 8px 6px !important;
        text-align: center !important;
    }
    .custom-table-preview td {
        font-size: 12px !important;
        padding: 8px 6px !important;
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

    const monthNamesInd = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const monthNamesEng = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    // Parser untuk mendeteksi bulan dari string periode
    function getMonthFromPeriode(periode) {
        if (!periode) return -1;
        const lower = periode.toLowerCase();
        for (let i = 0; i < 12; i++) {
            if (lower.includes(monthNamesInd[i].toLowerCase()) || lower.includes(monthNamesEng[i].toLowerCase())) {
                return i + 1; // 1-indexed
            }
        }
        return -1;
    }

    // Fungsi untuk menghitung tanggal tutup buku (bulan mundur tgl 26)
    function getTanggalTutupBuku(monthIndex, year) {
        const shortMonths = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        let prevMonthIdx = monthIndex - 1; // 0-indexed mundur 1 bulan
        let targetYear = parseInt(year);

        // Jika bulan ini Januari (1), maka mundurnya ke Desember (12) tahun lalu
        if (prevMonthIdx === 0) { 
            prevMonthIdx = 12;
            targetYear -= 1;
        }
        
        const shortYear = targetYear.toString().slice(-2);
        const monthName = shortMonths[prevMonthIdx - 1];

        return `26 ${monthName} ${shortYear}`;
    }

    // Load data dari localStorage jika ada, gabungkan dengan initialData
    let drafList = JSON.parse(localStorage.getItem('pembukuan_draf_list')) || [];
    let currentData = [...drafList, ...initialData];

    function renderTable() {
        const tableBody = document.getElementById('tableBody');
        const selectedYear = document.getElementById('filterTahun').value;
        tableBody.innerHTML = '';

        // Saring data berdasarkan tahun terpilih
        const reportsForYear = currentData.filter(row => row.tahun === selectedYear);

        // Buat 12 baris bulan (Januari s.d. Desember)
        for (let m = 1; m <= 12; m++) {
            const matchedReport = reportsForYear.find(row => getMonthFromPeriode(row.periode) === m);
            const namaBulan = monthNamesInd[m - 1];

            if (matchedReport) {
                let statusBadge = '';
                if (matchedReport.status === 'Draf') {
                    statusBadge = `<span class="badge badge-draf rounded-pill px-3 py-1 fw-bold">Draf</span>`;
                } else if (matchedReport.status === 'Final') {
                    statusBadge = `<span class="badge badge-final rounded-pill px-3 py-1 fw-bold">Final</span>`;
                } else {
                    statusBadge = `<span class="badge badge-terkirim rounded-pill px-3 py-1 fw-bold">Terkirim ke BAU</span>`;
                }

                tableBody.innerHTML += `
                    <tr>
                        <td>${m}</td>
                        <td class="fw-bold text-dark">${namaBulan}</td>
                        <td class="fw-semibold text-secondary">${getTanggalTutupBuku(m, selectedYear)}</td>
                        <td>${statusBadge}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <button class="btn btn-outline-primary btn-xs px-2 py-1 rounded" onclick="openPreview('${escapeJs(matchedReport.periode)}', '${escapeJs(matchedReport.tahun)}', ${m})" title="Buka Pratinjau">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-outline-success btn-xs px-2 py-1 rounded" onclick="window.open('<?= url('/laporan/pembukuan/cetak-anggota') ?>?tahun=${escapeJs(matchedReport.tahun)}&bulan=${m}', '_blank')" title="Cetak Ringkasan Anggota">
                                    <i class="bi bi-printer"></i>
                                </button>
                                <button class="btn btn-outline-success btn-xs px-2 py-1 rounded fw-semibold" onclick="downloadExcel('${escapeJs(matchedReport.tahun)}', ${m})" title="Download Excel" style="background-color: #10b981; color: white; border-color: #10b981;">
                                    <i class="bi bi-file-earmark-excel me-1"></i> Download
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                // Baris kosong jika laporan belum dibuat
                tableBody.innerHTML += `
                    <tr class="opacity-75">
                        <td>${m}</td>
                        <td class="fw-bold text-dark">${namaBulan}</td>
                        <td class="text-muted small">-</td>
                        <td><span class="badge bg-light border text-muted px-3 py-1 fw-normal">Belum Dibuat</span></td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <span class="text-muted small fst-italic px-1">Tidak tersedia</span>
                                <a href="<?= url('/laporan/pembukuan') ?>" class="btn btn-outline-primary btn-xs px-3 py-1 rounded fw-semibold" title="Buat Laporan Baru">
                                    <i class="bi bi-plus-circle me-1"></i> Buat
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }
    }

    let activePreviewTahun = '';
    let activePreviewBulan = '';

    function openPreview(periode, tahun, bulan) {
        activePreviewTahun = tahun;
        activePreviewBulan = bulan;
        document.getElementById('modalPeriode').innerText = periode;
        document.getElementById('modalTahun').innerText = tahun;
        
        // Trigger AJAX loading of the member summary
        loadMemberSummary();

        const myModal = new bootstrap.Modal(document.getElementById('modalPratinjauLaporan'));
        myModal.show();
    }

    function loadMemberSummary() {
        const loader = document.getElementById('anggota-loader');
        const tableArea = document.getElementById('anggota-table-area');
        const body = document.getElementById('anggota-preview-body');
        const thMotor = document.getElementById('th-motor');
        const thMobil = document.getElementById('th-mobil');

        loader.classList.remove('d-none');
        tableArea.classList.add('d-none');

        // Fetch data via AJAX bulanan
        fetch(`<?= url('/api/laporan/pembukuan/ringkasan') ?>?tahun=${activePreviewTahun}&bulan=${activePreviewBulan}`)
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data) {
                    const data = res.data.ringkasan;
                    body.innerHTML = '';

                    if (data.length === 0) {
                        body.innerHTML = `
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">Belum ada data anggota aktif untuk periode ini</td>
                            </tr>
                        `;
                        loader.classList.add('d-none');
                        tableArea.classList.remove('d-none');
                        return;
                    }

                    // Check if motor/mobil column needs to be displayed
                    let hasMotor = false;
                    let hasMobil = false;
                    
                    data.forEach(row => {
                        if (parseFloat(row.simpanan_motor) > 0) hasMotor = true;
                        if (parseFloat(row.simpanan_mobil) > 0) hasMobil = true;
                    });

                    if (hasMotor) thMotor.style.display = '';
                    else thMotor.style.display = 'none';

                    if (hasMobil) thMobil.style.display = '';
                    else thMobil.style.display = 'none';

                    // Totals
                    let totalWajib = 0, totalPokok = 0, totalSukarela = 0, totalBelanja = 0, totalSosial = 0, totalMotor = 0, totalMobil = 0, totalAll = 0;

                    data.forEach(row => {
                        totalWajib += parseFloat(row.simpanan_wajib);
                        totalPokok += parseFloat(row.simpanan_pokok);
                        totalSukarela += parseFloat(row.simpanan_sukarela);
                        totalBelanja += parseFloat(row.simpanan_belanja);
                        totalSosial += parseFloat(row.simpanan_dana_sosial);
                        totalMotor += parseFloat(row.simpanan_motor);
                        totalMobil += parseFloat(row.simpanan_mobil);
                        totalAll += parseFloat(row.total);

                        let motorCol = hasMotor ? `<td class="text-end text-primary">${formatRupiahJS(row.simpanan_motor)}</td>` : '';
                        let mobilCol = hasMobil ? `<td class="text-end text-success">${formatRupiahJS(row.simpanan_mobil)}</td>` : '';

                        body.innerHTML += `
                            <tr>
                                <td><span class="badge bg-light text-dark">${escapeHtml(row.no_anggota)}</span></td>
                                <td class="fw-semibold">${escapeHtml(row.nama)}</td>
                                <td class="text-end text-primary">${formatRupiahJS(row.simpanan_wajib)}</td>
                                <td class="text-end text-success">${formatRupiahJS(row.simpanan_pokok)}</td>
                                <td class="text-end text-info">${formatRupiahJS(row.simpanan_sukarela)}</td>
                                <td class="text-end text-warning">${formatRupiahJS(row.simpanan_belanja)}</td>
                                <td class="text-end text-danger">${formatRupiahJS(row.simpanan_dana_sosial)}</td>
                                ${motorCol}
                                ${mobilCol}
                                <td class="text-end fw-bold text-dark">${formatRupiahJS(row.total)}</td>
                            </tr>
                        `;
                    });

                    // Totals row
                    let motorColTotal = hasMotor ? `<td class="text-end fw-bold text-primary">${formatRupiahJS(totalMotor)}</td>` : '';
                    let mobilColTotal = hasMobil ? `<td class="text-end fw-bold text-success">${formatRupiahJS(totalMobil)}</td>` : '';
                    let colSpanVal = 2;

                    body.innerHTML += `
                        <tr class="table-light fw-bold">
                            <td colspan="${colSpanVal}" class="text-center text-uppercase">Total Akumulasi</td>
                            <td class="text-end text-primary">${formatRupiahJS(totalWajib)}</td>
                            <td class="text-end text-success">${formatRupiahJS(totalPokok)}</td>
                            <td class="text-end text-info">${formatRupiahJS(totalSukarela)}</td>
                            <td class="text-end text-warning">${formatRupiahJS(totalBelanja)}</td>
                            <td class="text-end text-danger">${formatRupiahJS(totalSosial)}</td>
                            ${motorColTotal}
                            ${mobilColTotal}
                            <td class="text-end text-dark">${formatRupiahJS(totalAll)}</td>
                        </tr>
                    `;

                    loader.classList.add('d-none');
                    tableArea.classList.remove('d-none');
                } else {
                    body.innerHTML = `
                        <tr>
                            <td colspan="10" class="text-center py-4 text-danger">Gagal memuat data ringkasan anggota.</td>
                        </tr>
                    `;
                    loader.classList.add('d-none');
                    tableArea.classList.remove('d-none');
                }
            })
            .catch(err => {
                body.innerHTML = `
                    <tr>
                        <td colspan="10" class="text-center py-4 text-danger">Terjadi kesalahan koneksi atau server error.</td>
                    </tr>
                `;
                loader.classList.add('d-none');
                tableArea.classList.remove('d-none');
            });
    }

    // Helper formatting JS
    function formatRupiahJS(val) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(val).replace('Rp', 'Rp.');
    }

    function printAnggotaPreview() {
        window.open(`<?= url('/laporan/pembukuan/cetak-anggota') ?>?tahun=${activePreviewTahun}&bulan=${activePreviewBulan}`, '_blank');
    }

    function downloadExcelPreview() {
        window.location.href = `<?= url('/laporan/pembukuan/excel-anggota') ?>?tahun=${activePreviewTahun}&bulan=${activePreviewBulan}`;
    }

    function downloadExcel(tahun, bulan) {
        window.location.href = `<?= url('/laporan/pembukuan/excel-anggota') ?>?tahun=${tahun}&bulan=${bulan}`;
    }

    function applyFilters() {
        renderTable();
    }

    function escapeHtml(str) {
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    function escapeJs(str) {
        return str.replace(/'/g, "\\'");
    }

    // Render tabel pertama kali
    window.onload = function() {
        renderTable();
    };
</script>
