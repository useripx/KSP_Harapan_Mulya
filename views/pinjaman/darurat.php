<?php
$sisaHutang = $sisaHutang ?? 0;
?>
<div class="container-fluid mb-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h3 mb-0 text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Form Pinjaman Darurat</h2>
            <p class="text-muted small mt-1">Gunakan formulir ini hanya untuk keperluan mendesak yang membutuhkan dana cepat.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 4px solid #dc3545 !important;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="m-0 fw-bold text-danger">Detail Pengajuan Darurat</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    
                    <form action="<?= url('/pinjaman/store') ?>" method="POST">
                        <input type="hidden" name="jenis_pengajuan" value="DARURAT">

                        <!-- INFO SISA HUTANG (Sesuai Arahan Rapat) -->
                        <div class="alert alert-light border shadow-sm py-3 mb-4 d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-2 me-3 text-secondary"></i>
                            <div>
                                <span class="d-block small text-muted fw-bold text-uppercase">Sisa Hutang Saat Ini:</span>
                                <span class="fs-5 fw-bold <?= $sisaHutang > 0 ? 'text-danger' : 'text-success' ?>">
                                    <?= formatRupiah($sisaHutang) ?>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold text-gray-700">Nominal Darurat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                    <input type="number" name="pokok" class="form-control" placeholder="Contoh: 2000000" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-gray-700">Tenor (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" name="tenor_bulan" class="form-control" placeholder="Maksimal 12" min="1" max="12" required>
                            </div>
                        </div>
                        <!-- DROPDOWN METODE TRANSFER / TUNAI -->
<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label fw-semibold text-gray-700">Metode Pencairan & Pelunasan <span class="text-danger">*</span></label>
        <select name="metode" class="form-select" required>
            <option value="" disabled selected>-- Pilih Metode --</option>
            <option value="TRANSFER">Transfer</option>
            <option value="TUNAI">Tunai</option>
        </select>
    </div>
</div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-gray-700">Alasan Kondisi Darurat <span class="text-danger">*</span></label>
                            <textarea name="tujuan" class="form-control border-danger border-opacity-50" rows="3" placeholder="Jelaskan secara spesifik alasan mendesak Anda (Misal: Biaya rumah sakit, kecelakaan, dll)..." required></textarea>
                        </div>

                        <hr class="mb-4">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger px-4 fw-medium shadow-sm">
                                <i class="bi bi-lightning-charge me-2"></i>Kirim Pengajuan Darurat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card bg-danger bg-gradient shadow-sm border-0 h-100" style="border-radius: 12px;">
                <div class="card-body p-4 text-white">
                    <h5 class="fw-bold mb-4"><i class="bi bi-shield-exclamation text-warning me-2"></i>Ketentuan Darurat</h5>
                    
                    <div class="mb-3 border-bottom border-light border-opacity-25 pb-3">
                        <h6 class="fw-bold"><i class="bi bi-check2-circle text-light me-2"></i>Prioritas</h6>
                        <p class="small mb-0 opacity-75">Pinjaman darurat akan diprioritaskan untuk divalidasi lebih cepat dari pinjaman reguler.</p>
                    </div>
                    
                    <div>
                        <h6 class="fw-bold"><i class="bi bi-check2-circle text-light me-2"></i>Kebijakan</h6>
                        <p class="small mb-0 opacity-75">Jika Anda masih memiliki sisa hutang aktif, persetujuan akan bergantung pada rasio kemampuan bayar (Credit Score) Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>