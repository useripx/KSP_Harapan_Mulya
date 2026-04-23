<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Tarik Simpanan</h2>
        <p class="text-muted small mb-0">Proses penarikan dana dari saldo simpanan anggota.</p>
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
                <h5 class="card-title">Form Penarikan</h5>
                <p class="card-description">Masukkan jumlah penarikan dari saldo anggota.</p>
            </div>
            <div class="card-body">
                <form action="<?= url('/simpanan/tarik/process') ?>" method="POST">
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
                        <label class="form-label">Jumlah Penarikan (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="0" min="1000" required>
                        <div class="text-muted small mt-1">Pastikan saldo mencukupi.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2"
                            placeholder="Contoh: Keperluan mendadak"></textarea>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="<?= url('/simpanan') ?>" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">Konfirmasi Penarikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>