<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/users') ?>">Manajemen User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah User Baru</li>
            </ol>
        </nav>
        <h2 class="page-title mb-0">Tambah User Baru</h2>
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
                    <form action="<?= url('/users/store') ?>" method="POST">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="name"
                                    class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                    value="<?= $old['name'] ?? '' ?>" placeholder="Masukkan nama lengkap">
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
                                    value="<?= $old['username'] ?? '' ?>" placeholder="Masukkan username">
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
                                    value="<?= $old['email'] ?? '' ?>" placeholder="nama@perusahaan.com">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Password</label>
                                <div class="password-wrapper">
                                    <input type="password" name="password"
                                        class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                        placeholder="Minimal 6 karakter">
                                    <div class="password-toggle">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                </div>
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback d-block">
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
                                        <option value="<?= $role ?>" <?= (isset($old['role']) && $old['role'] === $role) ? 'selected' : '' ?>>
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
                                        checked>
                                    <label class="form-check-label fw-bold" for="isActive">User Aktif</label>
                                    <p class="text-muted small">Jika dinonaktifkan, user tidak dapat login ke sistem.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?= url('/users') ?>" class="btn btn-light px-4">Batal</a>
                                    <button type="submit" class="btn btn-primary px-4">Simpan User</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white p-2">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3"><i class="bi bi-info-circle me-2"></i> Panduan Peran</h5>
                    <div class="mb-3">
                        <div class="fw-bold fs-6">ADMIN</div>
                        <p class="small text-white-50 mb-0">Akses penuh ke seluruh sistem, manajemen user, dan pengaturan sistem.</p>
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold fs-6">Manager</div>
                        <p class="small text-white-50 mb-0">Pengawas ringkasan data, dan memvalidasi anggota yang akan meminjam.</p>
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold fs-6">BAU</div>
                        <p class="small text-white-50 mb-0">Memiliki akses ke Ringkasan Data anggota saja dan mencetak ke PDF.</p>
                    </div>
                    <div>
                        <div class="fw-bold fs-6">ANGGOTA</div>
                        <p class="small text-white-50 mb-0">Akses personal untuk melihat saldo, riwayat transaksi, dan tagihan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>