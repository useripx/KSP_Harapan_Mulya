<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Setor Simpanan</h2>
        <p class="text-muted small mb-0">Proses penyetoran dana ke saldo simpanan anggota.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Setoran</h5>
                <p class="card-description">Pilih anggota dan masukkan jumlah setoran.</p>
            </div>
            <div class="card-body">
                <form action="<?= url('/simpanan/setor/process') ?>" method="POST">
                    <?= View::csrf() ?>

                    <div class="mb-3">
                        <label class="form-label">Pilih Anggota</label>
                        <select name="anggota_id" class="form-select" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php foreach ($anggota as $item): ?>
                                <option value="<?= $item['id'] ?>">
                                    <?= e($item['no_anggota']) ?> -
                                    <?= e($item['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Setoran (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="0" min="10000" required>
                        <div class="text-muted small mt-1">Minimal setoran Rp 10.000</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2"
                            placeholder="Contoh: Simpanan wajib bulan Januari"></textarea>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="<?= url('/simpanan') ?>" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">Konfirmasi Setoran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>