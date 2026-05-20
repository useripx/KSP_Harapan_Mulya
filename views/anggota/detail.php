<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0"><?= $pageTitle ?></h2>
        <p class="text-muted small mb-0">Informasi profil lengkap dan data keanggotaan.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/anggota/' . $anggota['id'] . '/edit') ?>" class="btn btn-warning btn-sm shadow-sm fw-semibold">
            <i class="bi bi-pencil me-1"></i> Edit Anggota
        </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Informasi Profil</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">No. Anggota</label>
                        <span class="h6 fw-bold text-primary"><?= e($anggota['no_anggota']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Status Keanggotaan</label>
                        <?= getStatusBadge($anggota['status'], 'anggota') ?>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Nama Lengkap</label>
                        <span class="h5 fw-semibold"><?= e($anggota['nama']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Tipe Anggota</label>
                        <span class="badge bg-info text-dark border"><?= e($anggota['tipe']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Tanggal Terdaftar</label>
                        <span><?= date('d F Y', strtotime($anggota['tgl_daftar'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Kontak & Identitas</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">No. Identitas (KTP)</label>
                        <span><?= e($anggota['identitas_no'] ?: '-') ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">No. HP / WhatsApp</label>
                        <span><?= e($anggota['no_hp'] ?: '-') ?></span>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Prodi / Unit Kerja</label>
                        <span><?= e($anggota['prodi_unit'] ?: '-') ?></span>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Alamat Lengkap</label>
                        <p class="mb-0"><?= nl2br(e($anggota['alamat'] ?: '-')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-primary text-white mb-4 shadow-sm border-0">
            <div class="card-body py-4 text-center">
                <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-person h1 mb-0"></i>
                </div>
                <h5 class="mb-1 text-white"><?= e($anggota['nama']) ?></h5>
                <p class="opacity-75 small mb-0"><?= e($anggota['no_anggota']) ?></p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="card-title text-muted mb-3">
                    <i class="bi bi-folder-fill me-2 text-warning"></i>Dokumen Kelengkapan
                </h6>
                <div class="list-group list-group-flush small">
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <div><i class="bi bi-card-heading me-2 text-secondary"></i> KTP Anggota</div>
                        <?php if (!empty($listDokumen['ktp'])): ?>
                            <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/ktp') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                <i class="bi bi-eye me-1"></i>Buka
                            </a>
                        <?php else: ?>
                            <span class="text-danger small italic">Belum diupload</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <div><i class="bi bi-people me-2 text-secondary"></i> Kartu Keluarga</div>
                        <?php if (!empty($listDokumen['kk'])): ?>
                            <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/kk') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                <i class="bi bi-eye me-1"></i>Buka
                            </a>
                        <?php else: ?>
                            <span class="text-danger small italic">Belum diupload</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <div><i class="bi bi-file-earmark-text me-2 text-secondary"></i> Surat Perjanjian</div>
                        <?php if (!empty($listDokumen['perjanjian'])): ?>
                            <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/perjanjian') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                <i class="bi bi-eye me-1"></i>Buka
                            </a>
                        <?php else: ?>
                            <span class="text-danger small italic">Belum diupload</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <div><i class="bi bi-file-earmark-arrow-up me-2 text-secondary"></i> Form Pengajuan</div>
                        <?php if (!empty($listDokumen['pengajuan'])): ?>
                            <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/pengajuan') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                <i class="bi bi-eye me-1"></i>Buka
                            </a>
                        <?php else: ?>
                            <span class="text-danger small italic">Belum diupload</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="card-title text-muted mb-3">Ringkasan Keuangan</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Total Simpanan</span>
                    <span class="fw-bold">Rp <?= formatRupiah($saldo ?? 0) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-0">
                    <span class="small text-muted">Total Pinjaman</span>
                    <span class="fw-bold text-danger">Rp <?= formatRupiah($totalPinjaman ?? 0) ?></span>
                </div>

                <?php 
                $userRole = Auth::role();
                if (in_array($userRole, [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA])): 
                ?>
                <!-- FORM TAMBAHAN SIMPANAN SUKARELA -->
                <div class="mt-3 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary w-100 fw-semibold text-start shadow-sm rounded-3 d-flex justify-content-between align-items-center" id="btnToggleSukarela" onclick="toggleFormSukarela()" style="transition: all 0.2s;">
                        <span><i class="bi bi-eye me-2" id="iconSukarela"></i><span id="textSukarela">Tampilkan Simpanan Sukarela</span></span>
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

                        <label class="small text-muted mb-1 d-block fw-medium">Masukkan Jumlah Simpanan Sukarela Tambahan</label>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnToggle = document.getElementById('btnToggleSukarela');
    if (!btnToggle) return; // Jika role tidak diizinkan, script ini keluar
    
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
            textBtn.innerText = 'Tampilkan Simpanan Sukarela';
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
            body: 'anggota_id=<?= $anggota["id"] ?>&tambahan=' + tambahan
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
                    
                    // Reload halaman agar Total Simpanan terupdate secara dinamis
                    location.reload();
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
