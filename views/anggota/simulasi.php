<div class="container-fluid mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white pt-3 pb-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-calculator"></i> Kalkulator Simulasi Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Nominal Pinjaman (Rp)</label>
                    <input type="number" id="pokok" class="form-control shadow-sm" value="5000000" min="500000">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Tenor (Bulan)</label>
                    <input type="number" id="tenor" class="form-control shadow-sm" value="12" min="1" max="35" placeholder="Maksimal 35 bulan">
                    <small class="text-danger">*Maksimal 35 Bulan</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Jenis Pembayaran</label>
                    <select id="jenis_pembayaran" class="form-select form-control shadow-sm">
                        <option value="ANGSURAN">Angsuran Bulanan (Bunga 0.6%)</option>
                        <option value="LUNAS">Sekali Bayar Lunas (Bunga 1%)</option>
                    </select>
                </div>
            </div>

            <button onclick="hitungSimulasi()" class="btn btn-primary mt-3 px-4 shadow-sm fw-semibold">
                <i class="bi bi-arrow-clockwise me-1"></i> Hitung Simulasi
            </button>
        </div>
    </div>

    <div id="hasil-simulasi" class="card shadow-sm mt-4 d-none border-0">
        <div class="card-header bg-success text-white pt-3 pb-3">
            <h6 class="mb-0 fw-bold">Rincian Jadwal Angsuran</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>Bulan Ke-</th>
                            <th class="text-end">Angsuran Pokok</th>
                            <th class="text-end">Angsuran Bunga</th>
                            <th class="text-end">Total Cicilan</th>
                            <th class="text-end pe-4">Sisa Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-body">
                        </tbody>
                </table>
            </div>

            <div id="pagination-simulasi" class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
                <div class="small fw-medium text-muted" id="simulasi-page-info">
                    Menampilkan data...
                </div>
                <div class="btn-group shadow-sm">
                    <button id="sim-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeSimPage(-1)">
                        <i class="bi bi-chevron-left me-1"></i> Sebelumnya
                    </button>
                    <button id="sim-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold" onclick="changeSimPage(1)">
                        Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Variabel penyimpan data untuk penomoran halaman
let dataSimulasi = [];
let currentPage = 1;
const rowsPerPage = 5;

// Fungsi format Rupiah
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR',
        minimumFractionDigits: 0 
    }).format(angka);
}

// Fungsi utama perhitungan
function hitungSimulasi() {
    let pokok = parseFloat(document.getElementById('pokok').value);
    let tenor = parseInt(document.getElementById('tenor').value);
    let jenis = document.getElementById('jenis_pembayaran').value;

    // Keamanan: Cek jika input tenor kosong atau melebihi batas
    if (!tenor || tenor < 1) {
        alert("Mohon masukkan jumlah tenor bulan yang benar.");
        return;
    }
    if (tenor > 35) {
        alert("Maaf, maksimal tenor pinjaman adalah 35 bulan.");
        return;
    }

    dataSimulasi = []; // Kosongkan data sebelumnya
    let sisaPokok = pokok;

    // Perhitungan Angsuran Bulanan (Bunga 0.6%)
    if (jenis === 'ANGSURAN') {
        let bungaPersen = 0.6 / 100;
        let pokokPerBulan = pokok / tenor;
        let bungaBulanIni = pokok * bungaPersen; // Bunga tetap dari awal pokok
        let totalCicilan = pokokPerBulan + bungaBulanIni;

        for (let bulan = 1; bulan <= tenor; bulan++) {
            sisaPokok -= pokokPerBulan;
            if(sisaPokok < 1) sisaPokok = 0; // Merapikan sisa desimal

            dataSimulasi.push({
                bulan: bulan,
                pokok: pokokPerBulan,
                bunga: bungaBulanIni,
                total: totalCicilan,
                sisa: sisaPokok
            });
        }
    } 
    // Perhitungan Sekali Bayar Lunas (Bunga 1%)
    else if (jenis === 'LUNAS') {
        let bungaPersen = 1 / 100;
        let bungaTotal = pokok * bungaPersen;
        let totalBayar = pokok + bungaTotal;

        // Hanya masukkan 1 baris data di akhir bulan tenor
        dataSimulasi.push({
            bulan: tenor,
            pokok: pokok,
            bunga: bungaTotal,
            total: totalBayar,
            sisa: 0
        });
    }

    // Tampilkan tabel mulai dari halaman pertama
    currentPage = 1;
    renderSimulasiTable();
    document.getElementById('hasil-simulasi').classList.remove('d-none');
}

// Fungsi menampilkan data ke tabel HTML
function renderSimulasiTable() {
    const tbody = document.getElementById('tabel-body');
    tbody.innerHTML = '';

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const pageData = dataSimulasi.slice(start, end);

    pageData.forEach(item => {
        let tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="align-middle fw-medium">${item.bulan}</td>
            <td class="text-end align-middle">${formatRupiah(item.pokok)}</td>
            <td class="text-end align-middle text-danger">${formatRupiah(item.bunga)}</td>
            <td class="text-end align-middle fw-bold text-success">${formatRupiah(item.total)}</td>
            <td class="text-end align-middle pe-4">${formatRupiah(item.sisa)}</td>
        `;
        tbody.appendChild(tr);
    });

    // Perbarui tulisan halaman dan tombol
    updatePaginationUI();
}

// Fungsi mengatur tombol halaman (Sebelumnya / Selanjutnya)
function updatePaginationUI() {
    const totalPages = Math.ceil(dataSimulasi.length / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, dataSimulasi.length);
    
    document.getElementById('simulasi-page-info').innerText = 
        `Menampilkan ${start}-${end} dari total ${dataSimulasi.length} data`;

    const prevBtn = document.getElementById('sim-prev-btn');
    const nextBtn = document.getElementById('sim-next-btn');

    prevBtn.disabled = (currentPage === 1);
    nextBtn.disabled = (currentPage === totalPages);

    // Sembunyikan tombol navigasi jika datanya sedikit (misal: bayar lunas cuma 1 baris)
    const nav = document.getElementById('pagination-simulasi');
    if (dataSimulasi.length <= rowsPerPage) {
        nav.classList.add('d-none');
    } else {
        nav.classList.remove('d-none');
    }
}

// Fungsi berpindah halaman
function changeSimPage(step) {
    currentPage += step;
    renderSimulasiTable();
}
</script>

<style>
.btn-white { background-color: #ffffff; }
.btn-white:hover:not(:disabled) { background-color: #f8fafc; color: #1e40af !important; }
.btn-white:disabled { background-color: #f1f5f9; color: #94a3b8 !important; cursor: not-allowed; }
</style>