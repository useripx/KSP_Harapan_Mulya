<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0"><?= $pageTitle ?></h2>
        <p class="text-muted small mb-0">Informasi profil lengkap dan data keanggotaan.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/anggota/' . $anggota['id'] . '/edit') ?>" class="btn btn-warning btn-sm shadow-sm fw-semibold">
            <i class="bi bi-pencil me-1"></i> Edit Anggota
        </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Informasi Profil</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">No. Anggota</label>
                        <span class="h6 fw-bold text-primary"><?= e($anggota['no_anggota']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Status Keanggotaan</label>
                        <?= getStatusBadge($anggota['status'], 'anggota') ?>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Nama Lengkap</label>
                        <span class="h5 fw-semibold"><?= e($anggota['nama']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Tipe Anggota</label>
                        <span class="badge bg-info text-dark border"><?= e($anggota['tipe']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Tanggal Terdaftar</label>
                        <span><?= date('d F Y', strtotime($anggota['tgl_daftar'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Kontak & Identitas</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">No. Identitas (KTP)</label>
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
        <div class="card bg-primary text-white mb-4 shadow-sm border-0">
            <div class="card-body py-4 text-center">
                <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-person h1 mb-0"></i>
                </div>
                <h5 class="mb-1 text-white"><?= e($anggota['nama']) ?></h5>
                <p class="opacity-75 small mb-0"><?= e($anggota['no_anggota']) ?></p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="card-title text-muted mb-3">
                    <i class="bi bi-folder-fill me-2 text-warning"></i>Dokumen Kelengkapan
                </h6>
                <div class="list-group list-group-flush small">
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <div><i class="bi bi-card-heading me-2 text-secondary"></i> KTP Anggota</div>
                        <?php if (!empty($listDokumen['ktp'])): ?>
                            <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/ktp') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                <i class="bi bi-eye me-1"></i>Buka
                            </a>
                        <?php else: ?>
                            <span class="text-danger small italic">Belum diupload</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <div><i class="bi bi-file-earmark-text me-2 text-secondary"></i> Surat Perjanjian</div>
                        <?php if (!empty($listDokumen['perjanjian'])): ?>
                            <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/perjanjian') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                <i class="bi bi-eye me-1"></i>Buka
                            </a>
                        <?php else: ?>
                            <span class="text-danger small italic">Belum diupload</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <div><i class="bi bi-file-earmark-arrow-up me-2 text-secondary"></i> Form Pengajuan</div>
                        <?php if (!empty($listDokumen['pengajuan'])): ?>
                            <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/pengajuan') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                <i class="bi bi-eye me-1"></i>Buka
                            </a>
                        <?php else: ?>
                            <span class="text-danger small italic">Belum diupload</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
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
