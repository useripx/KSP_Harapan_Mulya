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
    <div class="col-md-4">
        <a href="#" onclick="event.preventDefault(); openCalendarModal();" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-card-premium transition" style="border-left: 4px solid #4f46e5 !important; border-radius: 12px; background: #fff;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #e0e7ff; color: #4f46e5; width: 52px; height: 52px;">
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
    <div class="col-md-4">
        <a href="<?= url('/laporan/pembukuan/lihat') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-card-premium transition" style="border-left: 4px solid #10b981 !important; border-radius: 12px; background: #fff;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #d1fae5; color: #059669; width: 52px; height: 52px;">
                            <i class="bi bi-journal-richtext fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold text-dark fs-6">Lihat Laporan</h6>
                    </div>
                    <p class="card-text text-muted small mb-0">Tinjau, telusuri, dan periksa kembali log berkas laporan pembukuan yang telah difinalisasi.</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 3: Kirim Laporan -->
    <div class="col-md-4">
        <a href="<?= url('/laporan/pembukuan/kirim') ?>" class="text-decoration-none h-100 d-block">
            <div class="card border-0 shadow-sm h-100 hover-card-premium transition" style="border-left: 4px solid #6366f1 !important; border-radius: 12px; background: #fff;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #ede9fe; color: #6366f1; width: 52px; height: 52px;">
                            <i class="bi bi-send-check-fill fs-4"></i>
                        </div>
                        <h6 class="card-title mb-0 fw-bold text-dark fs-6">Kirim Laporan</h6>
                    </div>
                    <p class="card-text text-muted small mb-0">Kirimkan berkas laporan final secara resmi langsung ke sistem Bagian Administrasi Umum (BAU).</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Modal Kalender Picker Premium (Windows Style) -->
<div class="modal fade" id="modalCalendarPicker" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 360px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 8px; background-color: #ffffff; font-family: 'Segoe UI', 'Segoe UI Variable', Tahoma, Geneva, sans-serif;">
            <div class="modal-body p-4">
                
                <!-- Windows-style Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                    <div class="d-flex align-items-center gap-1">
                        <select id="calendarMonthSelect" onchange="updateCalendarGrid()" class="form-select form-select-sm shadow-none border-0 fw-semibold" style="width: auto; background-color: transparent; color: #1a1a1a; font-size: 16px; padding-left: 0; padding-right: 24px; cursor: pointer;">
                            <option value="0">January</option>
                            <option value="1">February</option>
                            <option value="2">March</option>
                            <option value="3">April</option>
                            <option value="4">May</option>
                            <option value="5" selected>June</option>
                            <option value="6">July</option>
                            <option value="7">August</option>
                            <option value="8">September</option>
                            <option value="9">October</option>
                            <option value="10">November</option>
                            <option value="11">December</option>
                        </select>
                        <select id="calendarYearSelect" onchange="updateCalendarGrid()" class="form-select form-select-sm shadow-none border-0 fw-semibold" style="width: auto; background-color: transparent; color: #1a1a1a; font-size: 16px; padding-left: 0; cursor: pointer;">
                            <!-- Populated via Javascript (1926 - 2126) -->
                        </select>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm text-dark border-0 p-1 px-2 hover-bg-light rounded" onclick="prevMonth()" style="background: transparent;"><i class="bi bi-chevron-up"></i></button>
                        <button type="button" class="btn btn-sm text-dark border-0 p-1 px-2 hover-bg-light rounded" onclick="nextMonth()" style="background: transparent;"><i class="bi bi-chevron-down"></i></button>
                    </div>
                </div>

                <!-- Windows-style Grid Header (Su, Mo, Tu...) -->
                <div class="calendar-grid-header mb-2" style="display: grid; grid-template-columns: repeat(7, 40px); justify-content: center; text-align: center; font-size: 12px; font-weight: 600; color: #1a1a1a;">
                    <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                </div>

                <!-- Calendar Grid -->
                <div class="d-flex justify-content-center mb-4">
                    <div id="calendarGrid" class="calendar-grid-container">
                        <!-- Populated via Javascript -->
                    </div>
                </div>

                <!-- Action Buttons (Windows style) -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" onclick="cancelCalendarSelection()" class="btn btn-light px-4 py-1 fw-semibold btn-windows-cancel">Cancel</button>
                    <button type="button" onclick="confirmCalendarSelection()" class="btn btn-primary px-4 py-1 fw-semibold btn-windows-ok">OK</button>
                </div>
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
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .spinning-icon {
        animation: spin 1.5s linear infinite;
        display: inline-block;
    }

    /* Styles for Windows Calendar Picker */
    .calendar-grid-container {
        display: grid;
        grid-template-columns: repeat(7, 40px);
        grid-gap: 4px 4px;
        justify-content: center;
        align-items: center;
    }
    .calendar-day-cell {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-family: 'Segoe UI', 'Segoe UI Variable', Tahoma, Geneva, sans-serif;
        font-weight: 400;
        font-size: 14px;
        color: #1a1a1a;
        border-radius: 50%;
        transition: background-color 0.1s ease;
    }
    .calendar-day-cell:hover:not(.empty-cell):not(.selected-day) {
        background-color: #f0f0f0;
    }
    .calendar-day-cell.selected-day {
        background-color: #0067c0 !important;
        color: #ffffff !important;
        font-weight: 600;
    }
    .empty-cell {
        cursor: default;
        visibility: hidden;
    }
    
    /* Windows Buttons */
    .btn-windows-cancel {
        border-radius: 4px; 
        border: 1px solid #d1d1d1; 
        background: #fdfdfd; 
        font-size: 14px;
    }
    .btn-windows-cancel:hover {
        background: #f0f0f0;
    }
    .btn-windows-ok {
        border-radius: 4px; 
        background: #0067c0; 
        border-color: #0067c0; 
        font-size: 14px;
    }
    .btn-windows-ok:hover {
        background: #005aab;
        border-color: #005aab;
    }
    /* Hover bg light for arrows */
    .hover-bg-light:hover {
        background-color: #f0f0f0 !important;
    }
</style>

<script>
    // State Kalender Picker
    let currentSelectedYear = 2026;
    let currentSelectedMonth = 5; // Juni (0-indexed)
    let currentSelectedDay = 23;  // 23 Juni

    function openCalendarModal() {
        const modalEl = document.getElementById('modalCalendarPicker');
        const modal = new bootstrap.Modal(modalEl);
        
        // Populate year dropdown if empty (1926 to 2126)
        const yearSelect = document.getElementById('calendarYearSelect');
        if (yearSelect.options.length === 0) {
            for (let y = 1926; y <= 2126; y++) {
                const opt = document.createElement('option');
                opt.value = y;
                opt.text = y;
                yearSelect.appendChild(opt);
            }
        }
        
        // Sync state dengan dropdown modal
        document.getElementById('calendarMonthSelect').value = currentSelectedMonth;
        document.getElementById('calendarYearSelect').value = currentSelectedYear;
        
        updateCalendarGrid();
        modal.show();
    }

    function prevMonth() {
        let month = parseInt(document.getElementById('calendarMonthSelect').value);
        let year = parseInt(document.getElementById('calendarYearSelect').value);
        if (month === 0) {
            if (year > 1926) {
                document.getElementById('calendarMonthSelect').value = 11;
                document.getElementById('calendarYearSelect').value = year - 1;
            }
        } else {
            document.getElementById('calendarMonthSelect').value = month - 1;
        }
        updateCalendarGrid();
    }

    function nextMonth() {
        let month = parseInt(document.getElementById('calendarMonthSelect').value);
        let year = parseInt(document.getElementById('calendarYearSelect').value);
        if (month === 11) {
            if (year < 2126) {
                document.getElementById('calendarMonthSelect').value = 0;
                document.getElementById('calendarYearSelect').value = year + 1;
            }
        } else {
            document.getElementById('calendarMonthSelect').value = month + 1;
        }
        updateCalendarGrid();
    }

    function updateCalendarGrid() {
        const grid = document.getElementById('calendarGrid');
        grid.innerHTML = ''; // Reset grid

        // Dapatkan indeks bulan dan tahun terpilih
        const monthSelect = document.getElementById('calendarMonthSelect');
        const yearSelect = document.getElementById('calendarYearSelect');
        currentSelectedMonth = parseInt(monthSelect.value);
        currentSelectedYear = parseInt(yearSelect.value);

        // Kalkulasi tanggal
        const firstDayIndex = new Date(currentSelectedYear, currentSelectedMonth, 1).getDay(); // 0: Minggu, 1: Senin, dst.
        const totalDays = new Date(currentSelectedYear, currentSelectedMonth + 1, 0).getDate();

        // 1. Render empty cells untuk sebelum tanggal 1
        for (let i = 0; i < firstDayIndex; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-day-cell empty-cell';
            grid.appendChild(emptyCell);
        }

        // 2. Render tanggal 1 sampai akhir bulan
        for (let day = 1; day <= totalDays; day++) {
            const cell = document.createElement('div');
            cell.className = 'calendar-day-cell';
            cell.innerText = day;

            // Cek apakah hari Minggu
            const dayOfWeek = (firstDayIndex + day - 1) % 7;
            if (dayOfWeek === 0) {
                cell.classList.add('sunday');
            }

            // Cek apakah tanggal sedang terpilih
            if (day === currentSelectedDay) {
                cell.classList.add('selected-day');
            }

            // Click Handler
            cell.addEventListener('click', function() {
                // Hapus outline lama
                const oldSelected = grid.querySelector('.selected-day');
                if (oldSelected) {
                    oldSelected.classList.remove('selected-day');
                }
                // Tambah outline baru
                cell.classList.add('selected-day');
                currentSelectedDay = day;
            });

            grid.appendChild(cell);
        }
    }

    function cancelCalendarSelection() {
        const modalEl = document.getElementById('modalCalendarPicker');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
            modal.hide();
        }
    }

    function confirmCalendarSelection() {
        // Tutup Modal
        const modalEl = document.getElementById('modalCalendarPicker');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
            modal.hide();
        }
        
        // Langsung generate draf laporan tanpa form page
        simulateGeneration();
    }

    function simulateGeneration() {
        const overlay = document.getElementById('simulatedOverlay');
        const loadingStep = document.getElementById('loadingStep');
        const successWidget = document.getElementById('successWidget');
        const successDetailText = document.getElementById('successDetailText');
        
        // Format Teks Tanggal yang Dipilih
        const monthSelect = document.getElementById('calendarMonthSelect');
        const monthName = monthSelect.options[currentSelectedMonth].text;
        const displayPeriode = `${currentSelectedDay} ${monthName} ${currentSelectedYear}`;

        // 1. Tampilkan overlay loading
        overlay.classList.remove('d-none');
        successWidget.classList.add('d-none');

        // 2. Alur Animasi Teks Langkah
        setTimeout(() => {
            loadingStep.innerText = "Mengkalkulasi Laba/Rugi Koperasi...";
        }, 800);

        setTimeout(() => {
            loadingStep.innerText = "Menyusun draf final laporan pembukuan...";
        }, 1600);

        // 3. Penyelesaian & Selesai
        setTimeout(() => {
            overlay.classList.add('d-none');

            successDetailText.innerText = `Draf laporan untuk tanggal ${displayPeriode} (Tahun Buku 2026) telah selesai disusun dengan status final dan siap dikirimkan ke BAU.`;
            
            // Tampilkan widget sukses
            successWidget.classList.remove('d-none');
            
            // Simpan draf ke localStorage agar data terlihat dinamis di Lihat Laporan!
            let drafList = JSON.parse(localStorage.getItem('pembukuan_draf_list')) || [];
            drafList.unshift({
                periode: displayPeriode,
                tahun: '2026',
                dibuat: new Date().toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'}),
                status: 'Draf'
            });
            localStorage.setItem('pembukuan_draf_list', JSON.stringify(drafList));
            
        }, 2400);
    }
</script>
