<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/users') ?>">Manajemen User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-gray-800">Edit User:
                <?= htmlspecialchars($user['name']) ?>
            </h1>
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
                                <label class="form-label fw-bold">Password Baru (Opsional)</label>
                                <input type="password" name="password"
                                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                    placeholder="Kosongkan jika tidak diganti">
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['password'] ?>
                                    </div>
                                <?php endif; ?>
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