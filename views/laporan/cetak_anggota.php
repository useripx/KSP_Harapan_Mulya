<?php
// Hitung apakah ada data motor/mobil
$hasMotor = !empty($ringkasanAnggota) && array_sum(array_column($ringkasanAnggota, 'simpanan_motor')) > 0;
$hasMobil = !empty($ringkasanAnggota) && array_sum(array_column($ringkasanAnggota, 'simpanan_mobil')) > 0;
$colCount = 8 + ($hasMotor ? 1 : 0) + ($hasMobil ? 1 : 0);

// Hitung total seluruh kolom
$totalWajib = array_sum(array_column($ringkasanAnggota, 'simpanan_wajib'));
$totalPokok = array_sum(array_column($ringkasanAnggota, 'simpanan_pokok'));
$totalSukarela = array_sum(array_column($ringkasanAnggota, 'simpanan_sukarela'));
$totalBelanja = array_sum(array_column($ringkasanAnggota, 'simpanan_belanja'));
$totalSosial = array_sum(array_column($ringkasanAnggota, 'simpanan_dana_sosial'));
$totalMotor = array_sum(array_column($ringkasanAnggota, 'simpanan_motor'));
$totalMobil = array_sum(array_column($ringkasanAnggota, 'simpanan_mobil'));
$totalAll = array_sum(array_column($ringkasanAnggota, 'total'));

// Memformat bulan ke Bahasa Indonesia
$namaBulanList = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$namaBulan = $namaBulanList[$bulan] ?? date('F', mktime(0, 0, 0, $bulan, 10));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Ringkasan Data Anggota <?= $namaBulan ?> <?= $tahun ?></title>
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS for spacing utilities only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Toolbar Styles */
        .toolbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .btn-premium-print {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-premium-print:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .btn-premium-excel {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-premium-excel:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white;
        }

        /* Printable Area */
        .print-container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 50px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .cop-koperasi {
            border-bottom: 3px double #334155;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: 700;
        }

        .koperasi-title {
            color: #0f172a;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .koperasi-subtitle {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .report-meta {
            font-size: 14px;
            color: #475569;
            font-weight: 500;
        }

        /* Printable Table CSS */
        .printable-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            font-size: 13px;
        }

        .printable-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
            text-align: center;
            padding: 10px 8px;
            border: 1px solid #cbd5e1;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .printable-table td {
            padding: 10px 8px;
            border: 1px solid #cbd5e1;
            color: #334155;
        }

        .printable-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        /* Signatures */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .signature-block {
            text-align: center;
            width: 250px;
        }

        .signature-space {
            height: 70px;
        }

        .signature-name {
            font-weight: 700;
            color: #1e293b;
            border-bottom: 1px solid #1e293b;
            padding-bottom: 4px;
            display: inline-block;
            min-width: 180px;
        }

        .signature-title {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Print styles overrides */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white;
                color: black;
                margin: 1.5cm !important; /* Margin cetak aman */
            }

            .print-container {
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
            }

            @page {
                size: landscape;
                margin: 0; /* Menghilangkan default header & footer browser */
            }
        }
    </style>
</head>
<body>

    <!-- Floating Top Toolbar (Screen Mode Only) -->
    <div class="toolbar no-print">
        <div class="max-width-container d-flex justify-content-between align-items-center" style="max-width: 1200px; margin: 0 auto;">
            <div class="d-flex align-items-center gap-2">
                <a href="<?= url('/laporan/pembukuan/lihat') ?>" class="btn btn-outline-secondary btn-sm rounded fw-semibold px-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <span class="text-muted fs-6">|</span>
                <span class="fw-semibold text-slate-800"><i class="bi bi-file-earmark-bar-graph me-1"></i> Mode Cetak Ringkasan Anggota (Periode <?= $namaBulan ?> <?= $tahun ?>)</span>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= url('/laporan/pembukuan/excel-anggota?tahun=' . $tahun . '&bulan=' . $bulan) ?>" class="btn btn-premium-excel btn-sm rounded px-3 py-2 shadow-sm">
                    <i class="bi bi-file-earmark-excel me-1"></i> Ekspor ke Excel
                </a>
                <button onclick="window.print()" class="btn btn-premium-print btn-sm rounded px-4 py-2 shadow-sm">
                    <i class="bi bi-printer me-1"></i> Cetak Sekarang
                </button>
            </div>
        </div>
    </div>

    <!-- Printable Paper Area -->
    <div class="print-container">
        
        <!-- COP Koperasi -->
        <div class="cop-koperasi d-flex align-items-center gap-3">
            <img src="<?= url('/assets/img/img.png') ?>" alt="Logo KSP" style="height: 64px; width: 64px; object-fit: contain; border-radius: 14px;">
            <div>
                <h3 class="koperasi-title mb-1">KSP HARAPAN MULYA</h3>
                <p class="koperasi-subtitle mb-0"><i class="bi bi-geo-alt-fill me-1 text-primary"></i> Jl. KH. Achmad Dahlan 76 Telp. (0354) 771576 Kediri.</p>
            </div>
        </div>

        <!-- Laporan Header -->
        <div class="report-header">
            <h4 class="report-title">Ringkasan Data Anggota & Saldo Simpanan Bulanan</h4>
            <p class="report-meta">Bulan Buku Laporan Keuangan: <strong class="text-primary"><?= strtoupper($namaBulan) ?> <?= $tahun ?></strong></p>
        </div>

        <!-- Tabel Data -->
        <table class="printable-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>No. Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Simpanan Wajib</th>
                    <th>Simpanan Pokok</th>
                    <th>Simpanan Sukarela</th>
                    <th>Simpanan Belanja</th>
                    <th>Simpanan Sosial</th>
                    <?php if ($hasMotor): ?>
                        <th>Simpanan Motor</th>
                    <?php endif; ?>
                    <?php if ($hasMobil): ?>
                        <th>Simpanan Mobil</th>
                    <?php endif; ?>
                    <th>Total Keseluruhan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ringkasanAnggota)): ?>
                    <tr>
                        <td colspan="<?= $colCount + 1 ?>" class="text-center py-4 text-muted italic">Tidak ada data anggota aktif pada tahun <?= $tahun ?></td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($ringkasanAnggota as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center fw-bold text-dark"><?= htmlspecialchars($row['no_anggota']) ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($row['nama']) ?></td>
                            <td class="text-right"><?= formatRupiah($row['simpanan_wajib'], false) ?></td>
                            <td class="text-right"><?= formatRupiah($row['simpanan_pokok'], false) ?></td>
                            <td class="text-right"><?= formatRupiah($row['simpanan_sukarela'], false) ?></td>
                            <td class="text-right"><?= formatRupiah($row['simpanan_belanja'], false) ?></td>
                            <td class="text-right"><?= formatRupiah($row['simpanan_dana_sosial'], false) ?></td>
                            <?php if ($hasMotor): ?>
                                <td class="text-right"><?= formatRupiah($row['simpanan_motor'], false) ?></td>
                            <?php endif; ?>
                            <?php if ($hasMobil): ?>
                                <td class="text-right"><?= formatRupiah($row['simpanan_mobil'], false) ?></td>
                            <?php endif; ?>
                            <td class="text-right fw-bold bg-light-subtle"><?= formatRupiah($row['total'], false) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    
                    <!-- Row Total Akumulasi -->
                    <tr class="fw-bold table-secondary">
                        <td colspan="3" class="text-center text-uppercase">Total Akumulasi</td>
                        <td class="text-right"><?= formatRupiah($totalWajib, false) ?></td>
                        <td class="text-right"><?= formatRupiah($totalPokok, false) ?></td>
                        <td class="text-right"><?= formatRupiah($totalSukarela, false) ?></td>
                        <td class="text-right"><?= formatRupiah($totalBelanja, false) ?></td>
                        <td class="text-right"><?= formatRupiah($totalSosial, false) ?></td>
                        <?php if ($hasMotor): ?>
                            <td class="text-right"><?= formatRupiah($totalMotor, false) ?></td>
                        <?php endif; ?>
                        <?php if ($hasMobil): ?>
                            <td class="text-right"><?= formatRupiah($totalMobil, false) ?></td>
                        <?php endif; ?>
                        <td class="text-right bg-light"><?= formatRupiah($totalAll, false) ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Tanda Tangan Section -->
        <div class="signature-section">
            <div class="signature-block">
                <p>Disetujui Oleh,</p>
                <div class="signature-space"></div>
                <p class="signature-name">Validator Koperasi</p>
                <p class="signature-title">Staff Bagian Umum (BAU)</p>
            </div>
            
            <div class="signature-block">
                <p>Dibuat & Disahkan Oleh,</p>
                <div class="signature-space"></div>
                <p class="signature-name">Yogi Ario</p>
                <p class="signature-title">Manager Koperasi</p>
            </div>
        </div>

    </div>

    <!-- Automatically Trigger Print Dialog on Load (Only when in actual printer mode) -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Kita kasih delay sedikit agar rendering halaman beres dulu
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>

</body>
</html>
