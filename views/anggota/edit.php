<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0"><?= $pageTitle ?></h2>
        <p class="text-muted small mb-0">Perbarui data informasi anggota koperasi.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
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
                                <option value="DOSEN TETAP" <?= $anggota['tipe'] == 'DOSEN TETAP' ? 'selected' : '' ?>>DOSEN TETAP</option>
                                <option value="DOSEN KONTRAK" <?= $anggota['tipe'] == 'DOSEN KONTRAK' ? 'selected' : '' ?>>DOSEN KONTRAK</option>
                                <option value="DOSEN TIDAK TETAP" <?= $anggota['tipe'] == 'DOSEN TIDAK TETAP' ? 'selected' : '' ?>>DOSEN TIDAK TETAP</option>
                                <option value="KARYAWAN TETAP" <?= $anggota['tipe'] == 'KARYAWAN TETAP' ? 'selected' : '' ?>>KARYAWAN TETAP</option>
                                <option value="KARYAWAN KONTRAK" <?= $anggota['tipe'] == 'KARYAWAN KONTRAK' ? 'selected' : '' ?>>KARYAWAN KONTRAK</option>
                                <option value="KARYAWAN TIDAK TETAP" <?= $anggota['tipe'] == 'KARYAWAN TIDAK TETAP' ? 'selected' : '' ?>>KARYAWAN TIDAK TETAP</option>
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
