<div class="container-fluid mb-5">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h3 mb-0 text-gray-800 fw-bold"><i class="bi bi-calculator text-primary me-2"></i>Simulasi Pinjaman</h2>
            <p class="text-muted small mt-1">Hitung estimasi rincian angsuran dan simpanan Anda per bulan.</p>
        </div>
    </div>

    <div class="row">
        <!-- Panel Form Input (Kiri) -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="m-0 fw-bold text-primary">Parameter Simulasi</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    
                    <!-- Informasi Tanggal Pengajuan (Otomatis Hari Ini) -->
                    <div class="alert alert-info border-0 small mb-4 py-2" role="alert">
                        <i class="bi bi-calendar-event me-2"></i>Tanggal Pengajuan: <strong id="tglPengajuanTeks">Hari Ini</strong>
                    </div>

                    <!-- Nominal -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-gray-700">Nominal Pinjaman</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                            <input type="number" class="form-control" id="nominal" placeholder="Contoh: 6000000">
                        </div>
                    </div>

                    <!-- Tenor -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-gray-700">Tenor (Bulan)</label>
                        <input type="number" class="form-control" id="tenor" placeholder="Maksimal 35 Bulan" min="1" max="35">
                    </div>

                    <!-- Bunga (Otomatis) -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-gray-700">Suku Bunga (% / Bulan)</label>
                        <div class="input-group">
                            <input type="number" step="0.1" class="form-control bg-light text-danger fw-bold" id="bunga" value="0" readonly>
                            <span class="input-group-text bg-light fw-bold text-muted">%</span>
                        </div>
                        <div class="form-text small text-info">
                            <i class="bi bi-info-circle me-1"></i>Otomatis: 1 bln = <?= e($settings['bunga_jangka_pendek']) ?>%, >1 bln = <?= e($settings['bunga_jangka_panjang']) ?>%
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100 fw-medium shadow-sm" onclick="hitungSimulasi()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Hitung Ulang
                    </button>
                </div>
            </div>
        </div>

        <!-- Panel Hasil Estimasi & Tabel (Kanan) -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="m-0 fw-bold text-primary">Hasil Estimasi & Rincian Kewajiban</h6>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    
                    <!-- PESAN ERROR (Awalnya Disembunyikan) -->
                    <div id="alertError" class="alert alert-danger border-0 shadow-sm d-none mb-4" role="alert" style="border-left: 4px solid #dc3545 !important;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Simulasi Gagal:</strong> Batas maksimal tenor adalah 35 Bulan!
                    </div>

                    <!-- KONTINER HASIL -->
                    <div id="kontainerHasil">
                        <!-- Ringkasan Atas -->
                        <div class="row text-center mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="p-3 bg-light rounded border">
                                    <p class="text-muted small fw-bold mb-1 text-uppercase">Total Bunga</p>
                                    <h5 class="fw-bold text-danger mb-0" id="hasilBunga">Rp 0</h5>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="p-3 bg-light rounded border">
                                    <p class="text-muted small fw-bold mb-1 text-uppercase">Pokok + Bunga</p>
                                    <h5 class="fw-bold text-warning mb-0" id="hasilTotal">Rp 0</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-primary bg-gradient text-white rounded shadow-sm h-100 d-flex flex-column justify-content-center">
                                    <p class="text-white-50 small fw-bold mb-1 text-uppercase">Total Tagihan / Bln</p>
                                    <h5 class="fw-bold mb-0" id="hasilTagihanBulan">Rp 0</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Jadwal Angsuran -->
                        <div class="mt-2 border-top pt-4" id="tabelJadwalContainer" style="display: none;">
                            <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-calendar3 me-2"></i>Rincian Jadwal Pembayaran</h6>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm text-center align-middle" style="font-size: 0.8rem; white-space: nowrap;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Bln</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Angsuran</th>
                                            <th>S. Pokok</th>
                                            <th>S. Wajib</th>
                                            <th>S. Sukarela</th>
                                            <th>S. Pinjaman</th>
                                            <th>D. Sosial</th>
                                            <th class="bg-primary text-white">Total Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyJadwal">
                                        <!-- Diisi oleh JavaScript -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination (Navigasi Next/Prev) -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <button class="btn btn-sm btn-outline-primary fw-medium" id="btnPrev" onclick="ubahHalaman(-1)">
                                    <i class="bi bi-chevron-left me-1"></i> Sebelumnya
                                </button>
                                <span class="small fw-bold text-muted" id="infoHalaman">Menampilkan 1-5</span>
                                <button class="btn btn-sm btn-outline-primary fw-medium" id="btnNext" onclick="ubahHalaman(1)">
                                    Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                                </button>
                            </div>
                            
                            <!-- TOMBOL LANJUT AJUKAN -->
                            <div class="mt-4 text-end border-top pt-3" id="containerBtnAjukan" style="display: none;">
                                <a href="#" id="btnAjukan" class="btn btn-success px-4 fw-medium shadow-sm">
                                    <i class="bi bi-send-check me-2"></i>Lanjut Ajukan Pinjaman
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="alert alert-secondary border-0 small mb-0 mt-auto pt-3" role="alert">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i><strong>Catatan Aturan:</strong> <br>
                        - Jatuh tempo selalu ditagihkan pada <strong>tanggal 1</strong> setiap bulan.<br>
                        - Pengajuan di atas tanggal 24 akan membuat tagihan pertama mundur satu bulan ekstra.<br>
                        - Angka Simpanan diatur Rp 10.000 sebagai rincian dasar.
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT JAVASCRIPT UNTUK LOGIKA OTOMATIS & PAGINATION -->
<script>
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    // Tampilkan Hari Ini
    let tglHariIni = new Date();
    document.getElementById('tglPengajuanTeks').innerText = tglHariIni.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

    // Variabel Global untuk Pagination
    let dataJadwalGlobal = []; 
    let halamanSaatIni = 1;
    const barisPerHalaman = 5;

    // Pantau saat ngetik Tenor
    document.getElementById('tenor').addEventListener('input', function() {
        let tenor = parseInt(this.value);
        let inputBunga = document.getElementById('bunga');
        
        const bungaPendek = <?= (float)($settings['bunga_jangka_pendek'] ?? 1.0) ?>;
        const bungaPanjang = <?= (float)($settings['bunga_jangka_panjang'] ?? 0.6) ?>;
        
        if (tenor === 1) {
            inputBunga.value = bungaPendek;
        } else if (tenor > 1) {
            inputBunga.value = bungaPanjang;
        } else {
            inputBunga.value = 0;
        }
        hitungSimulasi();
    });

    // Pantau saat ngetik Nominal
    document.getElementById('nominal').addEventListener('input', hitungSimulasi);

    // Fungsi Utama Kalkulasi
    function hitungSimulasi() {
        let nominal = parseFloat(document.getElementById('nominal').value) || 0;
        let tenor = parseInt(document.getElementById('tenor').value) || 0;
        let bungaBulan = parseFloat(document.getElementById('bunga').value) || 0;

        let alertError = document.getElementById('alertError');
        let kontainerHasil = document.getElementById('kontainerHasil');
        let containerTabel = document.getElementById('tabelJadwalContainer');
        let containerBtnAjukan = document.getElementById('containerBtnAjukan');
        let btnAjukan = document.getElementById('btnAjukan');

        if (tenor > 35) {
            alertError.classList.remove('d-none'); 
            kontainerHasil.classList.add('d-none'); 
            containerBtnAjukan.style.display = 'none'; 
            return; 
        } else {
            alertError.classList.add('d-none'); 
            kontainerHasil.classList.remove('d-none'); 
        }

        if (nominal > 0 && tenor > 0) {
            // 1. Hitung Ringkasan Utama (Pinjaman Saja)
            let totalBunga = (nominal * (bungaBulan / 100)) * tenor;
            let totalPokokBunga = nominal + totalBunga;
            let angsuranPinjaman = totalPokokBunga / tenor;

            // Variabel Simpanan (Pukul Rata 10 Ribu)
            let simpPokok = 10000;
            let simpWajib = 10000;
            let simpSukarela = 10000;
            let simpPinjaman = 10000;
            let danaSosial = 10000;
            let totalRincianExtra = simpPokok + simpWajib + simpSukarela + simpPinjaman + danaSosial;
            
            // Tagihan Per Bulan = Angsuran (Pokok+Bunga) + 5 Komponen Ekstra
            let tagihanPerBulanUtuh = angsuranPinjaman + totalRincianExtra;

            document.getElementById('hasilBunga').innerText = formatRupiah(totalBunga);
            document.getElementById('hasilTotal').innerText = formatRupiah(totalPokokBunga);
            document.getElementById('hasilTagihanBulan').innerText = formatRupiah(tagihanPerBulanUtuh);

            // 2. Siapkan Logika Tanggal Jatuh Tempo & Data Tabel
            dataJadwalGlobal = []; 
            let tglAju = tglHariIni.getDate();
            let blnAju = tglHariIni.getMonth();
            let thnAju = tglHariIni.getFullYear();

            // Aturan Koperasi: Jika pengajuan >= 25, lompat 2 bulan. Jika < 25, lompat 1 bulan.
            let startMonthOffset = (tglAju >= 25) ? 2 : 1;

            for (let i = 0; i < tenor; i++) {
                // Jatuh tempo selalu tanggal 1
                let jatuhTempo = new Date(thnAju, blnAju + startMonthOffset + i, 1);
                let tglFormat = jatuhTempo.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

                dataJadwalGlobal.push({
                    bulanKe: i + 1,
                    tanggal: tglFormat,
                    angsuran: angsuranPinjaman,
                    simpPokok: simpPokok,
                    simpWajib: simpWajib,
                    simpSukarela: simpSukarela,
                    simpPinjaman: simpPinjaman,
                    danaSosial: danaSosial,
                    totalBayar: tagihanPerBulanUtuh
                });
            }

            // 3. Tampilkan Halaman Tabel
            halamanSaatIni = 1;
            renderTabelPaginasi();
            containerTabel.style.display = 'block';

            // 4. Update Link Tombol
            containerBtnAjukan.style.display = 'block';
            btnAjukan.href = "<?= url('/pinjaman/ajukan') ?>?nominal=" + nominal + "&tenor=" + tenor;

        } else {
            document.getElementById('hasilBunga').innerText = "Rp 0";
            document.getElementById('hasilTotal').innerText = "Rp 0";
            document.getElementById('hasilTagihanBulan').innerText = "Rp 0";
            containerTabel.style.display = 'none';
            containerBtnAjukan.style.display = 'none';
        }
    }

    // Fungsi Render Tabel
    function renderTabelPaginasi() {
        let tbody = document.getElementById('tbodyJadwal');
        tbody.innerHTML = ''; 

        let start = (halamanSaatIni - 1) * barisPerHalaman;
        let end = start + barisPerHalaman;
        let dataDitampilkan = dataJadwalGlobal.slice(start, end);

        dataDitampilkan.forEach(item => {
            let row = `<tr>
                <td class="fw-bold">${item.bulanKe}</td>
                <td>${item.tanggal}</td>
                <td class="text-secondary">${formatRupiah(item.angsuran)}</td>
                <td class="text-muted">${formatRupiah(item.simpPokok)}</td>
                <td class="text-muted">${formatRupiah(item.simpWajib)}</td>
                <td class="text-muted">${formatRupiah(item.simpSukarela)}</td>
                <td class="text-muted">${formatRupiah(item.simpPinjaman)}</td>
                <td class="text-muted">${formatRupiah(item.danaSosial)}</td>
                <td class="fw-bold text-primary bg-light">${formatRupiah(item.totalBayar)}</td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
        });

        let totalData = dataJadwalGlobal.length;
        let tampilSampai = Math.min(end, totalData);
        document.getElementById('infoHalaman').innerText = `Menampilkan ${start + 1} - ${tampilSampai} dari ${totalData} Bln`;

        document.getElementById('btnPrev').disabled = (halamanSaatIni === 1);
        document.getElementById('btnNext').disabled = (end >= totalData);
    }

    function ubahHalaman(arah) {
        halamanSaatIni += arah;
        renderTabelPaginasi();
    }
    // FITUR ANTI CApek: Auto-fill dari URL kalau user habis klik "Kembali ke Simulasi"
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const uNom = urlParams.get('nominal');
        const uTen = urlParams.get('tenor');
        
        if (uNom && uTen) {
            document.getElementById('nominal').value = uNom;
            document.getElementById('tenor').value = uTen;
            // Pancing trigger input agar hitungSimulasi otomatis jalan tanpa diklik!
            document.getElementById('tenor').dispatchEvent(new Event('input'));
        }
    };
</script>