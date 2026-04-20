<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Pengaturan Akun</h5>
                    <p class="text-muted small">Kelola informasi profil dan pengaturan keamanan akun Anda dalam satu
                        tempat.</p>

                    <div class="list-group list-group-settings mt-4">
                        <a href="#security"
                            class="list-group-item list-group-item-action d-flex align-items-center active">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Keamanan</div>
                                <div class="small opacity-75">Ganti password & proteksi</div>
                            </div>
                        </a>
                        <a href="javascript:void(0)"
                            class="list-group-item list-group-item-action d-flex align-items-center disabled opacity-50">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-bell"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Notifikasi</div>
                                <div class="small opacity-75">Segera hadir</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Section Keamanan -->
            <div id="security" class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                            <i class="bi bi-key-fill"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Ganti Password</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <?php View::flash(); ?>

                    <form action="<?= url('/settings/password/update') ?>" method="POST">
                        <?= View::csrf() ?>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-4">
                                <label class="form-label mb-md-0">Password Saat Ini</label>
                            </div>
                            <div class="col-md-8">
                                <input type="password" name="old_password" class="form-control"
                                    placeholder="Masukkan password sekarang" required>
                                <?php if ($error = View::error('old_password')): ?>
                                    <div class="text-danger small mt-1"><?= $error ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr class="my-4" style="opacity: 0.05;">

                        <div class="row align-items-center mb-3">
                            <div class="col-md-4">
                                <label class="form-label mb-md-0">Password Baru</label>
                            </div>
                            <div class="col-md-8">
                                <input type="password" name="new_password" class="form-control"
                                    placeholder="Minimal 6 karakter" required>
                                <?php if ($error = View::error('new_password')): ?>
                                    <div class="text-danger small mt-1"><?= $error ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-4">
                                <label class="form-label mb-md-0">Konfirmasi Password Baru</label>
                            </div>
                            <div class="col-md-8">
                                <input type="password" name="confirm_password" class="form-control"
                                    placeholder="Ulangi password baru" required>
                                <?php if ($error = View::error('confirm_password')): ?>
                                    <div class="text-danger small mt-1"><?= $error ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-2">
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 bg-white rounded-4 shadow-sm border-0">
                <div class="d-flex gap-4">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px; min-width: 48px;">
                        <i class="bi bi-person-badge fs-4"></i>
                    </div>
                    <div class="w-100">
                        <h6 class="fw-bold mb-3">Informasi Akun</h6>
                        <div class="row border-bottom py-2 g-0">
                            <div class="col-sm-4 text-muted small">Username</div>
                            <div class="col-sm-8 small fw-semibold"><?= e($user['username'] ?? '-') ?></div>
                        </div>
                        <div class="row border-bottom py-2 g-0">
                            <div class="col-sm-4 text-muted small">Email</div>
                            <div class="col-sm-8 small fw-semibold"><?= e($user['email'] ?? '-') ?></div>
                        </div>
                        <div class="row py-2 g-0">
                            <div class="col-sm-4 text-muted small">Role / Jabatan</div>
                            <div class="col-sm-8">
                                <span
                                    class="badge rounded-pill bg-primary bg-opacity-10 text-primary border-primary border-opacity-10 py-2 px-3"><?= e(getRoleLabel(Auth::role())) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-settings {
        border-radius: var(--radius);
        overflow: hidden;
    }

    .list-group-settings .list-group-item {
        padding: 1rem 1.25rem;
        border: 1px solid transparent;
        margin-bottom: 4px;
        border-radius: var(--radius) !important;
        transition: all 0.2s ease;
        background-color: var(--card);
        color: var(--foreground);
    }

    .list-group-settings .list-group-item:hover:not(.active) {
        background-color: var(--secondary);
        color: var(--primary);
    }

    .list-group-settings .list-group-item.active {
        background-color: var(--primary);
        color: var(--primary-foreground);
        border-color: var(--primary);
    }

    .icon-wrapper {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--secondary);
        border-radius: 8px;
        font-size: 1.1rem;
        color: var(--primary);
    }

    .list-group-item.active .icon-wrapper {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    hr {
        border-color: var(--border);
        opacity: 0.1;
    }
</style>