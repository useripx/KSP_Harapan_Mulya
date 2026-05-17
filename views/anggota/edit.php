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
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Edit Informasi Anggota</h5>
                <p class="card-description text-muted small mb-0">Perbarui data lengkap anggota <strong><?= e($anggota['no_anggota']) ?></strong>.</p>
            </div>
            <div class="card-body">
                <form action="<?= url('/anggota/' . $anggota['id'] . '/update') ?>" method="POST">
                    <?= View::csrf() ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">No. Anggota</label>
                            <input type="text" name="no_anggota" class="form-control" value="<?= e($anggota['no_anggota']) ?>" readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Daftar</label>
                            <input type="date" name="tgl_daftar" class="form-control" value="<?= date('Y-m-d', strtotime($anggota['tgl_daftar'])) ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= e($anggota['nama']) ?>" required>
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
                        <a href="<?= url('/anggota') ?>" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="card-title text-muted mb-3">
                    <i class="bi bi-folder-fill me-2 text-warning"></i>Dokumen Kelengkapan
                </h6>
                <div class="list-group list-group-flush small">
                    
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div><i class="bi bi-card-heading me-2 text-secondary"></i> KTP Anggota</div>
                            <?php if (!empty($listDokumen['ktp'])): ?>
                                <div class="d-flex gap-1">
                                    <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/ktp') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                        <i class="bi bi-eye me-1"></i>Buka
                                    </a>
                                    <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen KTP ini?')">
                                        <?= View::csrf() ?>
                                        <input type="hidden" name="jenis_dokumen" value="ktp">
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-pill">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="text-danger small italic">Belum diupload</span>
                            <?php endif; ?>
                        </div>
                        <?php if (empty($listDokumen['ktp'])): ?>
                            <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data" class="d-flex gap-1 mt-1">
                                <?= View::csrf() ?>
                                <input type="hidden" name="jenis_dokumen" value="ktp">
                                <input type="file" name="berkas_dokumen" class="form-control form-control-sm" accept="image/*,application/pdf" required>
                                <button type="submit" class="btn btn-sm btn-primary py-0 px-2"><i class="bi bi-upload"></i></button>
                            </form>
                        <?php endif; ?>
                    </div>
                    
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div><i class="bi bi-file-earmark-text me-2 text-secondary"></i> Surat Perjanjian</div>
                            <?php if (!empty($listDokumen['perjanjian'])): ?>
                                <div class="d-flex gap-1">
                                    <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/perjanjian') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                        <i class="bi bi-eye me-1"></i>Buka
                                    </a>
                                    <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Surat Perjanjian ini?')">
                                        <?= View::csrf() ?>
                                        <input type="hidden" name="jenis_dokumen" value="perjanjian">
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-pill">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="text-danger small italic">Belum diupload</span>
                            <?php endif; ?>
                        </div>
                        <?php if (empty($listDokumen['perjanjian'])): ?>
                            <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data" class="d-flex gap-1 mt-1">
                                <?= View::csrf() ?>
                                <input type="hidden" name="jenis_dokumen" value="perjanjian">
                                <input type="file" name="berkas_dokumen" class="form-control form-control-sm" accept="image/*,application/pdf" required>
                                <button type="submit" class="btn btn-sm btn-primary py-0 px-2"><i class="bi bi-upload"></i></button>
                            </form>
                        <?php endif; ?>
                    </div>
                    
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div><i class="bi bi-file-earmark-arrow-up me-2 text-secondary"></i> Form Pengajuan</div>
                            <?php if (!empty($listDokumen['pengajuan'])): ?>
                                <div class="d-flex gap-1">
                                    <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/pengajuan') ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                        <i class="bi bi-eye me-1"></i>Buka
                                    </a>
                                    <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Form Pengajuan ini?')">
                                        <?= View::csrf() ?>
                                        <input type="hidden" name="jenis_dokumen" value="pengajuan">
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-pill">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="text-danger small italic">Belum diupload</span>
                            <?php endif; ?>
                        </div>
                        <?php if (empty($listDokumen['pengajuan'])): ?>
                            <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data" class="d-flex gap-1 mt-1">
                                <?= View::csrf() ?>
                                <input type="hidden" name="jenis_dokumen" value="pengajuan">
                                <input type="file" name="berkas_dokumen" class="form-control form-control-sm" accept="image/*,application/pdf" required>
                                <button type="submit" class="btn btn-sm btn-primary py-0 px-2"><i class="bi bi-upload"></i></button>
                            </form>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
