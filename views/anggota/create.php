<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0"><?= $pageTitle ?></h2>
        <p class="text-muted small mb-0">Formulir pendaftaran anggota baru koperasi.</p>
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
                <h5 class="card-title">Informasi Personal</h5>
                <p class="card-description">Masukkan data lengkap anggota baru.</p>
            </div>
            <div class="card-body">
                <form action="<?= url('/anggota/store') ?>" method="POST">
                    <?= View::csrf() ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">No. Anggota</label>
                            <input type="text" name="no_anggota" class="form-control" value="<?= $no_anggota ?>"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Daftar</label>
                            <input type="date" name="tgl_daftar" class="form-control" value="<?= date('Y-m-d') ?>"
                                required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Ahmad Subarjo"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipe Anggota</label>
                            <select name="tipe" class="form-select" required>
                                <option value="DOSEN TETAP">DOSEN TETAP</option>
                                <option value="DOSEN KONTRAK">DOSEN KONTRAK</option>
                                <option value="DOSEN TIDAK TETAP">DOSEN TIDAK TETAP</option>
                                <option value="KARYAWAN TETAP">KARYAWAN TETAP</option>
                                <option value="KARYAWAN KONTRAK">KARYAWAN KONTRAK</option>
                                <option value="KARYAWAN TIDAK TETAP">KARYAWAN TIDAK TETAP</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Identitas (KTP/NIM/NIP)</label>
                            <input type="text" name="identitas_no" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prodi / Unit</label>
                            <input type="text" name="prodi_unit" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <h6 class="border-bottom pb-2">Informasi Akun User</h6>
                            <p class="text-muted small">Sistem akan secara otomatis membuatkan akun login untuk anggota baru ini.</p>
                        </div>
                        
                        <div class="col-12">
                            <div class="alert alert-info py-2 mb-0 d-flex align-items-center">
                                <small><i class="bi bi-info-circle me-1"></i> <b>Username</b> dan <b>Password</b> default akan otomatis disetel sama persis dengan <b>No. Anggota</b>. Keduanya dapat diubah oleh anggota bersangkutan nanti pada menu Pengaturan Profil.</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="<?= url('/anggota') ?>" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>