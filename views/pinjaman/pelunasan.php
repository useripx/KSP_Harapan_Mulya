<div class="container-fluid mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-3">
        <h2 class="h3 mb-1 text-gray-800 fw-bold">Rincian Jadwal & Pelunasan</h2>
        <a href="<?= url('/dashboard') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 fw-bold text-primary">Jadwal Pembayaran Mendatang</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">Bulan Ke-</th>
                            <th>Jatuh Tempo</th>
                            <th>Tagihan Angsuran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($jadwalAngsuran)): ?>
                            <tr><td colspan="4" class="text-center py-4">Tidak ada jadwal tagihan aktif.</td></tr>
                        <?php else: foreach($jadwalAngsuran as $jdwl): ?>
                            <tr>
                                <td class="px-4 fw-bold">Angsuran <?= $jdwl['angsuran_ke'] ?></td>
                                <td><?= date('d M Y', strtotime($jdwl['jatuh_tempo'])) ?></td>
                                <td class="text-danger fw-bold"><?= formatRupiah($jdwl['total_tagih']) ?></td>
                                <td><span class="badge bg-warning text-dark">Belum Lunas</span></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #f8f9fc;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Metode Pelunasan & Pembayaran</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-white rounded border border-primary border-start border-4 shadow-sm">
                        <h6 class="fw-bold text-primary">Transfer Bank BCA</h6>
                        <p class="small mb-0">Lakukan transfer ke rekening resmi Koperasi Harapan Mulya.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-white rounded border border-success border-start border-4 shadow-sm">
                        <h6 class="fw-bold text-success">Tunai (Cash)</h6>
                        <p class="small mb-0">Pembayaran tunai dilakukan langsung di kantor Koperasi.</p>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning mt-3 border-0">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Konfirmasi:</strong> Semua jenis pembayaran wajib dikonfirmasikan kepada <strong>Validator</strong> (Teller/Bendahara).
            </div>
        </div>
    </div>
</div>