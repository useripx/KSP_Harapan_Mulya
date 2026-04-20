<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold">Ganti Password</h5>
                    <p class="text-muted small mb-0">Ubah password akun Anda untuk keamanan lebih baik.</p>
                </div>
                <div class="card-body p-4">
                    <?php View::flash(); ?>

                    <form action="<?= url('/profile/password/update') ?>" method="POST">
                        <?= View::csrf() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Masukkan password sekarang" required>
                            <?php if ($error = View::error('old_password')): ?>
                                <div class="text-danger small mt-1"><?= $error ?></div>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Minimal 6 karakter" required>
                            <?php if ($error = View::error('new_password')): ?>
                                <div class="text-danger small mt-1"><?= $error ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password baru" required>
                            <?php if ($error = View::error('confirm_password')): ?>
                                <div class="text-danger small mt-1"><?= $error ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-3 bg-light rounded border">
                <div class="d-flex gap-3">
                    <div class="text-primary" style="font-size: 24px;">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Tips Keamanan</h6>
                        <p class="text-muted small mb-0">
                            Gunakan kombinasi huruf, angka, dan simbol untuk password yang kuat. Jangan pernah membagikan password Anda kepada siapapun, termasuk staff KSP.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #0f172a;
    --border: #e2e8f0;
}

.form-label {
    font-size: 14px;
    font-weight: 500;
}

.form-control {
    border: 1px solid var(--border);
    padding: 10px 12px;
    font-size: 14px;
}

.form-control:focus {
    box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.1);
    border-color: var(--primary);
}

.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
    padding: 10px;
    font-weight: 500;
}

.btn-primary:hover {
    opacity: 0.9;
    background-color: #1e293b;
}

.card {
    border-radius: 12px;
}
</style>
