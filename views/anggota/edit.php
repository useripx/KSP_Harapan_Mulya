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
                <h6 class="card-title text-muted mb-3 d-flex align-items-center">
                    <i class="bi bi-folder-fill me-2 text-warning fs-5"></i>
                    <span>Dokumen Kelengkapan</span>
                </h6>
                <div class="list-group list-group-flush small">
                    
                    <!-- DOKUMEN 1: KTP -->
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fw-semibold text-secondary d-flex align-items-center">
                                <i class="bi bi-card-heading me-2 text-primary fs-6"></i> KTP Anggota
                            </div>
                            <?php if (!empty($listDokumen['ktp'])): ?>
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 me-1" style="font-size: 0.65rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Terunggah
                                    </span>
                                    <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/ktp') ?>" class="btn btn-xs btn-outline-primary py-0 px-2 rounded-pill d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-eye"></i> Buka
                                    </a>
                                    <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/delete') ?>" method="POST" onsubmit="confirmDelete(event, 'KTP', '<?= e(addslashes($anggota['nama'])) ?>')">
                                        <?= View::csrf() ?>
                                        <input type="hidden" name="jenis_dokumen" value="ktp">
                                        <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2 rounded-pill d-flex align-items-center" style="font-size: 0.75rem;" title="Arsipkan ke KSP_Trash">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="bi bi-x-circle-fill me-1"></i>Belum diupload
                                </span>
                            <?php endif; ?>
                        </div>
                        <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data" class="d-flex gap-1 mt-2"
                              <?php if (!empty($listDokumen['ktp'])): ?>onsubmit="confirmOverwrite(event, 'KTP')"<?php endif; ?>>
                            <?= View::csrf() ?>
                            <input type="hidden" name="jenis_dokumen" value="ktp">
                            <input type="file" name="berkas_dokumen" class="form-control form-control-sm" accept="image/*,application/pdf" required>
                            <button type="submit" class="btn btn-sm btn-primary py-0 px-2 shadow-sm rounded-3" title="Unggah Dokumen"><i class="bi bi-upload"></i></button>
                        </form>
                        <?php if (empty($listDokumen['ktp'])): ?>
                        <div class="text-muted mt-1 d-flex align-items-center gap-1" style="font-size: 0.7rem; opacity: 0.85;">
                            <i class="bi bi-info-circle"></i>
                            <span>Format dokumen: JPG, PNG, atau PDF, Max 5MB.</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- DOKUMEN 2: KK -->
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fw-semibold text-secondary d-flex align-items-center">
                                <i class="bi bi-people me-2 text-primary fs-6"></i> Kartu Keluarga
                            </div>
                            <?php if (!empty($listDokumen['kk'])): ?>
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 me-1" style="font-size: 0.65rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Terunggah
                                    </span>
                                    <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/kk') ?>" class="btn btn-xs btn-outline-primary py-0 px-2 rounded-pill d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-eye"></i> Buka
                                    </a>
                                    <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/delete') ?>" method="POST" onsubmit="confirmDelete(event, 'KK', '<?= e(addslashes($anggota['nama'])) ?>')">
                                        <?= View::csrf() ?>
                                        <input type="hidden" name="jenis_dokumen" value="kk">
                                        <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2 rounded-pill d-flex align-items-center" style="font-size: 0.75rem;" title="Arsipkan ke KSP_Trash">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="bi bi-x-circle-fill me-1"></i>Belum diupload
                                </span>
                            <?php endif; ?>
                        </div>
                        <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data" class="d-flex gap-1 mt-2"
                              <?php if (!empty($listDokumen['kk'])): ?>onsubmit="confirmOverwrite(event, 'Kartu Keluarga')"<?php endif; ?>>
                            <?= View::csrf() ?>
                            <input type="hidden" name="jenis_dokumen" value="kk">
                            <input type="file" name="berkas_dokumen" class="form-control form-control-sm" accept="image/*,application/pdf" required>
                            <button type="submit" class="btn btn-sm btn-primary py-0 px-2 shadow-sm rounded-3" title="Unggah Dokumen"><i class="bi bi-upload"></i></button>
                        </form>
                        <?php if (empty($listDokumen['kk'])): ?>
                        <div class="text-muted mt-1 d-flex align-items-center gap-1" style="font-size: 0.7rem; opacity: 0.85;">
                            <i class="bi bi-info-circle"></i>
                            <span>Format dokumen: JPG, PNG, atau PDF, Max 5MB.</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- DOKUMEN 3: SURAT PERJANJIAN -->
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fw-semibold text-secondary d-flex align-items-center">
                                <i class="bi bi-file-earmark-text me-2 text-primary fs-6"></i> Surat Perjanjian
                            </div>
                            <?php if (!empty($listDokumen['perjanjian'])): ?>
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 me-1" style="font-size: 0.65rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Terunggah
                                    </span>
                                    <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/perjanjian') ?>" class="btn btn-xs btn-outline-primary py-0 px-2 rounded-pill d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-eye"></i> Buka
                                    </a>
                                    <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/delete') ?>" method="POST" onsubmit="confirmDelete(event, 'Surat Perjanjian', '<?= e(addslashes($anggota['nama'])) ?>')">
                                        <?= View::csrf() ?>
                                        <input type="hidden" name="jenis_dokumen" value="perjanjian">
                                        <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2 rounded-pill d-flex align-items-center" style="font-size: 0.75rem;" title="Arsipkan ke KSP_Trash">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="bi bi-x-circle-fill me-1"></i>Belum diupload
                                </span>
                            <?php endif; ?>
                        </div>
                        <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data" class="d-flex gap-1 mt-2"
                              <?php if (!empty($listDokumen['perjanjian'])): ?>onsubmit="confirmOverwrite(event, 'Surat Perjanjian')"<?php endif; ?>>
                            <?= View::csrf() ?>
                            <input type="hidden" name="jenis_dokumen" value="perjanjian">
                            <input type="file" name="berkas_dokumen" class="form-control form-control-sm" accept="image/*,application/pdf" required>
                            <button type="submit" class="btn btn-sm btn-primary py-0 px-2 shadow-sm rounded-3" title="Unggah Dokumen"><i class="bi bi-upload"></i></button>
                        </form>
                        <?php if (empty($listDokumen['perjanjian'])): ?>
                        <div class="text-muted mt-1 d-flex align-items-center gap-1" style="font-size: 0.7rem; opacity: 0.85;">
                            <i class="bi bi-info-circle"></i>
                            <span>Format dokumen: JPG, PNG, atau PDF, Max 5MB.</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- DOKUMEN 4: FORM PENGAJUAN -->
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fw-semibold text-secondary d-flex align-items-center">
                                <i class="bi bi-file-earmark-arrow-up me-2 text-primary fs-6"></i> Form Pengajuan
                            </div>
                            <?php if (!empty($listDokumen['pengajuan'])): ?>
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 me-1" style="font-size: 0.65rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Terunggah
                                    </span>
                                    <a href="<?= url('/anggota/dokumen/' . $anggota['id'] . '/pengajuan') ?>" class="btn btn-xs btn-outline-primary py-0 px-2 rounded-pill d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-eye"></i> Buka
                                    </a>
                                    <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/delete') ?>" method="POST" onsubmit="confirmDelete(event, 'Form Pengajuan', '<?= e(addslashes($anggota['nama'])) ?>')">
                                        <?= View::csrf() ?>
                                        <input type="hidden" name="jenis_dokumen" value="pengajuan">
                                        <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2 rounded-pill d-flex align-items-center" style="font-size: 0.75rem;" title="Arsipkan ke KSP_Trash">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="bi bi-x-circle-fill me-1"></i>Belum diupload
                                </span>
                            <?php endif; ?>
                        </div>
                        <form action="<?= url('/anggota/dokumen/' . $anggota['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data" class="d-flex gap-1 mt-2"
                              <?php if (!empty($listDokumen['pengajuan'])): ?>onsubmit="confirmOverwrite(event, 'Form Pengajuan')"<?php endif; ?>>
                            <?= View::csrf() ?>
                            <input type="hidden" name="jenis_dokumen" value="pengajuan">
                            <input type="file" name="berkas_dokumen" class="form-control form-control-sm" accept="image/*,application/pdf" required>
                            <button type="submit" class="btn btn-sm btn-primary py-0 px-2 shadow-sm rounded-3" title="Unggah Dokumen"><i class="bi bi-upload"></i></button>
                        </form>
                        <?php if (empty($listDokumen['pengajuan'])): ?>
                        <div class="text-muted mt-1 d-flex align-items-center gap-1" style="font-size: 0.7rem; opacity: 0.85;">
                            <i class="bi bi-info-circle"></i>
                            <span>Format dokumen: JPG, PNG, atau PDF, Max 5MB.</span>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(event, docType, memberName) {
    event.preventDefault();
    const form = event.currentTarget;
    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Apakah Anda yakin ingin menghapus Dokumen <strong>${docType} ${memberName}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

function confirmOverwrite(event, docType) {
    event.preventDefault();
    const form = event.currentTarget;
    Swal.fire({
        title: 'Konfirmasi Unggah',
        html: `Dokumen <strong>${docType}</strong> sudah ada.<br>Apakah Anda yakin ingin menimpa dokumen ini?<br><small class="text-muted">Dokumen lama akan otomatis dipindahkan ke folder KSP_Trash.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Timpa!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
