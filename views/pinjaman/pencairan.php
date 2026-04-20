<div class="mb-4">
    <a href="<?= url('/pinjaman/' . $pinjaman['id']) ?>" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
    </a>
    <h2 class="page-title mt-2">Pencairan Dana #<?= $pinjaman['id'] ?></h2>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Konfirmasi Pencairan</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success border-0 small mb-4">
                    <i class="bi bi-check-circle-fill me-2 fs-6"></i>
                    Pinjaman ini telah disetujui oleh Ketua dan siap untuk dicairkan ke anggota.
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Hasil Persetujuan</h6>
                    <div class="small mb-2">
                        <span class="text-muted">Diverifikasi:</span> <?= e($pinjaman['verifikasi_oleh_nama']) ?> 
                        <span class="text-muted ms-2">Disetujui:</span> <?= e($pinjaman['approve_oleh_nama']) ?>
                    </div>
                    <?php if ($pinjaman['catatan_approve']): ?>
                        <div class="p-2 bg-light border rounded italic smaller"><?= e($pinjaman['catatan_approve']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Detail Transaksi</h6>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Jumlah Pokok (Cair)</div>
                        <div class="col-6 text-end fw-bold"><?= formatRupiah($pinjaman['pokok']) ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Total Bunga (<?= $pinjaman['tenor_bulan'] ?> bln)</div>
                        <div class="col-6 text-end text-danger"><?= formatRupiah($preview['bunga_total']) ?></div>
                    </div>
                    <div class="row pt-2 border-top">
                        <div class="col-6 fw-bold">Total Pengembalian</div>
                        <div class="col-6 text-end fw-bold fs-5 text-primary"><?= formatRupiah($preview['total_tagihan']) ?></div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Estimasi Angsuran</h6>
                    <div class="p-3 bg-light rounded d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Tagihan per Bulan</div>
                            <div class="fw-bold fs-4"><?= formatRupiah($preview['angsuran_per_bulan']) ?></div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Mulai Bulan Depan</div>
                            <div class="fw-medium"><?= date('M Y', strtotime('+1 month')) ?></div>
                        </div>
                    </div>
                </div>

                <form action="<?= url('/pinjaman/' . $pinjaman['id'] . '/cairkan') ?>" method="POST" onsubmit="return confirm('Konfirmasi pencairan dana sekarang? Jadwal angsuran akan otomatis dibuat.')">
                    <?= View::csrf() ?>
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow">
                        <i class="bi bi-cash-stack me-2"></i> PROSES PENCAIRAN SEKARANG
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card mb-4 border-info">
            <div class="card-header bg-info-subtle border-info">
                <h5 class="card-title mb-0">Informasi Penerima</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar-circle <?= getAvatarColor($pinjaman['nama']) ?> me-3 lg">
                        <?= getInitials($pinjaman['nama']) ?>
                    </div>
                    <div>
                        <div class="fw-bold fs-5"><?= e($pinjaman['nama']) ?></div>
                        <div class="text-muted"><?= e($pinjaman['no_anggota']) ?></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="text-muted small d-block">Identitas</label>
                    <div class="fw-medium"><?= e($pinjaman['identitas_no'] ?: '-') ?> (<?= e($pinjaman['anggota_tipe']) ?>)</div>
                </div>
                
                <div class="mb-0">
                    <label class="text-muted small d-block">Kontak</label>
                    <div class="fw-medium"><?= e($pinjaman['no_hp'] ?: '-') ?></div>
                </div>
            </div>
        </div>

        <div class="card bg-warning-subtle border-warning">
            <div class="card-body small">
                <h6 class="fw-bold"><i class="bi bi-info-circle me-1"></i> Penting:</h6>
                <ul class="mb-0 ps-3">
                    <li>Pencairan akan mencatat transaksi <strong>KAS KELUAR</strong> secara otomatis.</li>
                    <li>Sistem akan membuat sebanyak <strong><?= $pinjaman['tenor_bulan'] ?></strong> baris jadwal angsuran baru.</li>
                    <li>Pastikan saldo fisik kas mencukupi sebelum menekan tombol pencairan.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
