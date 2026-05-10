<?php
// 1. HITUNG SEMUA TOTALAN DULU DI ATAS BIAR RAPI
$manualData = $manualData ?? ['aset_lancar' => [], 'aset_tetap' => [], 'kewajiban' => [], 'ekuitas' => []];

// Hitung Sub-Total per Section
$subTotalAL = ($saldoKas ?? 0) + ($piutang ?? 0) + array_sum(array_column($manualData['aset_lancar'], 'nominal'));
$subTotalAT = array_sum(array_column($manualData['aset_tetap'], 'nominal'));
$subTotalK  = ($totalSimpanan ?? 0) + array_sum(array_column($manualData['kewajiban'], 'nominal'));
$subTotalE  = ($ekuitas ?? 0) + array_sum(array_column($manualData['ekuitas'], 'nominal'));

// Hitung Grand Total
$grandTotalAset   = $subTotalAL + $subTotalAT;
$grandTotalPasiva = $subTotalK + $subTotalE;
?>

<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>">Laporan</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= e($pageTitle) ?></li>
            </ol>
        </nav>
        <h2 class="page-title mb-0"><?= e($pageTitle) ?></h2>
    </div>
    <div>
        <a href="<?= url('/laporan') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<?php 
$isYearlyOnly = true;
require '_filter_form.php'; 
?>

<style>
    /* Animasi Transisi buat Tombol Edit & Hapus */
    .btn-action-hover {
        transition: all 0.25s ease-in-out; /* Bikin transisi warnanya smooth */
    }
    .btn-action-hover:hover {
        /* background-color: #5b9cffff !important; /* Warna Biru Primary */
        color: #0d6efd !important; /* Teks berubah jadi putih */
        border-color: #0d6efd !important; /* Border ikut biru */
    }
    .btn-action-hover:hover i {
        color: #0d6efd !important; /* Icon pensil (kuning) & sampah (merah) dipaksa putih pas di-hover biar nyatu */
    }
</style>

<div class="card border-0 shadow-lg mb-4" style="border-radius: 1rem;">
    <div class="card-body p-5">
        <?php /*
        <div class="text-center mb-5 border-bottom border-2 pb-3 no-print">
            <h2 class="text-uppercase fw-bolder mb-1">KSP Harapan Mulya</h2>
            <p class="mb-0 text-muted">Laporan Neraca Keuangan</p>
            <p class="fw-bold text-primary mb-0">Per Tanggal: <?= e(date('d F Y')) ?> </p>
        </div>
        */ ?>

        <div class="mt-4">
            <div class="row mb-5 g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body py-3 text-center">
                            <span class="fw-bold fs-6 text-muted text-uppercase">Total Asset</span><br>
                            <span class="font-monospace fw-bold fs-2 text-body"><?= formatRupiah($grandTotalAset) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body py-3 text-center">
                            <span class="fw-bold fs-6 text-muted text-uppercase">Total Pasiva</span><br>
                            <span class="font-monospace fw-bold fs-2 text-body"><?= formatRupiah($grandTotalPasiva) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5 border rounded p-3 bg-body-tertiary">
                <h6 class="fw-bold text-body border-bottom pb-2 mb-3 text-uppercase">1.1 Current Asset</h6>
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th width="10%" class="text-center">Kode</th>
                            <th width="60%">Keterangan</th>
                            <th width="30%" class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1.1.1</td>
                            <td>Kas & Bank (Sistem)</td>
                            <td class="text-end font-monospace"><?= formatRupiah($saldoKas ?? 0) ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">1.1.2</td>
                            <td>Piutang Pinjaman (Sistem)</td>
                            <td class="text-end font-monospace"><?= formatRupiah($piutang ?? 0) ?></td>
                        </tr>
                        <?php foreach($manualData['aset_lancar'] as $idx => $item): ?>
                        <tr>
                            <td class="text-center">1.1.<?= $idx + 3 ?></td>
                            <td>
                                <?= e($item['nama_item']) ?>
                                <span class="badge border border-secondary text-body ms-2 no-print btn-action-hover" style="cursor:pointer;" onclick="bukaModalEdit(<?= $item['id'] ?>, '<?= $item['kategori'] ?>', '<?= htmlspecialchars($item['nama_item'], ENT_QUOTES) ?>', <?= $item['nominal'] ?>, <?= $item['tahun'] ?>)">
                                    <i class="bi bi-pencil-fill text-warning"></i> Edit
                                </span>
                                <span class="badge border border-secondary text-body ms-1 no-print btn-action-hover" style="cursor:pointer;" onclick="hapusItemNeraca(<?= $item['id'] ?>, <?= $item['tahun'] ?>)">
                                    <i class="bi bi-trash-fill text-danger"></i> Hapus
                                </span>
                            </td>
                            <td class="text-end font-monospace"><?= formatRupiah($item['nominal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="no-print">
                            <td colspan="3" class="text-center p-0">
                                <button class="btn btn-sm btn-outline-primary w-100 rounded-0 py-2 border-0" data-bs-toggle="modal" data-bs-target="#modalTambahNeraca" onclick="setKategori('aset_lancar')">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Item Current Asset
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end py-2">Subtotal Current Asset</td>
                            <td class="text-end py-2"><?= formatRupiah($subTotalAL) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mb-5 border rounded p-3 bg-body-tertiary">
                <h6 class="fw-bold text-body border-bottom pb-2 mb-3 text-uppercase">1.2 Fixed Asset</h6>
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th width="10%" class="text-center">Kode</th>
                            <th width="60%">Keterangan</th>
                            <th width="30%" class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($manualData['aset_tetap'] as $idx => $item): ?>
                        <tr>
                            <td class="text-center">1.2.<?= $idx + 1 ?></td>
                            <td>
                                <?= e($item['nama_item']) ?>
                                <span class="badge border border-secondary text-body ms-2 no-print btn-action-hover" style="cursor:pointer;" onclick="bukaModalEdit(<?= $item['id'] ?>, '<?= $item['kategori'] ?>', '<?= htmlspecialchars($item['nama_item'], ENT_QUOTES) ?>', <?= $item['nominal'] ?>, <?= $item['tahun'] ?>)">
                                    <i class="bi bi-pencil-fill text-warning"></i> Edit
                                </span>
                                <span class="badge border border-secondary text-body ms-1 no-print btn-action-hover" style="cursor:pointer;" onclick="hapusItemNeraca(<?= $item['id'] ?>, <?= $item['tahun'] ?>)">
                                    <i class="bi bi-trash-fill text-danger"></i> Hapus
                                </span>
                            </td>
                            <td class="text-end font-monospace"><?= formatRupiah($item['nominal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="no-print">
                            <td colspan="3" class="text-center p-0">
                                <button class="btn btn-sm btn-outline-primary w-100 rounded-0 py-2 border-0" data-bs-toggle="modal" data-bs-target="#modalTambahNeraca" onclick="setKategori('aset_tetap')">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Item Fixed Asset
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end py-2">Subtotal Fixed Asset</td>
                            <td class="text-end py-2"><?= formatRupiah($subTotalAT) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mb-5 border rounded p-3 bg-body-tertiary">
                <h6 class="fw-bold text-body border-bottom pb-2 mb-3 text-uppercase">2.1 Liability (Kewajiban)</h6>
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th width="10%" class="text-center">Kode</th>
                            <th width="60%">Keterangan</th>
                            <th width="30%" class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">2.1.1</td>
                            <td>Simpanan Anggota (Sistem)</td>
                            <td class="text-end font-monospace"><?= formatRupiah($totalSimpanan ?? 0) ?></td>
                        </tr>
                        <?php foreach($manualData['kewajiban'] as $idx => $item): ?>
                        <tr>
                            <td class="text-center">2.1.<?= $idx + 2 ?></td>
                            <td>
                                <?= e($item['nama_item']) ?>
                                <span class="badge border border-secondary text-body ms-2 no-print btn-action-hover" style="cursor:pointer;" onclick="bukaModalEdit(<?= $item['id'] ?>, '<?= $item['kategori'] ?>', '<?= htmlspecialchars($item['nama_item'], ENT_QUOTES) ?>', <?= $item['nominal'] ?>, <?= $item['tahun'] ?>)">
                                    <i class="bi bi-pencil-fill text-warning"></i> Edit
                                </span>
                                <span class="badge border border-secondary text-body ms-1 no-print btn-action-hover" style="cursor:pointer;" onclick="hapusItemNeraca(<?= $item['id'] ?>, <?= $item['tahun'] ?>)">
                                    <i class="bi bi-trash-fill text-danger"></i> Hapus
                                </span>
                            </td>
                            <td class="text-end font-monospace"><?= formatRupiah($item['nominal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="no-print">
                            <td colspan="3" class="text-center p-0">
                                <button class="btn btn-sm btn-outline-primary w-100 rounded-0 py-2 border-0" data-bs-toggle="modal" data-bs-target="#modalTambahNeraca" onclick="setKategori('kewajiban')">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Item Kewajiban
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end py-2">Subtotal Kewajiban</td>
                            <td class="text-end py-2"><?= formatRupiah($subTotalK) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mb-5 border rounded p-3 bg-body-tertiary">
                <h6 class="fw-bold text-body border-bottom pb-2 mb-3 text-uppercase">2.2 Equity (Ekuitas)</h6>
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th width="10%" class="text-center">Kode</th>
                            <th width="60%">Keterangan</th>
                            <th width="30%" class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">2.2.1</td>
                            <td>Modal / SHU Berjalan (Sistem)</td>
                            <td class="text-end font-monospace"><?= formatRupiah($ekuitas ?? 0) ?></td>
                        </tr>
                        <?php foreach($manualData['ekuitas'] as $idx => $item): ?>
                        <tr>
                            <td class="text-center">2.2.<?= $idx + 2 ?></td>
                            <td>
                                <?= e($item['nama_item']) ?>
                                <span class="badge border border-secondary text-body ms-2 no-print btn-action-hover" style="cursor:pointer;" onclick="bukaModalEdit(<?= $item['id'] ?>, '<?= $item['kategori'] ?>', '<?= htmlspecialchars($item['nama_item'], ENT_QUOTES) ?>', <?= $item['nominal'] ?>, <?= $item['tahun'] ?>)">
                                    <i class="bi bi-pencil-fill text-warning"></i> Edit
                                </span>
                                <span class="badge border border-secondary text-body ms-1 no-print btn-action-hover" style="cursor:pointer;" onclick="hapusItemNeraca(<?= $item['id'] ?>, <?= $item['tahun'] ?>)">
                                    <i class="bi bi-trash-fill text-danger"></i> Hapus
                                </span>
                            </td>
                            <td class="text-end font-monospace"><?= formatRupiah($item['nominal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="no-print">
                            <td colspan="3" class="text-center p-0">
                                <button class="btn btn-sm btn-outline-primary w-100 rounded-0 py-2 border-0" data-bs-toggle="modal" data-bs-target="#modalTambahNeraca" onclick="setKategori('ekuitas')">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Item Ekuitas
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end py-2">Subtotal Ekuitas</td>
                            <td class="text-end py-2"><?= formatRupiah($subTotalE) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

        <?php require '_print_signature.php'; ?>
    </div>
</div>

<div class="modal fade no-print" id="modalTambahNeraca" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Pos Neraca Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= url('/laporan/neraca/tambah') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Kategori Pos</label>
                        <select name="kategori" class="form-select" required>
                            <option value="aset_lancar">Aset Lancar</option>
                            <option value="aset_tetap">Aset Tetap</option>
                            <option value="kewajiban">Kewajiban (Liability)</option>
                            <option value="ekuitas">Ekuitas (Modal)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Item</label>
                        <input type="text" name="nama_item" class="form-control" placeholder="Contoh: Inventaris Kantor" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nominal (Rp)</label>
                        <input type="number" name="nominal" class="form-control" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Tahun Laporan</label>
                        <input type="number" name="tahun" class="form-control" value="<?= $_GET['tahun'] ?? date('Y') ?>" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setKategori(val) {
    document.querySelector('#modalTambahNeraca select[name="kategori"]').value = val;
}
</script>

<div class="modal fade no-print" id="modalEditNeraca" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Pos Neraca Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= url('/laporan/neraca/edit') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">Kategori Pos</label>
                        <select name="kategori" id="edit_kategori" class="form-select" required>
                            <option value="aset_lancar">Aset Lancar</option>
                            <option value="aset_tetap">Aset Tetap</option>
                            <option value="kewajiban">Kewajiban (Liability)</option>
                            <option value="ekuitas">Ekuitas (Modal)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Item</label>
                        <input type="text" name="nama_item" id="edit_nama_item" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nominal (Rp)</label>
                        <input type="number" name="nominal" id="edit_nominal" class="form-control" required>
                        <div class="form-text small">Gunakan tanda minus (-) di depan angka untuk nilai pengurang (contoh: -5000000).</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Tahun Laporan</label>
                        <input type="number" name="tahun" id="edit_tahun" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi buat ngisi data ke dalam Modal Edit pas tombol pensil diklik
function bukaModalEdit(id, kategori, nama_item, nominal, tahun) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_kategori').value = kategori;
    document.getElementById('edit_nama_item').value = nama_item;
    document.getElementById('edit_nominal').value = nominal;
    document.getElementById('edit_tahun').value = tahun;
    
    // Munculin modal edit-nya
    var editModal = new bootstrap.Modal(document.getElementById('modalEditNeraca'));
    editModal.show();
}
</script>