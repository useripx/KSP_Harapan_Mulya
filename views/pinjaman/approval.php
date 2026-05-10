<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Persetujuan Pinjaman #<?= $pinjaman['id'] ?></h2>
        <p class="text-muted small mb-0">Tentukan keputusan persetujuan pengajuan pinjaman.</p>
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
                <h5 class="card-title">Data Pengajuan & Verifikasi</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="text-muted small d-block">Anggota</label>
                    <div class="fw-bold"><?= e($pinjaman['nama']) ?> (<?= e($pinjaman['no_anggota']) ?>)</div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="text-muted small d-block">Pokok Pinjaman</label>
                        <div class="fw-bold text-primary fs-5"><?= formatRupiah($pinjaman['pokok']) ?></div>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small d-block">Tenor</label>
                        <div class="fw-medium"><?= $pinjaman['tenor_bulan'] ?> Bulan</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small d-block">Hasil Verifikasi Petugas</label>
                    <div class="p-3 bg-light rounded mt-1">
                        <div class="small text-muted mb-2">
                            Oleh: <?= e($pinjaman['verifikasi_oleh_nama'] ?? 'Petugas') ?> pada
                            <?= formatTanggal($pinjaman['tgl_verifikasi']) ?>
                        </div>
                        <div class="fw-medium italic text-dark">
                            <?= nl2br(e($pinjaman['catatan_verifikasi'] ?: 'Tidak ada catatan khusus.')) ?>
                        </div>
                    </div>
                </div>

                <div class="mb-0">
                    <label class="text-muted small d-block">Tujuan Pinjaman</label>
                    <div class="small"><?= e($pinjaman['tujuan'] ?: '-') ?></div>
                </div>
            </div>
        </div>

        <!-- AI Analytic Widget -->
        <div class="card mb-4 border-<?= $creditScore['color'] ?>">
            <div
                class="card-header bg-<?= $creditScore['color'] ?> text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-robot me-2"></i>Ringkasan Penilaian Anggota</h5>
                <span class="badge bg-white text-<?= $creditScore['color'] ?> fs-6"><?= $creditScore['score'] ?>
                    Poin</span>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <h4 class="text-<?= $creditScore['color'] ?> fw-bold mb-1"><?= $creditScore['kategori'] ?></h4>
                    <span class="text-muted small">Berdasarkan riwayat pembayaran & kekuatan simpanan anggota</span>
                </div>
                <ul class="list-group list-group-flush mb-0 small">
                    <?php foreach ($creditScore['reasons'] as $reason): ?>
                        <li class="list-group-item d-flex align-items-start px-0 border-0 py-1">
                            <i class="bi bi-circle-fill text-<?= $reason['type'] ?> mt-1 me-2"
                                style="font-size: 0.6rem;"></i>
                            <span><?= $reason['text'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-lg">
            <div class="card-header bg-white">
                <h5 class="card-title">Keputusan Ketua</h5>
            </div>
            <div class="card-body">
                <form action="<?= url('/pinjaman/' . $pinjaman['id'] . '/approve') ?>" method="POST" id="formApproval">
                    <?= View::csrf() ?>

                    <div class="mb-4">
                        <label class="form-label">Catatan / Pesan Ketua</label>
                        <textarea name="catatan" class="form-control" rows="4"
                            placeholder="Berikan alasan persetujuan atau penolakan..."></textarea>
                    </div>

                    <div class="row g-2">
                        <div class="col-8">
                            <button type="submit" class="btn btn-success fw-bold w-100 py-2">
                                <i class="bi bi-check-circle me-1"></i> SETUJUI PINJAMAN
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="submit" formaction="<?= url('/pinjaman/' . $pinjaman['id'] . '/reject') ?>"
                                class="btn btn-outline-danger w-100 py-2"
                                onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                                TOLAK
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-4 p-3 bg-success-subtle rounded border border-success-subtle small">
                    <p class="mb-0 text-success">
                        <strong>Informasi:</strong> Setelah disetujui, status pinjaman akan menjadi
                        <strong>DISETUJUI</strong> dan dapat langsung dicairkan oleh Validator untuk pembuatan jadwal
                        angsuran.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>