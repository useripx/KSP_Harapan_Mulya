<?php 
/**
 * View: Edit User & Anggota
 */
?>
<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/users') ?>" class="text-decoration-none">Manajemen User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Anggota</li>
            </ol>
        </nav>
        <h2 class="page-title mb-0">Edit Anggota: <?= e($anggota['nama'] ?? $user['name']) ?></h2>
        <p class="text-muted small mb-0">Perbarui data informasi dan akun login anggota koperasi.</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/users') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= url('/users/update/' . $user['id']) ?>" method="POST">
    <?= View::csrf() ?>
    <div class="row">
        <!-- Kolom Kiri: Informasi Pribadi -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">Informasi Pribadi & Instansi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">No. Anggota</label>
                            <input type="text" class="form-control bg-light" value="<?= e($anggota['no_anggota'] ?? '-') ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Tanggal Daftar</label>
                            <input type="date" name="tgl_daftar" class="form-control" value="<?= date('Y-m-d', strtotime($anggota['tgl_daftar'] ?? 'now')) ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Nama Lengkap (Sesuai Identitas)</label>
                            <input type="text" name="name" class="form-control" value="<?= e($anggota['nama'] ?? $user['name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Tipe Anggota</label>
                            <select name="tipe" class="form-select" required>
                                <?php 
                                $tipe_list = ['DOSEN TETAP', 'DOSEN KONTRAK', 'DOSEN TIDAK TETAP', 'KARYAWAN TETAP', 'KARYAWAN KONTRAK', 'KARYAWAN TIDAK TETAP'];
                                foreach($tipe_list as $t): ?>
                                    <option value="<?= $t ?>" <?= ($anggota['tipe'] ?? '') == $t ? 'selected' : '' ?>><?= $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Status Keanggotaan</label>
                            <select name="status_keanggotaan" class="form-select" required>
                                <?php $st = $anggota['status'] ?? 'AKTIF'; ?>
                                <option value="AKTIF" <?= $st == 'AKTIF' ? 'selected' : '' ?>>AKTIF</option>
                                <option value="NONAKTIF" <?= $st == 'NONAKTIF' ? 'selected' : '' ?>>NONAKTIF</option>
                                <option value="KELUAR" <?= $st == 'KELUAR' ? 'selected' : '' ?>>KELUAR</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">No. Identitas (KTP/NIP)</label>
                            <input type="text" name="identitas_no" class="form-control" value="<?= e($anggota['identitas_no'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" value="<?= e($anggota['no_hp'] ?? '') ?>">
                        </div>
                        <input type="hidden" name="prodi_unit" value="<?= e($anggota['prodi_unit'] ?? '') ?>">
                        <input type="hidden" name="alamat" value="<?= e($anggota['alamat'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Akun Login & Aksi -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">Akun Login</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= e($user['username']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= e($user['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Role Akses</label>
                        <select name="role" class="form-select">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role ?>" <?= ($user['role'] === $role) ? 'selected' : '' ?>><?= $role ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-warning w-100 fw-bold shadow-sm mt-2" onclick="showResetConfirm()">
                        <i class="bi bi-shield-lock-fill me-1"></i> Reset Password
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow-sm border-start border-primary border-4 mb-4">
                <div class="card-body p-3">
                    <h6 class="fw-bold small mb-3">Statistik Akun</h6>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">ID Sistem:</span>
                        <span class="fw-semibold">#<?= $user['id'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Terdaftar:</span>
                        <span><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary shadow py-2 fw-bold">Simpan Perubahan</button>
                <a href="<?= url('/users') ?>" class="btn btn-light border">Batal</a>
            </div>
        </div>
    </div>
</form>

<!-- Reset Password Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showResetConfirm() {
    const userName = "<?= e($anggota['nama'] ?? $user['name']) ?>";
    const userId = "<?= $user['id'] ?>";
    const noAnggota = "<?= e($anggota['no_anggota'] ?? '-') ?>";

    Swal.fire({
        title: 'Konfirmasi Reset Password',
        html: `Apakah anda yakin ingin akan mereset password <br><strong>${userName}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Tidak',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Memproses...',
                didOpen: () => { Swal.showLoading() },
                allowOutsideClick: false
            });

            fetch(`<?= url('/users/') ?>${userId}/reset-password`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `csrf_token=<?= View::getCsrfToken() ?>`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Reset Berhasil!',
                        html: `Beritahu <strong>${userName}</strong> terkait bahwa reset password telah dilakukan. silahkan lakukan pergantian password mandiri oleh user atau datang ke KSP untuk panduan lebih lanjut.`,
                        icon: 'success',
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#2563eb'
                    }).then(() => {
                        window.location.href = '<?= url('/users') ?>';
                    });
                } else {
                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
            });
        }
    });
}
</script>