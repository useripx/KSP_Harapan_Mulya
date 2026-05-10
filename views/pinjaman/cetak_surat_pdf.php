<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Pinjaman - <?= htmlspecialchars($pinjaman['nama']) ?></title>
    <style>
        /* Setting Kertas A4 untuk Print/PDF */
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt; /* Ukuran standar dokumen resmi */
            line-height: 1.5;
            color: #000;
            margin: 0;
            background-color: #555; /* Warna luar kertas di layar */
        }
        .kertas-a4 {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            box-sizing: border-box;
        }

        /* Hilangkan margin & background saat diprint beneran */
        @media print {
            body { background-color: #fff; margin: 0; }
            .kertas-a4 { margin: 0; border-radius: 0; box-shadow: none; padding: 15mm 20mm; }
            /* Sembunyikan elemen lain jika ada */
        }

        /* Kop Surat */
        .kop-surat {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat td { vertical-align: middle; }
        .logo { width: 90px; }
        .teks-kop { text-align: left; padding-left: 15px; }
        .teks-kop h3, .teks-kop h4 { margin: 0; padding: 0; font-weight: bold; }
        .teks-kop h3 { font-size: 14pt; }
        .teks-kop h4 { font-size: 13pt; }
        .teks-kop p { margin: 0; font-size: 10pt; line-height: 1.2; }

        /* Isi Surat */
        .tabel-form { width: 100%; margin-top: 10px; }
        .tabel-form td { padding: 4px 0; vertical-align: top; }
        .tabel-form td:first-child { width: 200px; }
        .tabel-form td:nth-child(2) { width: 15px; }
        
        .list-status { margin: 0; padding: 0; list-style: none; }
        
        /* Tanda Tangan */
        .ttd-container { width: 100%; margin-top: 40px; }
        .ttd-container td { text-align: center; vertical-align: bottom; height: 120px; }
    </style>
</head>
<!-- Perintah sakti: Halaman akan otomatis ngebuka jendela Print/Save as PDF saat loading selesai -->
<body onload="window.print()">

    <div class="kertas-a4">
        <!-- KOP SURAT (Disesuaikan foto) -->
        <table class="kop-surat">
            <tr>
                <td width="10%"><img src="<?= url('/assets/img/img.png') ?>" class="logo" alt="Logo Koperasi"></td>
                <td class="teks-kop">
                    <h3>KOPERASI HARAPAN MULYA KEDIRI</h3>
                    <h4>UNIVERSITAS NUSANTARA PGRI KEDIRI</h4>
                    <p>No. BH....<br>KANTOR: Jl. KH. Achmad Dahlan 76 Telp. (0354) 771576 Kediri</p>
                </td>
            </tr>
        </table>

        <!-- METADATA SURAT -->
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td width="15%">Hal</td>
                <td width="5%">:</td>
                <td>Permohonan Pinjaman</td>
            </tr>
        </table>

        <div style="margin-bottom: 20px;">
            Kepada<br>
            Yth. Ketua KOPERASI HARAPAN MULYA<br>
            UNIVERSITAS NUSANTARA PGRI KEDIRI<br>
            Di Kediri
        </div>

        <p>Yang bertanda tangan di bawah ini :</p>

        <!-- FORM DATA DIRI ANGGOTA -->
        <table class="tabel-form">
            <tr>
                <td>Nama Lengkap (Gelar)</td>
                <td>:</td>
                <td><?= htmlspecialchars($pinjaman['nama']) ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= htmlspecialchars($pinjaman['alamat'] ?? '.........................................................................') ?></td>
            </tr>
            <tr>
                <td>No. Telp / Hp</td>
                <td>:</td>
                <td><?= htmlspecialchars($pinjaman['no_hp'] ?? '.........................................................................') ?></td>
            </tr>
            <tr>
                <td>No. Anggota Koperasi</td>
                <td>:</td>
                <td><?= htmlspecialchars($pinjaman['no_anggota']) ?></td>
            </tr>
            <tr>
                <td>Penghasilan</td>
                <td>:</td>
                <td>.........................................................................</td>
            </tr>
            <tr>
                <td>Status di UNP Kediri</td>
                <td>:</td>
                <td>
                    <ul class="list-status">
                        <li>1. DOSEN TETAP</li>
                        <li>2. DOSEN KONTRAK</li>
                        <li>3. DOSEN TIDAK TETAP</li>
                        <li>4. KARYAWAN TETAP</li>
                        <li>5. KARYAWAN KONTRAK</li>
                        <li>6. KARYAWAN TIDAK TETAP</li>
                    </ul>
                </td>
            </tr>
        </table>

        <p style="margin-top:20px;">Mengajukan Permohonan Pinjaman Uang :</p>
        
        <!-- DATA PINJAMAN -->
        <table class="tabel-form" style="margin-top: 0;">
            <tr>
                <td>Sebesar</td>
                <td>:</td>
                <td><strong><?= formatRupiah($pinjaman['pokok']) ?></strong></td>
            </tr>
            <tr>
                <td>Diangsur (Berapa Kali)</td>
                <td>:</td>
                <td><strong><?= htmlspecialchars($pinjaman['tenor_bulan']) ?> Kali</strong></td>
            </tr>
        </table>

        <p style="text-align: justify; margin-top: 25px;">
            Saya sanggup membayar, melaksanakan dan mematuhi peraturan yang berlaku di Koperasi Harapan Mulya Kediri.
        </p>
        <p style="text-align: justify;">
            Demikian surat permohonan ini, atas terkabulnya di ucapkan terima kasih.
        </p>

        <!-- AREA TANDA TANGAN -->
        <table class="ttd-container">
            <tr>
                <td width="33%" style="text-align: left; vertical-align: top;">
                    Atas Rekomendasi,<br><br><br><br><br><br>
                    .............................................
                </td>
                <td width="33%"></td>
                <td width="33%" style="text-align: left; vertical-align: top;">
                    Kediri, .................................... 20...<br>
                    Hormat saya,<br><br><br><br><br>
                    <strong>( <?= htmlspecialchars($pinjaman['nama']) ?> )</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" style="text-align: right; vertical-align: bottom; padding-right: 50px;">
                    Mengetahui/ Mengetahui Pengurus<br><br><br><br><br>
                    ............................................................
                </td>
            </tr>
        </table>
    </div>

</body>
</html>