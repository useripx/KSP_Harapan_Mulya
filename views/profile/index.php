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
                            <p class="fw-semibold mb-0">
                                <?= e($anggota['no_anggota']) ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Tanggal Daftar</label>
                            <p class="fw-semibold mb-0">
                                <?= formatTanggalShort($anggota['tgl_daftar']) ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Nama Lengkap</label>
                            <p class="fw-semibold mb-0">
                                <?= e($anggota['nama']) ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Tipe Anggota</label>
                            <p class="fw-semibold mb-0">
                                <?= e($anggota['tipe']) ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">No. Identitas (KTP/NIM/NIP)</label>
                            <p class="fw-semibold mb-0">
                                <?= e($anggota['identitas_no'] ?: '-') ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">No. HP / WhatsApp</label>
                            <p class="fw-semibold mb-0">
                                <?= e($anggota['no_hp'] ?: '-') ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Prodi / Unit</label>
                            <p class="fw-semibold mb-0">
                                <?= e($anggota['prodi_unit'] ?: '-') ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Alamat</label>
                            <p class="fw-semibold mb-0 text-wrap">
                                <?= e($anggota['alamat'] ?: '-') ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Username</label>
                            <p class="fw-semibold mb-0">
                                <?= e($user['username']) ?>
                            </p>
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
                            <p class="fw-semibold mb-0">
                                <?= e($user['email'] ?: '-') ?>
                            </p>
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
                    <a href="<?= url('/settings') ?>" class="btn btn-outline-primary shadow-sm">
                        <i class="bi bi-shield-lock me-2"></i> Pengaturan Keamanan
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