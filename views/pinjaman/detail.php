<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-1">Detail Pinjaman #<?= $pinjaman['id'] ?></h2>
        <p class="text-muted small mb-0">Informasi lengkap pengajuan pinjaman anggota.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <?php if (in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER]) && $pinjaman['status'] === 'DIAJUKAN'): ?>
            <a href="<?= url('/pinjaman/' . $pinjaman['id'] . '/verifikasi') ?>" class="btn btn-info btn-sm fw-semibold shadow-sm text-white">
                <i class="bi bi-check-circle me-1"></i> Verifikasi
            </a>
        <?php endif; ?>
        
        <?php if (Auth::role() === ROLE_KETUA && $pinjaman['status'] === 'DIVERIFIKASI'): ?>
            <a href="<?= url('/pinjaman/' . $pinjaman['id'] . '/approval') ?>" class="btn btn-primary btn-sm fw-semibold shadow-sm">
                <i class="bi bi-check2-all me-1"></i> Approval
            </a>
        <?php endif; ?>
        
        <?php if (in_array(Auth::role(), [ROLE_ADMIN, ROLE_TELLER]) && $pinjaman['status'] === 'DISETUJUI'): ?>
            <a href="<?= url('/pinjaman/' . $pinjaman['id'] . '/pencairan') ?>" class="btn btn-success btn-sm fw-semibold shadow-sm">
                <i class="bi bi-cash-coin me-1"></i> Cairkan Pinjaman
            </a>
        <?php endif; ?>

        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<?php if (Auth::role() === ROLE_ANGGOTA): ?>
<style>
/* Custom Stepper CSS ala m-banking */
.stepper-wrapper {
  margin-top: 10px;
  display: flex;
  justify-content: space-between;
  position: relative;
}
.stepper-item {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;
}
.stepper-item::before, .stepper-item::after {
  position: absolute;
  content: "";
  border-bottom: 2px solid #e2e8f0;
  width: 100%;
  top: 18px;
  z-index: 1;
}
.stepper-item::before { left: -50%; }
.stepper-item::after { left: 50%; }
.stepper-item:first-child::before,
.stepper-item:last-child::after { content: none; }

.stepper-item .step-counter {
  position: relative;
  z-index: 2;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: #f1f5f9;
  color: #94a3b8;
  margin-bottom: 8px;
  transition: all 0.3s;
}

.stepper-item.completed::after,
.stepper-item.active::before,
.stepper-item.completed ~ .stepper-item::before {
  border-bottom-color: #2563eb;
}

.stepper-item.completed .step-counter,
.stepper-item.active .step-counter {
  background-color: #2563eb;
  color: white;
  box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
}

.stepper-item.rejected .step-counter {
  background-color: #dc3545;
  color: white;
  box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
}
.stepper-item.rejected ~ .stepper-item::before,
.stepper-item.rejected::after {
    border-bottom-color: #dc3545;
}
[data-theme="dark"] .stepper-item::before, 
[data-theme="dark"] .stepper-item::after {
  border-bottom-color: var(--border);
}
[data-theme="dark"] .stepper-item .step-counter {
  background: var(--secondary);
  color: var(--muted-foreground);
}
[data-theme="dark"] .status-card-header {
  color: var(--foreground) !important;
}
</style>

<?php
$isRejected = ($pinjaman['status'] === 'DITOLAK');
$step1Class = 'completed'; // DIAJUKAN pasti terlewati
$step2Class = '';
$step3Class = '';

if (in_array($pinjaman['status'], ['DIVERIFIKASI', 'DISETUJUI'])) {
    $step2Class = 'active';
} elseif (in_array($pinjaman['status'], ['BERJALAN', 'LUNAS', 'DICAIRKAN'])) {
    $step2Class = 'completed';
    $step3Class = 'active';
} elseif ($isRejected) {
    $step2Class = 'rejected';
}
?>
<div class="card mb-4 border-0 shadow-sm" style="background-color: var(--secondary); border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0 status-card-header" style="color: #0f172a;">Status Pengajuan</h5>
            <span class="badge bg-primary-subtle text-primary py-2 px-3 rounded-pill" style="font-weight: 600;">
                <?= $isRejected ? 'Ditolak' : ($step3Class ? 'Selesai Pencairan' : 'Sedang Ditinjau') ?>
            </span>
        </div>
        <div class="mb-4">
            <h4 class="fw-bold mb-1"><?= e($pinjaman['tujuan'] ?: 'Pinjaman Personal Koperasi') ?></h4>
            <div class="text-muted small">ID: #HM-<?= str_pad($pinjaman['id'], 5, '0', STR_PAD_LEFT) ?></div>
        </div>

        <div class="stepper-wrapper mb-2">
            <div class="stepper-item <?= $step1Class ?>">
                <div class="step-counter"><i class="bi bi-check-lg"></i></div>
                <div class="step-name small fw-semibold <?= $step1Class ? '' : 'text-muted' ?>">Diterima</div>
            </div>
            <div class="stepper-item <?= $step2Class ?>">
                <div class="step-counter">
                    <?php if ($isRejected): ?>
                        <i class="bi bi-x-lg"></i>
                    <?php else: ?>
                        <i class="bi bi-journal-check"></i>
                    <?php endif; ?>
                </div>
                <div class="step-name small fw-semibold <?= $step2Class ? '' : 'text-muted' ?>">Verifikasi</div>
            </div>
            <div class="stepper-item <?= $step3Class ?>">
                <div class="step-counter"><i class="bi bi-wallet2"></i></div>
                <div class="step-name small fw-semibold <?= $step3Class ? '' : 'text-muted' ?>">Pencairan</div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0">Informasi Pinjaman</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small d-block">Status</label>
                    <div class="mt-1"><?= getStatusBadge($pinjaman['status'], 'pinjaman') ?></div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Pokok Pinjaman</label>
                    <div class="fw-bold fs-5 text-primary"><?= formatRupiah($pinjaman['pokok']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="text-muted small d-block">Tenor</label>
                        <div class="fw-medium"><?= $pinjaman['tenor_bulan'] ?> Bulan</div>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small d-block">Bunga</label>
                        <div class="fw-medium">
                            <?= formatPersen($pinjaman['bunga_persen_bln']) ?>
                        </div>
                    </div>
                </div>

                <div class="mb-0">
                    <label class="text-muted small d-block">Tujuan</label>
                    <div class="fw-medium"><?= e($pinjaman['tujuan'] ?: '-') ?></div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0">Informasi Anggota</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-circle <?= getAvatarColor($pinjaman['nama']) ?> me-3">
                        <?= getInitials($pinjaman['nama']) ?>
                    </div>
                    <div>
                        <div class="fw-bold"><?= e($pinjaman['nama']) ?></div>
                        <div class="text-muted small"><?= e($pinjaman['no_anggota']) ?></div>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="text-muted small d-block">Tipe Anggota</label>
                    <div class="fw-medium small"><?= e($pinjaman['anggota_tipe']) ?></div>
                </div>
                <div class="mb-2">
                    <label class="text-muted small d-block">No. HP</label>
                    <div class="fw-medium small"><?= e($pinjaman['no_hp'] ?: '-') ?></div>
                </div>
                <div class="mb-0">
                    <label class="text-muted small d-block">Identitas (NIDN/NIY/KTP)</label>
                    <div class="fw-medium small"><?= e($pinjaman['identitas_no'] ?: '-') ?></div>
                </div>

                <!-- FORM TAMBAHAN SIMPANAN SUKARELA -->
                <div class="mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary w-100 fw-semibold text-start shadow-sm rounded-3 d-flex justify-content-between align-items-center" id="btnToggleSukarela" onclick="toggleFormSukarela()" style="transition: all 0.2s;">
                        <span><i class="bi bi-eye me-2" id="iconSukarela"></i><span id="textSukarela">Tampilkan</span></span>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill" id="asteriskSukarela">********</span>
                    </button>

                    <div id="formSukarelaContainer" class="mt-3 p-3 rounded-3 shadow-sm" style="display: none; background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <h6 class="fw-bold mb-3 text-dark d-flex align-items-center" style="font-size: 0.95rem;">
                            <i class="bi bi-wallet2 text-info me-2"></i>Simpanan Sukarela: 
                        </h6>
                        <div class="d-flex align-items-center justify-content-between bg-white p-2 rounded border mb-3">
                            <span id="saldoAwalDisplay" class="fw-semibold text-primary" data-saldo="<?= $simpanan_sukarela_saat_ini ?? 0 ?>"><?= formatRupiah($simpanan_sukarela_saat_ini ?? 0) ?></span>
                            <span id="calcPlus" class="text-muted mx-2" style="display: none; font-weight: bold;"> + </span>
                            <span id="inputDisplay" class="fw-semibold text-warning" style="display: none;">0</span>
                            <span id="calcEquals" class="text-muted mx-2" style="display: none; font-weight: bold;"> = </span>
                            <span id="totalDisplay" class="fw-bold text-success fs-6" style="display: none;">...</span>
                        </div>

                        <label class="small text-muted mb-1 d-block fw-medium">Masukkan Jumlah Simpanan Sukarela Tambahan dari Anggota</label>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text bg-white text-muted border-end-0">Rp</span>
                            <input type="text" id="inputSimpananSukarela" class="form-control border-start-0 ps-0" placeholder="Contoh: 35000">
                        </div>
                        <div id="errorSukarela" class="text-danger small mb-3 fw-medium" style="display: none;">
                            <i class="bi bi-exclamation-triangle me-1"></i>Harap masukkan angka
                        </div>
                        
                        <button type="button" class="btn btn-primary btn-sm w-100 fw-bold shadow-sm" id="btnSimpanSukarela" onclick="simpanSukarela()">
                            <i class="bi bi-cloud-upload me-1"></i>Simpan
                        </button>
                    </div>
                </div>
                <!-- END FORM TAMBAHAN -->
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <?php if ($summary): ?>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body">
                        <label class="text-muted small d-block mb-1">Total Dibayar</label>
                        <div class="fw-bold text-success fs-5"><?= formatRupiah($summary['total_dibayar']) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body">
                        <label class="text-muted small d-block mb-1">Sisa Pokok</label>
                        <div class="fw-bold text-danger fs-5"><?= formatRupiah($summary['sisa_pokok']) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center pt-4 pb-3">
                <h5 class="card-title mb-0 fw-bold">Jadwal Angsuran</h5>
                <?php if ($pinjaman['status'] === 'BERJALAN' || $pinjaman['status'] === 'LUNAS'): ?>
                    <span class="badge bg-light text-dark fw-normal border">Estimasi Jadwal</span>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Ke</th>
                                <th>Jatuh Tempo</th>
                                <th class="text-end">Pokok</th>
                                <th class="text-end">Bunga</th>
                                <th class="text-end">Total Tagih</th>
                                <th class="text-center pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody id="jadwalTableBody">
                            <?php if (empty($jadwal)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted fst-italic">
                                        Jadwal akan muncul setelah pinjaman disetujui dan dicairkan.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($jadwal as $row): ?>
                                    <tr class="jadwal-row">
                                        <td class="ps-4 fw-medium text-muted align-middle"><?= $row['angsuran_ke'] ?></td>
                                        <td class="align-middle"><?= formatTanggalShort($row['jatuh_tempo']) ?></td>
                                        <td class="text-end align-middle"><?= formatRupiah($row['pokok_tagih']) ?></td>
                                        <td class="text-end align-middle"><?= formatRupiah($row['bunga_tagih']) ?></td>
                                        <td class="text-end fw-bold align-middle">
                                            <?= formatRupiah($row['total_tagih']) ?>
                                        </td>
                                        <td class="text-center pe-4 align-middle">
                                            <?php if ($row['status'] === 'BAYAR'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                                    LUNAS
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded-pill">
                                                    BELUM
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($jadwal) && count($jadwal) > 5): ?>
                <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
                    <div class="small fw-medium text-muted" id="jadwal-page-info">
                        Menampilkan data...
                    </div>
                    <div class="btn-group shadow-sm">
                        <button id="jadwal-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeJadwalPage(-1)">
                            <i class="bi bi-chevron-left me-1"></i> Prev
                        </button>
                        <button id="jadwal-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeJadwalPage(1)">
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
document.addEventListener("DOMContentLoaded", function() {
    const rows = document.querySelectorAll("#jadwalTableBody .jadwal-row");
    
    if (rows.length > 0) {
        const rowsPerPage = 5; // Tampilkan 5 baris per halaman
        let currentPage = 1;
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function displayJadwalTable(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Tampilkan atau Sembunyikan baris
            rows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.style.display = ""; // Tampilkan
                } else {
                    row.style.display = "none"; // Sembunyikan
                }
            });

            // Update teks info
            const currentEnd = Math.min(end, rows.length);
            const infoText = document.getElementById("jadwal-page-info");
            if (infoText) {
                infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${rows.length} angsuran`;
            }

            // Matikan tombol jika mentok
            const prevBtn = document.getElementById("jadwal-prev-btn");
            const nextBtn = document.getElementById("jadwal-next-btn");
            
            if (prevBtn) prevBtn.disabled = (page === 1);
            if (nextBtn) nextBtn.disabled = (page === totalPages);
        }

        displayJadwalTable(currentPage);

        window.changeJadwalPage = function(step) {
            currentPage += step;
            
            if (currentPage < 1) currentPage = 1;
            if (currentPage > totalPages) currentPage = totalPages;
            
            displayJadwalTable(currentPage);
        };
    }

    // --- LOGIKA SIMPANAN SUKARELA TAMBAHAN ---
    const btnToggle = document.getElementById('btnToggleSukarela');
    const container = document.getElementById('formSukarelaContainer');
    const icon = document.getElementById('iconSukarela');
    const textBtn = document.getElementById('textSukarela');
    const asterisk = document.getElementById('asteriskSukarela');
    const input = document.getElementById('inputSimpananSukarela');
    const errorMsg = document.getElementById('errorSukarela');
    const calcPlus = document.getElementById('calcPlus');
    const inputDisplay = document.getElementById('inputDisplay');
    const calcEquals = document.getElementById('calcEquals');
    const totalDisplay = document.getElementById('totalDisplay');
    const saldoAwalSpan = document.getElementById('saldoAwalDisplay');
    
    let saldoAwal = parseFloat(saldoAwalSpan.getAttribute('data-saldo')) || 0;

    window.toggleFormSukarela = function() {
        if (container.style.display === 'none') {
            container.style.display = 'block';
            icon.className = 'bi bi-eye-slash me-2';
            textBtn.innerText = 'Tutup';
            btnToggle.classList.replace('btn-outline-secondary', 'btn-secondary');
            btnToggle.classList.replace('text-start', 'text-center');
            asterisk.style.display = 'none';
        } else {
            container.style.display = 'none';
            icon.className = 'bi bi-eye me-2';
            textBtn.innerText = 'Tampilkan';
            btnToggle.classList.replace('btn-secondary', 'btn-outline-secondary');
            btnToggle.classList.replace('text-center', 'text-start');
            asterisk.style.display = 'inline-block';
            // Reset input
            input.value = '';
            input.dispatchEvent(new Event('input'));
        }
    };

    if (input) {
        input.addEventListener('input', function(e) {
            let val = this.value.replace(/\./g, '');
            
            if (val === '') {
                errorMsg.style.display = 'none';
                calcPlus.style.display = 'none';
                inputDisplay.style.display = 'none';
                calcEquals.style.display = 'none';
                totalDisplay.style.display = 'none';
                return;
            }

            if (!/^\d+$/.test(val)) {
                errorMsg.style.display = 'block';
                calcPlus.style.display = 'none';
                inputDisplay.style.display = 'none';
                calcEquals.style.display = 'none';
                totalDisplay.style.display = 'none';
            } else {
                errorMsg.style.display = 'none';
                let tambahan = parseFloat(val);
                let totalBaru = saldoAwal + tambahan;
                
                calcPlus.style.display = 'inline';
                inputDisplay.style.display = 'inline';
                inputDisplay.innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(tambahan);
                
                calcEquals.style.display = 'inline';
                totalDisplay.style.display = 'inline';
                totalDisplay.innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalBaru);
            }
        });
    }

    window.simpanSukarela = function() {
        let val = input.value.replace(/\./g, '');
        if (val === '' || !/^\d+$/.test(val)) {
            errorMsg.style.display = 'block';
            input.focus();
            return;
        }

        let tambahan = parseFloat(val);
        const btnSimpan = document.getElementById('btnSimpanSukarela');
        btnSimpan.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
        btnSimpan.disabled = true;

        fetch('<?= url("/api/pinjaman/sukarela/tambah") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'anggota_id=<?= $pinjaman["anggota_id"] ?>&tambahan=' + tambahan
        })
        .then(response => {
            return response.text().then(text => {
                return { ok: response.ok, status: response.status, text: text };
            });
        })
        .then(res => {
            try {
                const data = JSON.parse(res.text);
                if (data.success) {
                    // Update tampilan saldo baru
                    saldoAwal += tambahan;
                    saldoAwalSpan.setAttribute('data-saldo', saldoAwal);
                    saldoAwalSpan.innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(saldoAwal);
                    
                    alert('Sukses: ' + data.message);
                    toggleFormSukarela(); // Tutup form
                } else {
                    alert('Gagal: ' + data.message);
                }
            } catch (e) {
                console.error('Server response was not JSON:', res.text);
                alert('Gagal memproses response (Status: ' + res.status + ').\n\nIsi response:\n' + res.text.substring(0, 500));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan jaringan: ' + error.message);
        })
        .finally(() => {
            btnSimpan.innerHTML = '<i class="bi bi-cloud-upload me-1"></i>Simpan';
            btnSimpan.disabled = false;
        });
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