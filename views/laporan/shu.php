<?php
$shu = $shuBersih ?? 0;
// Perhitungan Persentase sesuai requirement lo
$cadangan = $shu * 0.40;
$jasa = $shu * 0.40;
$pengurus = $shu * 0.10;
$pendidikan = $shu * 0.05;
$sosial = $shu * 0.05;
?>

<div class="mb-4 no-print d-flex justify-content-between align-items-center">
    <h2 class="page-title"><?= e($pageTitle) ?></h2>
    <button onclick="window.print()" class="btn btn-success shadow-sm"><i class="bi bi-printer me-2"></i>Cetak SHU</button>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-0 shadow-lg mb-4 bg-white" style="border-radius: 1rem;">
            <div class="card-body p-5">
                <div class="text-center mb-5 border-bottom border-2 border-dark pb-3">
                    <h2 class="text-uppercase fw-bolder mb-1">Koperasi Harapan Mulya</h2>
                    <p class="mb-0 text-muted">Laporan Distribusi Sisa Hasil Usaha (SHU)</p>
                    <p class="fw-bold text-success mb-0">Total SHU Bersih: <?= formatRupiah($shu) ?></p>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center text-uppercase">
                            <tr>
                                <th class="text-start">Alokasi Pembagian</th>
                                <th>Persentase</th>
                                <th class="text-end">Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cadangan Koperasi</td>
                                <td class="text-center">40%</td>
                                <td class="text-end font-monospace"><?= formatRupiah($cadangan) ?></td>
                            </tr>
                            <tr>
                                <td>Jasa Anggota (Simpanan & Pinjaman)</td>
                                <td class="text-center">40%</td>
                                <td class="text-end font-monospace"><?= formatRupiah($jasa) ?></td>
                            </tr>
                            <tr>
                                <td>Dana Pengurus & Karyawan</td>
                                <td class="text-center">10%</td>
                                <td class="text-end font-monospace"><?= formatRupiah($pengurus) ?></td>
                            </tr>
                            <tr>
                                <td>Dana Pendidikan</td>
                                <td class="text-center">5%</td>
                                <td class="text-end font-monospace"><?= formatRupiah($pendidikan) ?></td>
                            </tr>
                            <tr>
                                <td>Dana Sosial</td>
                                <td class="text-center">5%</td>
                                <td class="text-end font-monospace"><?= formatRupiah($sosial) ?></td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-success text-white fw-bold">
                            <tr>
                                <td colspan="2" class="text-end">TOTAL KESELURUHAN:</td>
                                <td class="text-end font-monospace fs-5"><?= formatRupiah($shu) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php require '_print_signature.php'; ?>
            </div>
        </div>
    </div>
</div>