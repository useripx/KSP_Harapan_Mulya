<div class="mb-4">
    <a href="<?= url('/anggota') ?>" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <div class="d-flex justify-content-between align-items-center mt-2">
        <h2 class="page-title mb-0">
            <?= $pageTitle ?>
        </h2>
        <div>
            <a href="<?= url('/anggota/' . $anggota['id'] . '/edit') ?>" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil me-1"></i> Edit Data
            </a>
            <form action="<?= url('/anggota/' . $anggota['id'] . '/delete') ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus anggota ini?')">
                <?= View::csrf() ?>
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Informasi Profil</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">No. Anggota</label>
                        <span class="h6"><?= e($anggota['no_anggota']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Status Keanggotaan</label>
                        <?= getStatusBadge($anggota['status'], 'anggota') ?>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Nama Lengkap</label>
                        <span class="h5"><?= e($anggota['nama']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Tipe Anggota</label>
                        <span class="badge bg-info-soft text-info border"><?= e($anggota['tipe']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Tanggal Terdaftar</label>
                        <span><?= date('d F Y', strtotime($anggota['tgl_daftar'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Kontak & Identitas</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">No. Identitas</label>
                        <span><?= e($anggota['identitas_no'] ?: '-') ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">No. HP / WhatsApp</label>
                        <span><?= e($anggota['no_hp'] ?: '-') ?></span>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Prodi / Unit Kerja</label>
                        <span><?= e($anggota['prodi_unit'] ?: '-') ?></span>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Alamat Lengkap</label>
                        <p class="mb-0"><?= nl2br(e($anggota['alamat'] ?: '-')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body py-4 text-center">
                <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-person h1 mb-0"></i>
                </div>
                <h5 class="mb-1"><?= e($anggota['nama']) ?></h5>
                <p class="opacity-75 small mb-0"><?= e($anggota['no_anggota']) ?></p>
            </div>
        </div>
        
        <!-- Placeholder untuk statistik ringkas (simpanan/pinjaman) jika diperlukan nanti -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="card-title text-muted mb-3">Ringkasan Keuangan</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Total Simpanan</span>
                    <span class="fw-bold">Rp <?= formatRupiah($saldo ?? 0) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-0">
                    <span class="small text-muted">Total Pinjaman</span>
                    <span class="fw-bold text-danger">Rp <?= formatRupiah($totalPinjaman ?? 0) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
