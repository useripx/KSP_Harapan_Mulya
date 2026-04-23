<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Bayar Angsuran #<?= $schedule['angsuran_ke'] ?></h2>
        <p class="text-muted small mb-0">Proses pembayaran angsuran pinjaman anggota.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Rincian Tagihan</h5>
            </div>
            <div class="card-body">
                <div class="mb-4 text-center">
                    <div class="text-muted small mb-1">Total yang harus dibayar</div>
                    <div class="fw-bold fs-2 text-primary"><?= formatRupiah($schedule['total_tagih']) ?></div>
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Pokok</span>
                        <span class="fw-medium"><?= formatRupiah($schedule['pokok_tagih']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Bunga</span>
                        <span class="fw-medium"><?= formatRupiah($schedule['bunga_tagih']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Denda</span>
                        <span class="fw-medium text-success"><?= formatRupiah(0) ?></span>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-light rounded">
                    <div class="small fw-bold mb-1">Anggota:</div>
                    <div class="fw-medium"><?= e($schedule['anggota_nama']) ?></div>
                    <div class="text-muted smaller">No. Anggota: <?= e($schedule['no_anggota']) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-white">
                <h5 class="card-title">Konfirmasi Pembayaran</h5>
            </div>
            <div class="card-body">
                <form action="<?= url('/angsuran/proses') ?>" method="POST" id="formBayar">
                    <?= View::csrf() ?>
                    <input type="hidden" name="schedule_id" value="<?= $schedule['id'] ?>">

                    <div class="mb-4">
                        <label class="form-label fw-bold">Metode Pembayaran</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="metode_bayar" id="metode_tunai" value="TUNAI" checked>
                                <label class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center" for="metode_tunai">
                                    <i class="bi bi-cash fs-3 mb-1"></i>
                                    TUNAI
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="metode_bayar" id="metode_tf" value="TRANSFER">
                                <label class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center" for="metode_tf">
                                    <i class="bi bi-bank fs-3 mb-1"></i>
                                    TRANSFER
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 small mb-4">
                        <i class="bi bi-info-circle-fill me-2 italic"></i>
                        Status angsuran akan otomatis berubah menjadi LUNAS. Jika ini adalah angsuran terakhir, status pinjaman juga akan berubah menjadi LUNAS.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg fw-bold py-3 shadow">
                            PROSES PEMBAYARAN SEKARANG
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
