<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0" style="color: #4f46e5; font-weight: 700;"><i class="bi bi-send-check-fill me-2"></i><?= $pageTitle ?></h2>
        <p class="text-muted small mb-0">Kirim berkas laporan final secara resmi langsung ke sistem Bagian Administrasi Umum (BAU).</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/laporan/pembukuan') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Menu Pembukuan
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 mx-auto">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white border-0 py-3 mt-2 px-4">
                <h5 class="fw-bold mb-0 text-dark">Kirim Berkas Laporan</h5>
                <p class="text-muted small mb-0">Kirim laporan pembukuan bulanan kepada Bagian Administrasi Umum (BAU) dengan aman.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <form id="formKirimBAU" onsubmit="event.preventDefault(); simulateSending();">
                    <div class="row g-4">
                        <!-- Pilih Laporan -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary">Pilih Berkas Laporan Pembukuan</label>
                            <select id="pilihLaporan" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Berkas Laporan --</option>
                                <!-- Will be loaded via JS -->
                            </select>
                        </div>
                        
                        <!-- Penerima di BAU -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Pihak Penerima di BAU</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" id="penerimaBAU" class="form-control" placeholder="Nama petugas BAU..." value="Bagian Administrasi Umum (BAU)" required>
                            </div>
                        </div>

                        <!-- Tanggal Pengiriman -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Tanggal Pengiriman</label>
                            <input type="text" class="form-control bg-light" value="<?= date('d F Y') ?>" readonly disabled>
                        </div>

                        <!-- Pesan Pengantar -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary">Catatan Pengantar</label>
                            <textarea id="pesanPengantar" class="form-control" rows="4" placeholder="Tuliskan catatan pengantar atau ringkasan pesan singkat untuk penerima di BAU..."></textarea>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary px-4 fw-semibold rounded" onclick="window.history.back()">Batal</button>
                        <button type="submit" id="btnSubmitKirim" class="btn btn-primary px-4 fw-semibold rounded transition" style="background: #4f46e5; border-color: #4f46e5;">
                            <i class="bi bi-send me-1"></i>
                            <span id="btnText">Kirim Berkas Laporan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Simulated Loading Widget (Glassmorphism Overlay) -->
        <div id="simulatedOverlay" class="d-none simulated-overlay d-flex align-items-center justify-content-center text-center">
            <div class="glass-loading-card p-5 shadow-lg border rounded-3 bg-white" style="width: 100%; max-width: 440px;">
                <!-- Loading State -->
                <div id="loadingState">
                    <div class="spinner-grow text-primary mb-3" style="width: 3.5rem; height: 3.5rem; color: #4f46e5 !important;" role="status"></div>
                    <h5 class="fw-bold mb-2">Mengirim Laporan ke BAU...</h5>
                    <p class="text-muted small mb-0" id="loadingStep">Mengompresi berkas laporan pembukuan...</p>
                </div>
                
                <!-- Success State inside Modal -->
                <div id="successModalState" class="d-none">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success mb-3" style="width: 72px; height: 72px;">
                        <i class="bi bi-check-circle-fill" style="font-size: 40px;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Laporan Berhasil Terkirim!</h4>
                    <p class="text-muted small mb-4" id="successModalText"></p>
                    <button type="button" class="btn btn-primary w-100 fw-bold rounded py-2" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); border: none;" onclick="closeSuccessModal()">
                        Oke
                    </button>
                </div>
            </div>
        </div>

        <!-- Simulated Success Widget -->
        <div id="successWidget" class="d-none mt-4">
            <div class="card border-0 shadow-sm bg-indigo-subtle" style="border-radius: 12px; border-left: 5px solid #4f46e5 !important; background-color: #eef2ff;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-indigo text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background-color: #4f46e5;">
                            <i class="bi bi-send-check fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-indigo mb-1" style="color: #4f46e5;">Laporan Berhasil Terkirim ke BAU!</h5>
                            <p class="text-dark small mb-0" id="successDetailText"></p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-primary border-opacity-25 d-flex gap-2 justify-content-end">
                        <a href="<?= url('/laporan/pembukuan/lihat') ?>" class="btn btn-sm btn-primary fw-bold rounded px-4" style="background: #4f46e5; border-color: #4f46e5;">
                            <i class="bi bi-journal-richtext me-1"></i> Tinjau Log Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition {
        transition: all 0.3s ease;
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
    .bg-indigo-subtle {
        background-color: #e0e7ff;
    }
    .text-indigo {
        color: #4f46e5;
    }
</style>

<script>
    // Data mockup draf awal + data baru dari localStorage
    const initialReports = [
        { key: 'mei_2026', label: 'Laporan Pembukuan - Mei 2026 (Tahun Buku 2026)' },
        { key: 'april_2026', label: 'Laporan Pembukuan - April 2026 (Tahun Buku 2026)' },
        { key: 'maret_2026', label: 'Laporan Pembukuan - Maret 2026 (Tahun Buku 2026)' },
        { key: 'februari_2026', label: 'Laporan Pembukuan - Februari 2026 (Tahun Buku 2026)' }
    ];

    // Load data dropdown saat halaman terbuka
    document.addEventListener("DOMContentLoaded", function() {
        const select = document.getElementById('pilihLaporan');
        let drafList = JSON.parse(localStorage.getItem('pembukuan_draf_list')) || [];
        
        // Pilihan dari localStorage (baru dibuat)
        drafList.forEach((row, index) => {
            if (row.status !== 'Terkirim ke BAU') {
                const opt = document.createElement('option');
                opt.value = `local_${index}`;
                opt.innerText = `Laporan Pembukuan - ${row.periode} (Tahun Buku ${row.tahun})`;
                select.appendChild(opt);
            }
        });

        // Pilihan bawaan mock
        initialReports.forEach(row => {
            const opt = document.createElement('option');
            opt.value = row.key;
            opt.innerText = row.label;
            select.appendChild(opt);
        });
    });

    function simulateSending() {
        const overlay = document.getElementById('simulatedOverlay');
        const btnSubmit = document.getElementById('btnSubmitKirim');
        const loadingStep = document.getElementById('loadingStep');
        const successWidget = document.getElementById('successWidget');
        const successDetailText = document.getElementById('successDetailText');
        
        const loadingState = document.getElementById('loadingState');
        const successModalState = document.getElementById('successModalState');
        const successModalText = document.getElementById('successModalText');
        
        // Ambil data form
        const select = document.getElementById('pilihLaporan');
        const selectedText = select.options[select.selectedIndex].text;
        const penerima = document.getElementById('penerimaBAU').value;

        // Reset state modal
        loadingState.classList.remove('d-none');
        successModalState.classList.add('d-none');

        // 1. Matikan tombol dan tampilkan overlay loading
        btnSubmit.disabled = true;
        overlay.classList.remove('d-none');
        successWidget.classList.add('d-none');

        // 2. Alur Animasi Teks Langkah
        setTimeout(() => {
            loadingStep.innerText = "Mengenkripsi saluran transmisi data...";
        }, 800);

        setTimeout(() => {
            loadingStep.innerText = "Mengunggah berkas ke server BAU (Bagian Administrasi Umum)...";
        }, 1600);

        // 3. Penyelesaian & Selesai
        setTimeout(() => {
            // Sembunyikan spinner/loading dan tunjukkan status sukses di dalam modal
            loadingState.classList.add('d-none');
            successModalState.classList.remove('d-none');
            
            btnSubmit.disabled = false;

            // Update status di localStorage menjadi 'Terkirim ke BAU'
            const selectVal = select.value;
            if (selectVal.startsWith('local_')) {
                const localIdx = parseInt(selectVal.split('_')[1]);
                let drafList = JSON.parse(localStorage.getItem('pembukuan_draf_list')) || [];
                if (drafList[localIdx]) {
                    drafList[localIdx].status = 'Terkirim ke BAU';
                    localStorage.setItem('pembukuan_draf_list', JSON.stringify(drafList));
                }
            }

            // Isi pesan sukses secara dinamis untuk modal dan widget
            const detailMsg = `Berkas "${selectedText}" telah sukses dikirimkan secara elektronik kepada petugas ${penerima} pada Bagian Administrasi Umum (BAU) Koperasi.`;
            successModalText.innerText = detailMsg;
            successDetailText.innerText = detailMsg;
            
        }, 2400);
    }

    function closeSuccessModal() {
        const overlay = document.getElementById('simulatedOverlay');
        overlay.classList.add('d-none');
        
        // Tampilkan juga widget sukses persisten di halaman
        const successWidget = document.getElementById('successWidget');
        successWidget.classList.remove('d-none');
    }
</script>
