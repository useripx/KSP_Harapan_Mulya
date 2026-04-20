<?php $tunggakan = $tunggakan ?? []; ?>

<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= url('/laporan') ?>">Laporan</a></li>
                <li class="breadcrumb-item active">Tunggakan</li>
            </ol>
        </nav>
        <h2 class="page-title"><?= e($pageTitle) ?></h2>
    </div>
    <button onclick="window.print()" class="btn btn-danger shadow-sm">
        <i class="bi bi-printer me-2"></i>Cetak (Landscape)
    </button>
</div>

<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-4">
        <div class="text-center mb-4 d-none d-print-block border-bottom border-dark pb-3">
            <h3 class="text-uppercase fw-bold mb-1">KSP Harapan Mulya</h3>
            <p class="mb-0">Daftar Anggota Menunggak Angsuran</p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-dark text-white">
                    <tr class="text-uppercase" style="font-size: 0.85rem;">
                        <th class="text-center rounded-start">No</th>
                        <th>No. Anggota</th>
                        <th>Nama Peminjam</th>
                        <th class="text-center">Angsuran Ke</th>
                        <th class="text-center">Jatuh Tempo</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center rounded-end">Status (Hari Telat)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tunggakan)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data tunggakan. Koperasi aman!</td></tr>
                    <?php else: ?>
                        <?php $total = 0; foreach($tunggakan as $i => $t): $total += $t['total_tagih']; ?>
                        <tr>
                            <td class="text-center"><?= $i + 1 ?></td>
                            <td><code><?= e($t['no_anggota']) ?></code></td>
                            <td class="fw-bold"><?= e($t['nama']) ?></td>
                            <td class="text-center"><span class="badge bg-secondary"><?= $t['angsuran_ke'] ?></span></td>
                            <td class="text-center text-danger"><?= date('d M Y', strtotime($t['jatuh_tempo'])) ?></td>
                            <td class="text-end font-monospace"><?= formatRupiah($t['total_tagih']) ?></td>
                            <td class="text-center">
                                <span class="badge bg-danger rounded-pill"><?= $t['hari_telat'] ?> Hari</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <?php if (!empty($tunggakan)): ?>
                <tfoot class="table-light border-top border-2 border-dark">
                    <tr class="fw-bold">
                        <td colspan="5" class="text-end">TOTAL TUNGGAKAN:</td>
                        <td class="text-end font-monospace text-danger fs-6"><?= formatRupiah($total) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>

        <div class="d-none d-print-flex justify-content-between mt-5 pt-4">
            <div class="text-center" style="width: 200px;">
                <p class="mb-5">Mengetahui, Manajer</p>
                <p class="fw-bold border-bottom border-dark pb-1 mb-0">Bpk. Sudirman</p>
            </div>
            <div class="text-center" style="width: 200px;">
                <p class="mb-1">Kediri, <?= date('d F Y') ?></p>
                <p class="mb-5">Petugas Penagihan</p>
                <p class="fw-bold border-bottom border-dark pb-1 mb-0"><?= e($_SESSION['user_name'] ?? 'Admin') ?></p>
            </div>
        </div>
    </div>
</div>