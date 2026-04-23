<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Verifikasi Pinjaman #<?= $pinjaman['id'] ?></h2>
        <p class="text-muted small mb-0">Tinjau kelayakan pengajuan pinjaman anggota.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Ringkasan Pengajuan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-5 text-muted small">Anggota</div>
                    <div class="col-7 fw-medium"><?= e($pinjaman['nama']) ?> (<?= e($pinjaman['no_anggota']) ?>)</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5 text-muted small">Tanggal Pengajuan</div>
                    <div class="col-7 fw-medium"><?= formatTanggalShort($pinjaman['tgl_pengajuan']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-5 text-muted small">Pokok Pinjaman</div>
                    <div class="col-7 fw-bold text-primary"><?= formatRupiah($pinjaman['pokok']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-5 text-muted small">Tenor</div>
                    <div class="col-7 fw-medium"><?= $pinjaman['tenor_bulan'] ?> Bulan</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5 text-muted small">Metode Bunga</div>
                    <div class="col-7 fw-medium"><?= e($pinjaman['metode']) ?></div>
                </div>
                <div class="row mb-0">
                    <div class="col-5 text-muted small">Tujuan</div>
                    <div class="col-7 small"><?= e($pinjaman['tujuan'] ?: '-') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Form Verifikasi Petugas</h5>
            </div>
            <div class="card-body">
                <form action="<?= url('/pinjaman/' . $pinjaman['id'] . '/verifikasi') ?>" method="POST">
                    <?= View::csrf() ?>
                    
                    <div class="alert alert-warning border-0 small mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Pastikan data identitas dan plafon pinjaman sudah sesuai dengan kapasitas anggota.
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Catatan Verifikasi</label>
                        <textarea name="catatan" class="form-control" rows="4" placeholder="Masukkan hasil pemeriksaan dokumen, jaminan, atau kapasitas bayar anggota..."></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold">Verifikasi & Teruskan ke Ketua</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
