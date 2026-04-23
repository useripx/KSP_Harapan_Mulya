<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/users') ?>">Manajemen User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>
        <h2 class="page-title mb-0">Edit User: <?= htmlspecialchars($user['name']) ?></h2>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="<?= url("/users/{$user['id']}/update") ?>" method="POST">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="name"
                                    class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                    value="<?= $old['name'] ?? $user['name'] ?>" placeholder="Masukkan nama lengkap">
                                <?php if (isset($errors['name'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Username</label>
                                <input type="text" name="username"
                                    class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                                    value="<?= $old['username'] ?? $user['username'] ?>"
                                    placeholder="Masukkan username">
                                <?php if (isset($errors['username'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['username'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email"
                                    class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                    value="<?= $old['email'] ?? $user['email'] ?>" placeholder="nama@perusahaan.com">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Aksi Sandi</label>
                                <div>
                                    <button type="button" class="btn btn-warning w-100 fw-bold" onclick="showResetConfirm()">
                                        <i class="bi bi-arrow-counterclockwise"></i> Reset Sandi
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Role</label>
                                <select name="role"
                                    class="form-select <?= isset($errors['role']) ? 'is-invalid' : '' ?>">
                                    <option value="">Pilih Role</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role ?>" <?= (isset($old['role']) ? $old['role'] === $role : $user['role'] === $role) ? 'selected' : '' ?>>
                                            <?= $role ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['role'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['role'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-12">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                        <?= ($user['is_active']) ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="isActive">User Aktif</label>
                                    <p class="text-muted small">Jika dinonaktifkan, user tidak dapat login ke sistem.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?= url('/users') ?>" class="btn btn-light px-4">Batal</a>
                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-2 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Informasi Akun</h5>
                    <div class="mb-2 small">
                        <span class="text-muted">ID:</span> #
                        <?= $user['id'] ?>
                    </div>
                    <div class="mb-2 small">
                        <span class="text-muted">Dibuat pada:</span>
                        <?= date('d M Y, H:i', strtotime($user['created_at'])) ?>
                    </div>
                    <div class="small">
                        <span class="text-muted">Login terakhir:</span>
                        <?= $user['last_login_at'] ? date('d M Y, H:i', strtotime($user['last_login_at'])) : 'Belum pernah' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modals -->
<div class="modal fade" id="confirmResetModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Konfirmasi Reset Sandi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda Yakin ingin mereset sandi untuk <strong><?= e($user['name']) ?></strong>?</p>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary" onclick="executeReset()">Ya</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="successResetModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
        <h5 class="mt-3 fw-bold">Reset Berhasil</h5>
        <p class="mb-4">Sandi untuk Anggota <strong><?= e($user['name']) ?></strong> telah direset ke Default ID Anggota</p>
        <button type="button" class="btn btn-primary w-100" onclick="window.location.href='<?= url('/validator') ?>'">Oke</button>
      </div>
    </div>
  </div>
</div>

<script>
let confirmModal;
let successModal;

document.addEventListener('DOMContentLoaded', function() {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmResetModal'));
    successModal = new bootstrap.Modal(document.getElementById('successResetModal'));
});

function showResetConfirm() {
    confirmModal.show();
}

function executeReset() {
    confirmModal.hide();
    
    fetch('<?= url("/users/{$user['id']}/reset-password") ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            successModal.show();
        } else {
            alert('Gagal: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses permintaan.');
    });
}
</script>