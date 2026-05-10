<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Pengajuan Pinjaman Baru</h2>
        <p class="text-muted small mb-0">Silakan lengkapi formulir pengajuan di bawah ini.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/dashboard') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Formulir Pengajuan</h5>
            </div>
            <div class="card-body">
                <form action="<?= url('/pinjaman/store') ?>" method="POST">
                    <?= View::csrf() ?>
                    
                    <?php if (Auth::role() !== ROLE_ANGGOTA): ?>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Anggota Nasabah</label>
                        <div class="position-relative" id="memberSearchContainer">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" id="memberSearch" class="form-control border-start-0" placeholder="Ketik nama atau nomor anggota..." autocomplete="off">
                            </div>
                            <input type="hidden" name="anggota_id" id="selected_anggota_id" required>
                            
                            <!-- Search Results Dropdown -->
                            <div id="searchResults" class="list-group position-absolute w-100 shadow-sm mt-1 d-none" style="z-index: 1000; max-height: 250px; overflow-y: auto;">
                                <!-- AJAX results here -->
                            </div>
                        </div>
                        <div id="selectedMemberInfo" class="mt-2 p-3 bg-light rounded d-none">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold" id="info_nama">-</div>
                                    <div class="text-muted small" id="info_no">-</div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger border-0" id="clearMemberSelection">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                            <div class="mt-2 pt-2 border-top">
                                <span class="text-muted small">Saldo Terkini:</span>
                                <span class="fw-bold text-success ms-1" id="info_saldo">Rp 0</span>
                            </div>
                        </div>
                        <?php if (isset($errors['anggota_id'])): ?>
                            <div class="text-danger small mt-1"><?= $errors['anggota_id'] ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label">Jumlah Pinjaman (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                <input type="number" name="pokok" class="form-control" placeholder="0" min="500000" value="<?= old('pokok') ?>" required>
                                </div>
                                <?php if ($error = View::error('pokok')): ?>
                                    <div class="text-danger small mt-1"><?= $error ?></div>
                                <?php endif; ?>
                                <div class="text-muted small mt-1">Minimal pengajuan Rp 500.000</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">Tenor (Bulan)</label>
                                <select name="tenor_bulan" class="form-select" required>
                                    <?php for($i=1; $i<=36; $i++): ?>
                                        <option value="<?= $i ?>" <?= old('tenor_bulan', 12) == $i ? 'selected' : '' ?>><?= $i ?> Bulan</option>
                                    <?php endfor; ?>
                                </select>
                                <?php if ($error = View::error('tenor_bulan')): ?>
                                    <div class="text-danger small mt-1"><?= $error ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="metode" value="FLAT">

                    <div class="mb-3">
                        <label class="form-label">Tujuan Penggunaan</label>
                        <textarea name="tujuan" class="form-control" rows="3" placeholder="Contoh: Biaya pendidikan, renovasi rumah, dll" required><?= e(old('tujuan')) ?></textarea>
                        <?php if ($error = View::error('tujuan')): ?>
                            <div class="text-danger small mt-1"><?= $error ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                            <div class="small">
                                <strong>Catatan:</strong> Pengajuan akan melewati proses verifikasi oleh Staff dan persetujuan oleh Ketua Koperasi. Anda akan menerima notifikasi jika status pengajuan berubah.
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-5">
        <div class="card h-100 border-0 bg-light">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Panduan Pengajuan</h5>
                
                <div class="mb-4">
                    <div class="d-flex mb-2">
                        <div class="bg-white rounded-circle shadow-sm p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <span class="fw-bold text-primary small">1</span>
                        </div>
                        <h6 class="mb-0 mt-1 fw-bold">Plafon Maksimal</h6>
                    </div>
                    <p class="text-muted small ps-5">Pinjaman maksimal adalah 3x dari total saldo simpanan anggota saat ini.</p>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex mb-2">
                        <div class="bg-white rounded-circle shadow-sm p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <span class="fw-bold text-primary small">2</span>
                        </div>
                        <h6 class="mb-0 mt-1 fw-bold">Suku Bunga</h6>
                    </div>
                    <p class="text-muted small ps-5">Bunga <?= e($settings['bunga_jangka_pendek']) ?>% untuk tenor 1 bulan, dan <?= e($settings['bunga_jangka_panjang']) ?>% per bulan untuk tenor di atas 1 bulan.</p>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex mb-2">
                        <div class="bg-white rounded-circle shadow-sm p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <span class="fw-bold text-primary small">3</span>
                        </div>
                        <h6 class="mb-0 mt-1 fw-bold">Tenor</h6>
                    </div>
                    <p class="text-muted small ps-5">Jangka waktu pengembalian dapat dipilih antara 1 hingga 36 bulan.</p>
                </div>

                <div class="mt-5 p-4 bg-primary text-white rounded-4 shadow">
                    <h6 class="fw-bold mb-1">Butuh Bantuan?</h6>
                    <p class="small opacity-75 mb-0">Hubungi petugas koperasi di bagian pelayanan atau melalui WhatsApp.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const memberSearch = document.getElementById('memberSearch');
    const searchResults = document.getElementById('searchResults');
    const selectedAnggotaId = document.getElementById('selected_anggota_id');
    const selectedMemberInfo = document.getElementById('selectedMemberInfo');
    const infoNama = document.getElementById('info_nama');
    const infoNo = document.getElementById('info_no');
    const infoSaldo = document.getElementById('info_saldo');
    const clearBtn = document.getElementById('clearMemberSelection');
    const searchContainer = document.getElementById('memberSearchContainer');

    let timeout = null;

    if (memberSearch) {
        memberSearch.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.classList.add('d-none');
                return;
            }

            timeout = setTimeout(() => {
                fetch(`<?= url('/api/anggota/search') ?>?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'list-group-item list-group-item-action py-2';
                                btn.innerHTML = `
                                    <div class="fw-bold">${item.nama}</div>
                                    <div class="text-muted small">${item.no_anggota}</div>
                                `;
                                btn.onclick = () => selectMember(item);
                                searchResults.appendChild(btn);
                            });
                            searchResults.classList.remove('d-none');
                        } else {
                            searchResults.innerHTML = '<div class="list-group-item disabled">Tidak ditemukan</div>';
                            searchResults.classList.remove('d-none');
                        }
                    });
            }, 300);
        });

        // Close results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchContainer.contains(e.target)) {
                searchResults.classList.add('d-none');
            }
        });
    }

    function selectMember(member) {
        selectedAnggotaId.value = member.id;
        infoNama.textContent = member.nama;
        infoNo.textContent = member.no_anggota;
        
        // Hide search, show info
        searchContainer.classList.add('d-none');
        selectedMemberInfo.classList.remove('d-none');
        searchResults.classList.add('d-none');
        memberSearch.value = '';

        // Fetch saldo
        infoSaldo.textContent = 'Memuat...';
        fetch(`<?= url('/api/anggota/') ?>${member.id}/saldo`)
            .then(response => response.json())
            .then(data => {
                infoSaldo.textContent = data.saldo_formatted;
            })
            .catch(() => {
                infoSaldo.textContent = 'Gagal memuat';
            });
    }

    if (clearBtn) {
        clearBtn.onclick = () => {
            selectedAnggotaId.value = '';
            searchContainer.classList.remove('d-none');
            selectedMemberInfo.classList.add('d-none');
            memberSearch.focus();
        };
    }
});
</script>
