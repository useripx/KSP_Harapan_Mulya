<div class="mb-4">
    <a href="<?= url('/anggota') ?>" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h2 class="page-title mt-2">
        <?= $pageTitle ?>
    </h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Informasi Anggota</h5>
                <p class="card-description">Perbarui data lengkap anggota <strong><?= e($anggota['no_anggota']) ?></strong>.</p>
            </div>
            <div class="card-body">
                <form action="<?= url('/anggota/' . $anggota['id'] . '/update') ?>" method="POST">
                    <?= View::csrf() ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">No. Anggota</label>
                            <input type="text" name="no_anggota" class="form-control" value="<?= e($anggota['no_anggota']) ?>"
                                readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Daftar</label>
                            <input type="date" name="tgl_daftar" class="form-control" value="<?= date('Y-m-d', strtotime($anggota['tgl_daftar'])) ?>"
                                required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= e($anggota['nama']) ?>"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipe Anggota</label>
                            <select name="tipe" class="form-select" required>
                                <option value="UMUM" <?= $anggota['tipe'] == 'UMUM' ? 'selected' : '' ?>>UMUM</option>
                                <option value="MAHASISWA" <?= $anggota['tipe'] == 'MAHASISWA' ? 'selected' : '' ?>>MAHASISWA</option>
                                <option value="DOSEN" <?= $anggota['tipe'] == 'DOSEN' ? 'selected' : '' ?>>DOSEN</option>
                                <option value="STAF" <?= $anggota['tipe'] == 'STAF' ? 'selected' : '' ?>>STAF</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="AKTIF" <?= $anggota['status'] == 'AKTIF' ? 'selected' : '' ?>>AKTIF</option>
                                <option value="NON-AKTIF" <?= $anggota['status'] == 'NON-AKTIF' ? 'selected' : '' ?>>NON-AKTIF</option>
                                <option value="KELUAR" <?= $anggota['status'] == 'KELUAR' ? 'selected' : '' ?>>KELUAR</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Identitas (KTP/NIM/NIP)</label>
                            <input type="text" name="identitas_no" class="form-control" value="<?= e($anggota['identitas_no']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" value="<?= e($anggota['no_hp']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prodi / Unit</label>
                            <input type="text" name="prodi_unit" class="form-control" value="<?= e($anggota['prodi_unit']) ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3"><?= e($anggota['alamat']) ?></textarea>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="<?= url('/anggota') ?>" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
