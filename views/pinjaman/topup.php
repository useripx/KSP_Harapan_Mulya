<?php
// Tangkap data
$nominalOtomatis = $nominalOtomatis ?? '';
$tenorOtomatis = $tenorOtomatis ?? '';
$sisaHutang = $sisaHutang ?? 0;
?>
<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Pengajuan Top Up Pinjaman</h2>
        <p class="text-muted small mb-0">Anda memiliki pinjaman aktif. Silakan isi form di bawah untuk tambah saldo.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="<?= url('/dashboard') ?>" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

    <div class="row">
        <!-- Panel Form (Kiri) -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="m-0 fw-bold text-success">Detail Top Up Pinjaman</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    
                    <form action="<?= url('/pinjaman/store') ?>" method="POST">
                        <input type="hidden" name="jenis_pengajuan" value="TOP_UP">

                        <!-- INFO SISA HUTANG OTOMATIS -->
                        <div class="alert alert-warning border-0 shadow-sm py-3 mb-4 d-flex align-items-center" style="border-left: 4px solid #ffc107 !important;">
                            <i class="bi bi-wallet2 fs-2 me-3 text-warning"></i>
                            <div>
                                <span class="d-block small text-muted fw-bold text-uppercase">Sisa Hutang Saat Ini:</span>
                                <span class="fs-5 fw-bold text-dark"><?= formatRupiah($sisaHutang) ?></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Input Nominal Baru -->
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold text-gray-700">Nominal Tambahan (Top Up) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                    <input type="number" name="pokok" class="form-control" value="<?= htmlspecialchars($nominalOtomatis) ?>" required readonly>
                                </div>
                                <div class="form-text small text-muted">Didapatkan dari hasil simulasi.</div>
                            </div>

                            <!-- Input Tenor Baru -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-gray-700">Tenor Baru (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" name="tenor_bulan" class="form-control" value="<?= htmlspecialchars($tenorOtomatis) ?>" required readonly>
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

                        <!-- Keperluan/Tujuan -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-gray-700">Tujuan Top Up Dana <span class="text-danger">*</span></label>
                            <textarea name="tujuan" class="form-control" rows="3" placeholder="Jelaskan alasan pengajuan Top Up..." required></textarea>
                        </div>

                        <hr class="mb-4">

                        <div class="d-flex justify-content-end">
                            <a href="<?= url('/pinjaman/simulasi') ?>" class="btn btn-light border me-2 fw-medium">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Simulasi
                            </a>
                            <button type="submit" class="btn btn-success px-4 fw-medium shadow-sm">
                                <i class="bi bi-send-check me-2"></i>Kirim Pengajuan Top Up
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel Info Ketentuan (Kanan) -->
        <div class="col-xl-4 col-lg-5">
            <div class="card bg-success bg-gradient shadow-sm border-0 h-100" style="border-radius: 12px;">
                <div class="card-body p-4 text-white">
                    <h5 class="fw-bold mb-4"><i class="bi bi-info-circle text-warning me-2"></i>Sistem Top Up</h5>
                    
                    <div class="mb-3 border-bottom border-light border-opacity-25 pb-3">
                        <h6 class="fw-bold"><i class="bi bi-check2-circle text-light me-2"></i>Penyatuan Hutang</h6>
                        <p class="small mb-0 opacity-75">Hutang lama Anda akan digabungkan dengan nominal Top Up yang baru, kemudian dibagi dengan tenor baru yang Anda ajukan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>