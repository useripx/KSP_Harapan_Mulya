<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0" style="color: #4f46e5; font-weight: 700;"><i class="bi bi-journal-bookmark me-2"></i><?= $pageTitle ?></h2>
        <p class="text-muted small mb-0">Kelola siklus pelaporan pembukuan dari penyusunan hingga pengiriman berkas laporan kepada pihak BAU.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/laporan') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Laporan
        </a>
    </div>
</div>

<!-- Simulated Loading Widget (Glassmorphism Overlay) -->
<div id="simulatedOverlay" class="d-none simulated-overlay d-flex align-items-center justify-content-center text-center">
    <div class="glass-loading-card p-5 shadow-lg border rounded-3 bg-white">
        <div class="spinner-border text-primary mb-3" style="width: 3.5rem; height: 3.5rem; color: #4f46e5 !important;" role="status"></div>
        <h5 class="fw-bold mb-2">Menyusun Data Laporan...</h5>
        <p class="text-muted small mb-0" id="loadingStep">Membaca data Neraca dan Kas Utama...</p>
    </div>
</div>

<!-- Simulated Success Widget -->
<div id="successWidget" class="d-none mt-4 mb-4">
    <div class="card border-0 shadow-sm bg-success bg-opacity-10" style="border-radius: 12px; border-left: 5px solid #10b981 !important;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                    <i class="bi bi-check2-circle fs-3"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-success mb-1">Draf Laporan Berhasil Dibuat!</h5>
                    <p class="text-dark small mb-0" id="successDetailText"></p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top border-success border-opacity-25 d-flex gap-2 justify-content-end">
                <a href="<?= url('/laporan/pembukuan/lihat') ?>" class="btn btn-sm btn-outline-success fw-bold rounded px-3">
                    <i class="bi bi-journal-richtext me-1"></i> Lihat Laporan
                </a>
                <a href="<?= url('/laporan/pembukuan/kirim') ?>" class="btn btn-sm btn-success fw-bold rounded px-3" style="background-color: #10b981; border-color: #10b981;">
                    <i class="bi bi-send-fill me-1"></i> Kirim ke BAU
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <!-- Card 1: Buat Laporan (Sekarang memicu Modal Langsung) -->
    <div class="col-md-6">
        <a href="#" onclick="event.preventDefault(); openCalendarModal();" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-card-premium transition" style="border-left: 4px solid #4f46e5 !important; border-radius: 12px; background-color: var(--card) !important;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center" style="background-color: var(--secondary); color: #4f46e5; width: 52px; height: 52px;">
                            <i class="bi bi-file-earmark-plus-fill fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold text-dark fs-6">Buat Laporan</h6>
                    </div>
                    <p class="card-text text-muted small mb-0">Pilih periode di kalender interaktif untuk langsung menyusun draf laporan secara otomatis.</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 2: Lihat Laporan -->
    <div class="col-md-6">
        <a href="<?= url('/laporan/pembukuan/lihat') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-card-premium transition" style="border-left: 4px solid #10b981 !important; border-radius: 12px; background-color: var(--card) !important;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center" style="background-color: var(--secondary); color: #059669; width: 52px; height: 52px;">
                            <i class="bi bi-journal-richtext fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold text-dark fs-6">Lihat Laporan</h6>
                    </div>
                    <p class="card-text text-muted small mb-0">Tinjau, telusuri, dan periksa kembali log berkas laporan pembukuan yang telah difinalisasi.</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Modal Pratinjau Laporan Pembukuan (Revisi Premium) -->
<div class="modal fade" id="modalPreviewLaporan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; background-color: var(--card) !important; color: var(--foreground) !important;">
            <div class="modal-header border-bottom py-3 px-4 d-flex justify-content-between align-items-center" style="border-color: var(--border) !important;">
                <h5 class="modal-title fw-bold mb-0 text-primary d-flex align-items-center gap-2">
                    <i class="bi bi-people-fill"></i> Pratinjau Ringkasan Anggota (Bulanan)
                </h5>
                <button type="button" class="btn-close" onclick="closePreviewModal()" aria-label="Close" style="filter: var(--close-btn-filter);"></button>
            </div>
            
            <div class="modal-body p-4" style="background-color: var(--secondary) !important;">
                <div class="p-4 shadow-sm border rounded-3 bg-white" style="background-color: var(--card) !important; border-color: var(--border) !important;">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 border-bottom pb-3" style="border-color: var(--border) !important;">
                        <div>
                            <h5 class="fw-bold mb-1" style="color: var(--foreground) !important;">
                                <i class="bi bi-calendar3 text-primary me-2"></i>Periode: <span id="modalPeriode" class="text-primary fw-bold"></span> 
                                <span class="text-muted fs-6 mx-2">|</span> 
                                <i class="bi bi-calendar-check text-success me-2"></i>Tanggal Laporan: <span id="modalTanggalHariIni" class="text-success fw-bold"></span>
                            </h5>
                            <p class="text-muted small mb-0 mt-1">Rincian saldo simpanan kumulatif anggota aktif pada periode bulan buku berjalan.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button onclick="downloadExcelPreview()" class="btn btn-premium-excel btn-sm rounded fw-semibold px-3 py-2 shadow-sm">
                                <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel
                            </button>
                            <button onclick="printAnggotaPreview()" class="btn btn-outline-primary btn-sm rounded fw-semibold px-3 py-2 shadow-sm">
                                <i class="bi bi-printer me-1"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>
                    
                    <!-- Spinner Loader -->
                    <div id="anggota-loader" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted small mt-2 mb-0">Mengambil data simpanan kumulatif anggota bulanan...</p>
                    </div>
                    
                    <!-- Dynamic Table Area -->
                    <div id="anggota-table-area" class="table-responsive d-none">
                        <table class="table table-hover table-sm align-middle small border custom-table-preview" style="border-color: var(--border) !important;">
                            <thead class="table-light" style="background-color: var(--secondary) !important; color: var(--foreground) !important;">
                                <tr>
                                    <th style="color: var(--foreground) !important; background-color: var(--secondary) !important;">No. Anggota</th>
                                    <th style="color: var(--foreground) !important; background-color: var(--secondary) !important;">Nama</th>
                                    <th class="text-end" style="color: var(--foreground) !important; background-color: var(--secondary) !important;">Simpanan Wajib</th>
                                    <th class="text-end" style="color: var(--foreground) !important; background-color: var(--secondary) !important;">Simpanan Pokok</th>
                                    <th class="text-end" style="color: var(--foreground) !important; background-color: var(--secondary) !important;">Simpanan Sukarela</th>
                                    <th class="text-end" style="color: var(--foreground) !important; background-color: var(--secondary) !important;">Simpanan Belanja</th>
                                    <th class="text-end" style="color: var(--foreground) !important; background-color: var(--secondary) !important;">Simpanan Sosial</th>
                                    <th class="text-end" id="th-motor" style="display:none; color: var(--foreground) !important; background-color: var(--secondary) !important;">Simpanan Motor</th>
                                    <th class="text-end" id="th-mobil" style="display:none; color: var(--foreground) !important; background-color: var(--secondary) !important;">Simpanan Mobil</th>
                                    <th class="text-end fw-bold" style="color: var(--foreground) !important; background-color: var(--secondary) !important;">Total Keseluruhan</th>
                                </tr>
                            </thead>
                            <tbody id="anggota-preview-body">
                                <!-- Data populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer border-top px-4 py-3 d-flex justify-content-end gap-2" style="border-color: var(--border) !important;">
                <button type="button" onclick="closePreviewModal()" class="btn btn-outline-secondary btn-sm rounded px-4 py-2 fw-semibold">Batal</button>
                <button type="button" onclick="kirimLaporanKeBAUDariModal()" class="btn btn-premium-print btn-sm rounded px-4 py-2 fw-semibold shadow-sm">
                    <i class="bi bi-send-fill me-1"></i> Kirim ke BAU
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .transition {
        transition: all 0.3s ease;
    }
    .hover-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(79, 70, 229, 0.1) !important;
    }
    
    /* Loading Overlay styling */
    .simulated-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        z-index: 1050;
    }
    .glass-loading-card {
        max-width: 400px;
        border-radius: 16px;
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
    // State Pratinjau
    const today = new Date();
    const currentYear = today.getFullYear();
    const currentMonth = today.getMonth() + 1; // 1-indexed

    function openCalendarModal() {
        // Kita ubah namanya untuk kompatibilitas trigger tombol "Buat Laporan"
        openPreviewModal();
    }

    function openPreviewModal() {
        const modalEl = document.getElementById('modalPreviewLaporan');
        const modal = new bootstrap.Modal(modalEl);
        
        // Atur Tanggal Otomatis Hari Ini (Bahasa Indonesia)
        const hariList = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const bulanList = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        const namaHari = hariList[today.getDay()];
        const tanggal = today.getDate();
        const namaBulan = bulanList[today.getMonth()];
        
        document.getElementById('modalTanggalHariIni').innerText = `${namaHari}, ${tanggal} ${namaBulan} ${currentYear}`;
        document.getElementById('modalPeriode').innerText = `${namaBulan} ${currentYear}`;
        
        // Muat Data Anggota Dinamis via AJAX
        loadMemberSummary();
        
        modal.show();
    }

    function closePreviewModal() {
        const modalEl = document.getElementById('modalPreviewLaporan');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
            modal.hide();
        }
    }

    function loadMemberSummary() {
        const loader = document.getElementById('anggota-loader');
        const tableArea = document.getElementById('anggota-table-area');
        const body = document.getElementById('anggota-preview-body');
        const thMotor = document.getElementById('th-motor');
        const thMobil = document.getElementById('th-mobil');

        loader.classList.remove('d-none');
        tableArea.classList.add('d-none');

        // Fetch data bulanan via AJAX
        fetch(`<?= url('/api/laporan/pembukuan/ringkasan') ?>?tahun=${currentYear}&bulan=${currentMonth}`)
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data) {
                    const data = res.data.ringkasan;
                    body.innerHTML = '';

                    if (data.length === 0) {
                        body.innerHTML = `
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">Belum ada data anggota aktif untuk periode ${currentMonth}-${currentYear}</td>
                            </tr>
                        `;
                        loader.classList.add('d-none');
                        tableArea.classList.remove('d-none');
                        return;
                    }

                    // Cek ketersediaan kolom motor/mobil
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

                    // Hitung total akumulasi
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
                                <td class="fw-semibold" style="color: var(--foreground) !important;">${escapeHtml(row.nama)}</td>
                                <td class="text-end text-primary">${formatRupiahJS(row.simpanan_wajib)}</td>
                                <td class="text-end text-success">${formatRupiahJS(row.simpanan_pokok)}</td>
                                <td class="text-end text-info">${formatRupiahJS(row.simpanan_sukarela)}</td>
                                <td class="text-end text-warning">${formatRupiahJS(row.simpanan_belanja)}</td>
                                <td class="text-end text-danger">${formatRupiahJS(row.simpanan_dana_sosial)}</td>
                                ${motorCol}
                                ${mobilCol}
                                <td class="text-end fw-bold" style="color: var(--foreground) !important;">${formatRupiahJS(row.total)}</td>
                            </tr>
                        `;
                    });

                    // Baris Total Akumulasi
                    let motorColTotal = hasMotor ? `<td class="text-end fw-bold text-primary">${formatRupiahJS(totalMotor)}</td>` : '';
                    let mobilColTotal = hasMobil ? `<td class="text-end fw-bold text-success">${formatRupiahJS(totalMobil)}</td>` : '';
                    let colSpanVal = 2;

                    body.innerHTML += `
                        <tr class="table-light fw-bold" style="background-color: var(--secondary) !important;">
                            <td colspan="${colSpanVal}" class="text-center text-uppercase" style="color: var(--foreground) !important;">Total Akumulasi</td>
                            <td class="text-end text-primary">${formatRupiahJS(totalWajib)}</td>
                            <td class="text-end text-success">${formatRupiahJS(totalPokok)}</td>
                            <td class="text-end text-info">${formatRupiahJS(totalSukarela)}</td>
                            <td class="text-end text-warning">${formatRupiahJS(totalBelanja)}</td>
                            <td class="text-end text-danger">${formatRupiahJS(totalSosial)}</td>
                            ${motorColTotal}
                            ${mobilColTotal}
                            <td class="text-end" style="color: var(--foreground) !important;">${formatRupiahJS(totalAll)}</td>
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

    function escapeHtml(str) {
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    function printAnggotaPreview() {
        // Simpan draf ke localStorage agar data terlihat dinamis di Lihat Laporan!
        const bulanList = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const namaBulan = bulanList[today.getMonth()];
        const displayPeriode = `${namaBulan} ${currentYear}`;

        let drafList = JSON.parse(localStorage.getItem('pembukuan_draf_list')) || [];
        // Cek apakah draf untuk bulan ini sudah ada agar tidak duplikat
        const exists = drafList.some(item => item.periode === displayPeriode);
        if (!exists) {
            drafList.unshift({
                periode: displayPeriode,
                tahun: currentYear.toString(),
                dibuat: new Date().toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'}),
                status: 'Draf'
            });
            localStorage.setItem('pembukuan_draf_list', JSON.stringify(drafList));
        }

        // Tampilkan widget sukses secara visual di belakang
        const successWidget = document.getElementById('successWidget');
        const successDetailText = document.getElementById('successDetailText');
        if (successWidget && successDetailText) {
            successDetailText.innerText = `Draf laporan untuk periode ${displayPeriode} telah selesai disusun dengan status final dan siap dikirimkan ke BAU.`;
            successWidget.classList.remove('d-none');
        }

        closePreviewModal();

        // Buka link cetak di tab baru
        window.open(`<?= url('/laporan/pembukuan/cetak-anggota') ?>?tahun=${currentYear}&bulan=${currentMonth}`, '_blank');
    }

    function downloadExcelPreview() {
        window.location.href = `<?= url('/laporan/pembukuan/excel-anggota') ?>?tahun=${currentYear}&bulan=${currentMonth}`;
    }

    function kirimLaporanKeBAUDariModal() {
        const bulanList = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const namaBulan = bulanList[today.getMonth()];
        const displayPeriode = `${namaBulan} ${currentYear}`;

        closePreviewModal();

        // 1. Tampilkan overlay loading
        const overlay = document.getElementById('simulatedOverlay');
        const loadingStep = document.getElementById('loadingStep');
        const successWidget = document.getElementById('successWidget');
        const successDetailText = document.getElementById('successDetailText');

        if (overlay) {
            const loadingHeader = overlay.querySelector('h5');
            if (loadingHeader) loadingHeader.innerText = "Mengirim Laporan ke BAU...";
            loadingStep.innerText = "Menghubungkan ke saluran transmisi BAU...";
            overlay.classList.remove('d-none');
        }
        if (successWidget) {
            successWidget.classList.add('d-none');
        }

        // 2. Alur Animasi Teks Langkah
        setTimeout(() => {
            if (loadingStep) loadingStep.innerText = "Mengompresi berkas laporan pembukuan bulanan...";
        }, 1000);

        setTimeout(() => {
            if (loadingStep) loadingStep.innerText = "Mengunggah berkas laporan final ke Bagian Administrasi Umum (BAU)...";
        }, 2200);

        // 3. Penyelesaian & Update LocalStorage
        setTimeout(() => {
            if (overlay) overlay.classList.add('d-none');

            let drafList = JSON.parse(localStorage.getItem('pembukuan_draf_list')) || [];
            
            const idx = drafList.findIndex(item => item.periode === displayPeriode);
            if (idx !== -1) {
                drafList[idx].status = 'Terkirim ke BAU';
            } else {
                drafList.unshift({
                    periode: displayPeriode,
                    tahun: currentYear.toString(),
                    dibuat: new Date().toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'}),
                    status: 'Terkirim ke BAU'
                });
            }
            localStorage.setItem('pembukuan_draf_list', JSON.stringify(drafList));

            // Tampilkan widget sukses secara visual di dashboard
            if (successWidget && successDetailText) {
                const titleEl = successWidget.querySelector('h5');
                if (titleEl) {
                    titleEl.innerText = "Laporan Berhasil Terkirim ke BAU!";
                    titleEl.className = "fw-bold text-success mb-1";
                }
                const iconEl = successWidget.querySelector('.bi-check2-circle');
                if (iconEl) {
                    iconEl.className = "bi bi-send-check-fill fs-3";
                }
                successDetailText.innerHTML = `Berkas laporan pembukuan bulanan periode <strong>${displayPeriode}</strong> telah sukses dikirimkan secara elektronik kepada Bagian Administrasi Umum (BAU) Koperasi.`;
                
                const widgetKirimBtn = successWidget.querySelector('a[href*="kirim"]');
                if (widgetKirimBtn) {
                    widgetKirimBtn.style.display = 'none';
                }
                
                successWidget.classList.remove('d-none');
            }
        }, 3400);
    }
</script>
