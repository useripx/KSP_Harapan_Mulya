<div class="mb-4">
    <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm rounded fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail Anggota
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="card-title mb-0"><?= $labelDokumen ?> - <?= e($anggota['nama']) ?></h5>
        <p class="text-muted small mb-0">No. Anggota: <?= e($anggota['no_anggota']) ?></p>
    </div>
    <div class="card-body text-center bg-light py-4">
        <?php if (!empty($namaFile)): ?>
            <?php 
                $ext = pathinfo(trim($namaFile), PATHINFO_EXTENSION);
                $fileUrl = url('/uploads/dokumen/' . trim($namaFile));
            ?>

            <?php if (in_array(strtolower($ext), ['pdf'])): ?>
                <div class="ratio ratio-4x3 mx-auto shadow-sm rounded" style="max-width: 900px;">
                    <embed src="<?= $fileUrl ?>" type="application/pdf" width="100%" height="600px" />
                </div>
            <?php else: ?>
                <div class="p-2 bg-white d-inline-block shadow-sm rounded">
                    <img src="<?= $fileUrl ?>" alt="<?= $labelDokumen ?>" class="img-fluid rounded" style="max-height: 550px; object-fit: contain;">
                </div>
            <?php endif; ?>
            
            <div class="mt-4">
                <a href="<?= $fileUrl ?>" download class="btn btn-primary fw-semibold btn-sm">
                    <i class="bi bi-download me-1"></i> Download File Asli
                </a>
            </div>

        <?php else: ?>
            <div class="py-5 text-center">
                <i class="bi bi-file-earmark-x text-danger display-1 mb-3"></i>
                <h5 class="text-secondary">Berkas dokumen fisik belum diunggah ke dalam sistem.</h5>
            </div>
        <?php endif; ?>
    </div>
</div>
