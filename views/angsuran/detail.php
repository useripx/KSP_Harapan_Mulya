<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 d-print-none">
    <div>
        <h2 class="page-title mb-0">Kuitansi Pembayaran #<?= str_pad($payment['id'], 6, '0', STR_PAD_LEFT) ?></h2>
        <p class="text-muted small mb-0">Bukti pembayaran resmi koperasi.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded fw-semibold shadow-sm">
            <i class="bi bi-printer me-1"></i> Cetak
        </button>
        <button id="btnDownloadPDF" class="btn btn-success btn-sm rounded fw-semibold shadow-sm">
            <i class="bi bi-file-earmark-pdf me-1"></i> Simpan PDF
        </button>
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="receipt-container">
    <div class="receipt-card px-5 py-5 shadow-sm bg-white border">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div class="company-brand">
                <h1 class="receipt-title mb-0">Kuitansi Pembayaran #<?= str_pad($payment['id'], 6, '0', STR_PAD_LEFT) ?></h1>
                <div class="mt-3">
                    <div class="row g-1">
                        <div class="col-5 text-muted small fw-bold">Tanggal:</div>
                        <div class="col-7 small"><?= formatTanggal($payment['tanggal_bayar']) ?></div>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <div class="d-inline-flex align-items-center mb-2">
                    <span class="fs-4 fw-bold text-success text-uppercase" style="letter-spacing: -0.02em;">Koperasi Harapan Mulya</span>
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center ms-3" style="width: 38px; height: 38px; min-width: 38px;">
                        <i class="bi bi-graph-up-arrow text-white fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participant Section -->
        <div class="row mb-5">
            <div class="col-6">
                <!-- Empty for alignment like example -->
            </div>
            <div class="col-6 text-end">
                <div class="member-box">
                    <span class="small fw-bold text-muted text-uppercase d-block mb-1">NASABAH / ANGGOTA</span>
                    <h5 class="fw-bold mb-1 text-success"><?= e($payment['anggota_nama']) ?></h5>
                    <p class="small text-muted mb-0">ID: <?= e($payment['no_anggota']) ?></p>
                </div>
            </div>
        </div>

        <!-- Details Table -->
        <div class="table-responsive mb-4">
            <table class="table receipt-table">
                <thead>
                    <tr>
                        <th class="ps-0">KETERANGAN</th>
                        <th class="text-center">ANGSURAN</th>
                        <th class="text-end">NOMINAL POKOK</th>
                        <th class="text-end">BUNGA</th>
                        <th class="text-end pe-0">SUB TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-0 py-3">
                            <div class="fw-bold">Bayar Angsuran Pinjaman #<?= $payment['pinjaman_id'] ?></div>
                            <div class="text-muted small italic">Metode: <?= e($payment['keterangan']) ?></div>
                        </td>
                        <td class="text-center py-3">Ke-<?= $payment['angsuran_ke'] ?></td>
                        <td class="text-end py-3"><?= formatRupiah($payment['pokok_bayar']) ?></td>
                        <td class="text-end py-3"><?= formatRupiah($payment['bunga_bayar']) ?></td>
                        <td class="text-end py-3 pe-0 fw-bold"><?= formatRupiah($payment['pokok_bayar'] + $payment['bunga_bayar']) ?></td>
                    </tr>
                    <?php if ($payment['denda'] > 0): ?>
                    <tr>
                        <td colspan="4" class="text-end py-2 text-danger">Denda Keterlambatan</td>
                        <td class="text-end py-2 pe-0 text-danger fw-bold"><?= formatRupiah($payment['denda']) ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="row justify-content-end mb-5">
            <div class="col-md-5">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small fw-bold">SUB TOTAL</span>
                    <span class="fw-bold"><?= formatRupiah($payment['total'] - $payment['denda']) ?></span>
                </div>
                <?php if ($payment['denda'] > 0): ?>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small fw-bold">DENDA</span>
                    <span><?= formatRupiah($payment['denda']) ?></span>
                </div>
                <?php endif; ?>
                <div class="d-flex justify-content-between pt-3 border-top border-2 border-dark">
                    <span class="fw-bold fs-5">TOTAL</span>
                    <span class="fw-bold fs-4 text-success"><?= formatRupiah($payment['total']) ?></span>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <hr class="receipt-hr">
        <div class="row receipt-footer mt-4">
            <div class="col-7">
                <h6 class="fw-bold text-success mb-2">Koperasi Harapan Mulya</h6>
                <div class="small text-muted mb-1">Jl. Ahmad Dahlan No.76, Mojoroto, Kediri</div>
                <div class="small text-muted mb-1">Jawa Timur, Indonesia 64112</div>
                <div class="small text-muted">Telepon: (0354) 123456 | Email: info@harapanmulya.id</div>
            </div>
            <div class="col-5 text-end">
                <div class="signature-box mt-2">
                    <span class="small text-muted d-block mb-4 italic">Dibayar Kepada (Kasir)</span>
                    <h6 class="fw-bold mb-0"><?= e($payment['penerima_nama']) ?></h6>
                    <div class="small text-muted border-top d-inline-block pt-1 mt-1" style="min-width: 150px;">Stempel & Tanda Tangan</div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 d-print-none border-top pt-4">
            <p class="small text-muted mb-0 italic">Terima kasih telah melakukan pembayaran tepat waktu.</p>
        </div>
    </div>
</div>

<style>
/* Dashboard Styles */
body { background-color: #f4f7f6; }
.receipt-container { 
    max-width: 900px; 
    margin: 0 auto; 
    padding: 20px;
}
.receipt-card {
    border-radius: 4px;
    font-family: 'Inter', sans-serif;
    color: #333;
}
.receipt-title {
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
    font-style: italic;
}.text-success { color: #28a745 !important; }
.bg-success { background-color: #28a745 !important; }

.receipt-table thead th {
    background-color: #f8fcf9;
    border-bottom: 2px solid #28a745;
    color: #28a745;
    font-size: 11px;
    letter-spacing: 0.1em;
    padding: 12px 8px;
}
.receipt-table tbody td {
    border-bottom: 1px solid #eee;
    font-size: 14px;
}
.receipt-hr {
    border-top: 1px solid #28a745;
    opacity: 0.2;
}
.italic { font-style: italic; }

@media print {
    body { background-color: white !important; margin: 0; padding: 0; }
    .sidebar, .topbar, .toggle-btn, .d-print-none, footer { display: none !important; }
    .main-content { margin: 0 !important; padding: 0 !important; }
    .receipt-container { padding: 0; max-width: 100%; }
    .receipt-card { border: none !important; box-shadow: none !important; }
}
</style>

<!-- PDF Generation Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.getElementById('btnDownloadPDF').addEventListener('click', function() {
    const element = document.querySelector('.receipt-card');
    const invoiceNo = "<?= str_pad($payment['id'], 6, '0', STR_PAD_LEFT) ?>";
    
    const opt = {
        margin:       10,
        filename:     'Kuitansi_Harapan_Mulya_' + invoiceNo + '.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true, letterRendering: true },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save();
});
</script>
