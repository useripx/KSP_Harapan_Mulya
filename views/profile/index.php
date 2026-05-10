<?php
$isAnggota = ($user['role'] === ROLE_ANGGOTA && $anggota);
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="user-avatar-large bg-primary text-white d-flex align-items-center justify-content-center fw-bold rounded-circle"
                        style="width: 80px; height: 80px; font-size: 32px;">
                        <?= getInitials($user['name']) ?>
                    </div>
                    <div class="ms-4">
                        <h2 class="h4 fw-bold mb-1">
                            <?= e($user['name']) ?>
                        </h2>
                        <p class="text-muted mb-0">
                            <?= e($user['email'] ?? 'Tidak ada email') ?>
                        </p>
                        <span class="badge bg-primary mt-2">
                            <?= getRoleLabel($user['role']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Informasi
                    <?= $isAnggota ? 'Keanggotaan' : 'Akun' ?>
                </h5>

                <div class="row g-4">
                    <?php if ($isAnggota): ?>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">No. Anggota</label>
                            <p class="fw-semibold mb-0"><?= e($anggota['no_anggota']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Tanggal Daftar</label>
                            <p class="fw-semibold mb-0"><?= formatTanggalShort($anggota['tgl_daftar']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Nama Lengkap</label>
                            <p class="fw-semibold mb-0"><?= e($anggota['nama']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Tipe Anggota</label>
                            <p class="fw-semibold mb-0"><?= e($anggota['tipe']) ?></p>
                        </div>
                        
                        <!-- INFO GAJI (Baru Ditambahkan) -->
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Gaji / Penghasilan</label>
                            <p class="fw-semibold mb-0 <?= empty($anggota['gaji']) ? 'text-danger' : 'text-success' ?>">
                                <?= empty($anggota['gaji']) ? '<i class="bi bi-exclamation-circle me-1"></i> Belum Diisi' : formatRupiah($anggota['gaji']) ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">No. HP / WhatsApp</label>
                            <p class="fw-semibold mb-0"><?= e($anggota['no_hp'] ?: '-') ?></p>
                        </div>
                        <div class="col-md-12">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Alamat Lengkap</label>
                            <p class="fw-semibold mb-0 text-wrap"><?= e($anggota['alamat'] ?: '-') ?></p>
                        </div>

                    <?php else: ?>
                        <!-- Info Akun Non-Anggota (Admin/Teller) -->
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Username</label>
                            <p class="fw-semibold mb-0"><?= e($user['username']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Status Akun</label>
                            <p class="mb-0">
                                <span class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $user['is_active'] ? 'AKTIF' : 'NON-AKTIF' ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Email</label>
                            <p class="fw-semibold mb-0"><?= e($user['email'] ?: '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Terakhir Login</label>
                            <p class="fw-semibold mb-0">
                                <?= $user['last_login_at'] ? formatDateTime($user['last_login_at']) : 'Belum pernah login' ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2 mt-5 pt-4 border-top">
                    <!-- Tombol Edit Data Anggota -->
                    <?php if ($isAnggota): ?>
                        <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#editProfilModal">
                            <i class="bi bi-pencil-square me-2"></i> Lengkapi Data & Gaji
                        </button>
                    <?php endif; ?>

                    <a href="<?= url('/settings') ?>" class="btn btn-outline-primary shadow-sm">
                        <i class="bi bi-shield-lock me-2"></i> Keamanan
                    </a>
                    
                    <?php if ($user['role'] === ROLE_ADMIN): ?>
                        <a href="<?= url('/users') ?>" class="btn btn-secondary shadow-sm">
                            <i class="bi bi-people me-2"></i> Kelola User
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL FORM EDIT PROFIL (POP-UP)            -->
<!-- ========================================== -->
<?php if ($isAnggota): ?>
<div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= url('/profile/update') ?>" method="POST">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="editProfilModalLabel"><i class="bi bi-person-lines-fill me-2"></i> Lengkapi Profil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <div class="alert alert-light border shadow-sm mb-4">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i> 
                        <small>Data gaji wajib diisi untuk keperluan verifikasi pengajuan pinjaman oleh Ketua Koperasi.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Gaji Bersih / Penghasilan per Bulan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" name="gaji" class="form-control" value="<?= $anggota['gaji'] ?? '' ?>" required placeholder="Contoh: 5000000">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">No. HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="no_hp" class="form-control" value="<?= e($anggota['no_hp'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= e($anggota['alamat'] ?? '') ?></textarea>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>