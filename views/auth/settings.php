<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Pengaturan Akun</h2>
        <p class="text-muted small mb-0">Kelola informasi profil dan keamanan akun Anda.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/dashboard') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <h5 class="fw-bold mb-0">Menu Pengaturan</h5>
                </div>
                <p class="text-muted small mb-4">Navigasi pengaturan akun Anda.</p>

                <div class="list-group list-group-settings">
                    <a href="#security" class="list-group-item list-group-item-action d-flex align-items-center active">
                        <div class="icon-wrapper me-3">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Keamanan</div>
                            <div class="small opacity-75">Ganti password & proteksi</div>
                        </div>
                    </a>

                    <?php if (Auth::role() === ROLE_ADMIN): ?>
                    <a href="#savings-config" class="list-group-item list-group-item-action d-flex align-items-center mt-2">
                        <div class="icon-wrapper me-3">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Konfigurasi Simpanan</div>
                            <div class="small opacity-75">Atur nominal simpanan</div>
                        </div>
                    </a>
                    <?php endif; ?>

                    <?php if (Auth::role() === ROLE_KETUA): ?>
                    <a href="#interest" class="list-group-item list-group-item-action d-flex align-items-center mt-2">
                        <div class="icon-wrapper me-3">
                            <i class="bi bi-percent"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Suku Bunga</div>
                            <div class="small opacity-75">Atur bunga pinjaman</div>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div id="security" class="settings-section card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <h5 class="card-title mb-0 fw-bold">Ganti Password</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="<?= url('/settings/password/update') ?>" method="POST">
                    <?= View::csrf() ?>
                    
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4 text-muted small">Password Saat Ini</div>
                        <div class="col-md-8">
                        <div class="password-wrapper position-relative">
                            <input type="password" name="old_password" class="form-control" required>
                            <div class="password-toggle position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer" style="z-index: 10;">
                                <i class="bi bi-eye-slash"></i>
                            </div>
                        </div>                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <div class="col-md-4 text-muted small">Password Baru</div>
                        <div class="col-md-8">
                            <div class="password-wrapper position-relative">
                                <input type="password" name="new_password" class="form-control" placeholder="Minimal 6 karakter" required>
                                <div class="password-toggle position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer" style="z-index: 10;">
                                    <i class="bi bi-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-4 text-muted small">Konfirmasi Password</div>
                        <div class="col-md-8">
                            <div class="password-wrapper position-relative">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password baru" required>
                                <div class="password-toggle position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer" style="z-index: 10;">
                                    <i class="bi bi-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (Auth::role() === ROLE_ADMIN): ?>
        <div id="savings-config" class="settings-section d-none">
            <div class="mb-4">
                <label class="form-label fw-bold text-secondary">Pilih Anggota untuk Konfigurasi</label>
                <div class="position-relative" id="memberSearchContainer" style="z-index: 1000;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="search-anggota" class="form-control border-start-0 ps-0 shadow-none" placeholder="Masukkan nama atau nomor anggota..." autocomplete="off">
                    </div>
                    <!-- Search Results Dropdown (Google Style) -->
                    <div id="search-results" class="list-group position-absolute w-100 d-none" style="z-index: 9999 !important; top: 100%; border-radius: 12px; overflow: hidden; margin-top: 8px; background: white !important; border: 1px solid rgba(0,0,0,0.15); box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
                        <!-- AJAX results here -->
                    </div>
                </div>

                <div id="selectedMemberInfo" class="mt-2 p-3 bg-primary bg-opacity-10 border border-primary border-opacity-10 rounded d-none">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-primary" id="info_nama">-</div>
                            <div class="text-muted small" id="info_no">-</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger border-0" id="clearMemberSelection">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                            <i class="bi bi-piggy-bank-fill"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Parameter Simpanan</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!--<div class="alert alert-warning border-0 mb-4 small">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Perubahan ini akan menjadi acuan standar anggota terpilih.
                    </div>-->
                    <form action="<?= url('/settings/savings/update') ?>" method="POST">
                        <?= View::csrf() ?>
                        <input type="hidden" name="user_id" id="form_target_user_id">
                        
                        <?php
                            $fields = ['simpanan_motor' => 'Simpanan motor ', 'simpanan_mobil' => 'Simpanan mobil '];
                            foreach($fields as $name => $label):
                        ?>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-5 fw-medium small"><?= $label ?></div>
                            <div class="col-md-7">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="<?= $name ?>" class="form-control" value="<?= e($settings[$name] ?? '0') ?>">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Konfigurasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (Auth::role() === ROLE_KETUA): ?>
        <div id="interest" class="settings-section card border-0 shadow-sm mb-4 d-none">
            <div class="card-header bg-white border-bottom pt-4 pb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                        <i class="bi bi-percent"></i>
                    </div>
                    <h5 class="card-title mb-0 fw-bold">Konfigurasi Suku Bunga</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="<?= url('/settings/interest/update') ?>" method="POST">
                    <?= View::csrf() ?>
                    <div class="row align-items-center mb-4">
                        <div class="col-md-5 fw-medium">
                            <div>Suku Bunga Jangka Pendek</div>
                            <small class="text-muted d-block mt-1">Berlaku untuk pinjaman dengan tenor tepat 1 bulan.</small>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="number" step="0.01" name="bunga_jangka_pendek" class="form-control" value="<?= e($settings['bunga_jangka_pendek'] ?? '1.00') ?>" required>
                                <span class="input-group-text">% per bulan</span>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-5 fw-medium">
                            <div>Suku Bunga Jangka Panjang</div>
                            <small class="text-muted d-block mt-1">Berlaku untuk pinjaman dengan tenor lebih dari 1 bulan.</small>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="number" step="0.01" name="bunga_jangka_panjang" class="form-control" value="<?= e($settings['bunga_jangka_panjang'] ?? '0.60') ?>" required>
                                <span class="input-group-text">% per bulan</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan Bunga
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- FITUR MATA (LOGIK TERBARU) ---
    // Gunakan event delegation pada document agar lebih "galak" menangkap klik
    document.addEventListener('click', function(e) {
        // Cek apakah yang diklik adalah .password-toggle atau ikon di dalamnya
        const toggle = e.target.closest('.password-toggle');
        
        if (toggle) {
            const wrapper = toggle.closest('.password-wrapper');
            const input = wrapper.querySelector('input');
            const icon = toggle.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye'; // Paksa ganti class
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye-slash'; // Paksa ganti class
            }
        }
    });

    // --- LOGIC NAVIGASI SECTION ---
    const navLinks = document.querySelectorAll('.list-group-settings a');
    const sections = document.querySelectorAll('.settings-section');

    function showSection(id) {
        const validIds = ['#security', '#interest', '#savings-config'];
        if (!validIds.includes(id)) return;
        sections.forEach(s => s.classList.add('d-none'));
        const target = document.querySelector(id);
        if (target) target.classList.remove('d-none');
        navLinks.forEach(l => l.classList.remove('active'));
        const link = document.querySelector(`.list-group-settings a[href="${id}"]`);
        if (link) link.classList.add('active');
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const id = this.getAttribute('href');
            if (id.startsWith('#')) {
                e.preventDefault();
                showSection(id);
                window.location.hash = id;
            }
        });
    });

    if (window.location.hash) showSection(window.location.hash);

    // Logic untuk fitur mata (Toggle Password Visibility) - VERSI FIX
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            // Mencari wrapper terdekat lalu mencari input di dalamnya
            const wrapper = this.closest('.password-wrapper');
            const input = wrapper.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });

    // --- 3. AUTOCOMPLETE PENCARIAN (FORMAL UI) ---
    const searchInput = document.getElementById('search-anggota');
    const searchResults = document.getElementById('search-results');
    const targetUserId = document.getElementById('form_target_user_id'); // Corrected reference
    const selectedMemberInfo = document.getElementById('selectedMemberInfo');
    const infoNama = document.getElementById('info_nama');
    const infoNo = document.getElementById('info_no');
    const clearBtn = document.getElementById('clearMemberSelection');
    const searchContainer = document.getElementById('memberSearchContainer');

    let debounceTimer;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const keyword = this.value;

            if (keyword.length < 2) {
                searchResults.innerHTML = '';
                searchResults.classList.add('d-none');
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`<?= url('/api/anggota/search') ?>?q=${keyword}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if (data.length > 0) {
                            searchResults.classList.remove('d-none');
                            searchResults.style.display = 'block'; // Force block
                            data.forEach(item => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'list-group-item list-group-item-action border-0 py-3 d-flex justify-content-between align-items-center suggestion-item';
                                btn.style.borderLeft = "4px solid transparent";
                                btn.innerHTML = `
                                    <div class="pe-3">
                                        <div class="fw-bold text-dark" style="font-size: 15px;">${item.nama}</div>
                                        <div class="text-muted small">${item.no_anggota}</div>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted small"></i>
                                `;

                                btn.addEventListener('mouseenter', () => btn.style.borderLeftColor = "#0d6efd");
                                btn.addEventListener('mouseleave', () => btn.style.borderLeftColor = "transparent");

                                btn.addEventListener('click', function() {
                                    selectMember(item);
                                });
                                searchResults.appendChild(btn);
                            });
                        } else {
                            searchResults.innerHTML = '<div class="list-group-item disabled text-center py-4 text-muted small">Anggota tidak ditemukan</div>';
                            searchResults.classList.remove('d-none');
                            searchResults.style.display = 'block';
                        }
                    });
            }, 300);
        });

        function selectMember(item) {
            targetUserId.value = item.anggota_id;
            infoNama.textContent = item.nama;
            infoNo.textContent = item.no_anggota;
            
            // Hide search, show info
            searchContainer.classList.add('d-none');
            selectedMemberInfo.classList.remove('d-none');
            searchResults.innerHTML = '';
            searchResults.classList.add('d-none');
            searchInput.value = '';

            // Fetch current savings config
            fetch(`<?= url('/api/settings/savings') ?>?user_id=${item.anggota_id}`)
                .then(response => response.json())
                .then(config => {
                    document.getElementsByName('simpanan_motor')[0].value = config.simpanan_motor;
                    document.getElementsByName('simpanan_mobil')[0].value = config.simpanan_mobil;
                });
        }

        if (clearBtn) {
            clearBtn.onclick = () => {
                targetUserId.value = '';
                searchContainer.classList.remove('d-none');
                selectedMemberInfo.classList.add('d-none');
                searchInput.focus();
            };
        }
    }

    document.addEventListener('click', function(e) {
        if (searchInput && !searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('d-none');
        }
    });
});
</script>

<?php if (isset($_SESSION['savings_update_success'])): ?>
    <?php 
        $successData = $_SESSION['savings_update_success']; 
        unset($_SESSION['savings_update_success']); 
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide standard alert if it matches our success message
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(alert => {
                if (alert.textContent.includes('Konfigurasi simpanan berhasil!')) {
                    alert.style.display = 'none';
                }
            });

            let message = "";
            let motor = <?= (int)$successData['motor'] ?>;
            let mobil = <?= (int)$successData['mobil'] ?>;
            let nama = "<?= e($successData['nama']) ?>";
            
            if (motor > 0 && mobil > 0) {
                message = `Simpanan motor dan mobil ke <b>${nama}</b> telah berhasil sebesar <b>Rp ${new Intl.NumberFormat('id-ID').format(motor + mobil)}</b>`;
            } else if (motor > 0) {
                message = `Simpanan motor ke <b>${nama}</b> telah berhasil sebesar <b>Rp ${new Intl.NumberFormat('id-ID').format(motor)}</b>`;
            } else if (mobil > 0) {
                message = `Simpanan mobil ke <b>${nama}</b> telah berhasil sebesar <b>Rp ${new Intl.NumberFormat('id-ID').format(mobil)}</b>`;
            } else {
                message = `Konfigurasi simpanan untuk <b>${nama}</b> telah berhasil diperbarui.`;
            }

            Swal.fire({
                title: '<span class="text-success">Update Berhasil!</span>',
                html: `<div class="py-3">${message}</div>`,
                icon: 'success',
                confirmButtonText: 'Oke',
                confirmButtonColor: '#0d6efd',
                buttonsStyling: true,
                customClass: {
                    popup: 'rounded-4 border-0 shadow-lg',
                    confirmButton: 'px-5 py-2 rounded-pill fw-bold'
                }
            });
        });
    </script>
<?php endif; ?>

<style>
    /* Hilangkan Ikon Bawaan Browser */
    input::-ms-reveal, input::-ms-clear, input::-webkit-reveal {
        display: none;
    }

    .list-group-settings .list-group-item {
        padding: 1.1rem 1.25rem;
        border: 1px solid #f1f1f1;
        margin-bottom: 8px;
        border-radius: 12px !important;
        transition: all 0.25s ease;
    }
    .list-group-settings .list-group-item:hover:not(.active) {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
    .list-group-settings .list-group-item.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .icon-wrapper {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        background: #f0f7ff; border-radius: 10px;
        color: #0d6efd; flex-shrink: 0;
    }
    .list-group-item.active .icon-wrapper { background: rgba(255, 255, 255, 0.2); color: #fff; }

/* 1. WAJIB: Matikan mata bawaan Edge/Chrome agar tidak ada 2 ikon */
    input::-ms-reveal, 
    input::-ms-clear, 
    input::-webkit-reveal {
        display: none !important;
    }

    /* 2. Perbaikan Posisi Wrapper */
    .password-wrapper { 
        position: relative; 
        display: flex; 
        align-items: center; 
    }

    /* Beri ruang di kanan agar teks tidak menutupi ikon */
    .password-wrapper .form-control {
        padding-right: 45px !important;
    }

    /* 3. Perbaikan Ikon Kustom */
    .password-toggle { 
        position: absolute; 
        right: 12px; 
        top: 50%; 
        transform: translateY(-50%); 
        cursor: pointer !important; 
        color: #6c757d; 
        padding: 5px; 
        z-index: 999; /* Paksa berada di paling depan */
        display: flex;
        align-items: center;
        background: transparent;
        border: none;
    }

    .password-toggle:hover { color: #0d6efd; }

    /* CSS lainnya tetap sama */
    .list-group-settings .list-group-item { padding: 1.1rem 1.25rem; border: 1px solid #f1f1f1; margin-bottom: 8px; border-radius: 12px !important; transition: all 0.25s ease; }
    .list-group-settings .list-group-item.active { background-color: #0d6efd; border-color: #0d6efd; }
    .icon-wrapper { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: #f0f7ff; border-radius: 10px; color: #0d6efd; flex-shrink: 0; }
    .settings-section { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>