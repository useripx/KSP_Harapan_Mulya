
<div class="container-fluid mb-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h3 mb-0 text-gray-800">Pencarian Arsip Anggota (Arsip)</h2>
            <p class="text-muted small">Cari riwayat arsip dokumen lama anggota yang telah diarsipkan atau ditimpa.</p>
        </div>
        <a href="<?= url('/laporan') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Laporan
        </a>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-archive text-primary mb-3" style="font-size: 3rem;"></i>
                    <h4 class="mb-4 fw-bold">Cari Arsip Anggota</h4>
                    
                    <div class="position-relative mb-4 text-start">
                        <div class="input-group input-group-lg shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0 text-muted" id="search-addon">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="arsipSearchInput" class="form-control border-start-0" placeholder="Ketik Nama, No Anggota, atau NIDN/NIY..." aria-label="Search" aria-describedby="search-addon" autocomplete="off">
                        </div>
                        <!-- Dropdown Suggestion -->
                        <div id="arsipSuggestions" class="list-group position-absolute w-100 shadow mt-1 d-none" style="z-index: 1000; max-height: 250px; overflow-y: auto;">
                            <!-- Hasil akan diinjeksi via JS -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Profil Hasil -->
            <div id="arsipResultPanel" class="card shadow-sm border-0 rounded-4 mt-4 d-none" style="border-left: 5px solid #fd7e14;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-3 me-3 text-secondary">
                                <i class="bi bi-person-badge fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" id="resNama">Nama Anggota</h5>
                                <div class="text-muted small">
                                    <span class="me-3"><i class="bi bi-upc-scan"></i> <span id="resNoAnggota">A001</span></span>
                                    <span><i class="bi bi-card-text"></i> <span id="resNidn">1234567</span></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="#" id="btnLihatArsip" target="_blank" class="btn btn-warning btn-lg fw-bold shadow-sm text-dark px-4">
                                <i class="bi bi-folder-symlink me-2"></i> Lihat Arsip
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('arsipSearchInput');
    const suggestionsBox = document.getElementById('arsipSuggestions');
    const resultPanel = document.getElementById('arsipResultPanel');
    
    const resNama = document.getElementById('resNama');
    const resNoAnggota = document.getElementById('resNoAnggota');
    const resNidn = document.getElementById('resNidn');
    const btnLihatArsip = document.getElementById('btnLihatArsip');

    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const q = this.value.trim();
        
        if (q.length < 2) {
            suggestionsBox.classList.add('d-none');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`<?= url('/api/arsip/search') ?>?q=${encodeURIComponent(q)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    if (data.success && data.data && data.data.length > 0) {
                        data.data.forEach(item => {
                            const a = document.createElement('a');
                            a.href = '#';
                            a.className = 'list-group-item list-group-item-action py-3';
                            
                            const noAnggota = item.no_anggota || '-';
                            const nidn = item.nidn_niy ? ` | NIDN: ${item.nidn_niy}` : '';
                            
                            a.innerHTML = `<div class="fw-bold">${item.nama}</div><small class="text-muted">${noAnggota}${nidn}</small>`;
                            
                            a.addEventListener('click', function(e) {
                                e.preventDefault();
                                
                                // Tutup suggestion
                                suggestionsBox.classList.add('d-none');
                                searchInput.value = item.nama;
                                
                                // Tampilkan data ke panel
                                resNama.textContent = item.nama;
                                resNoAnggota.textContent = noAnggota;
                                resNidn.textContent = item.nidn_niy || 'Tidak ada NIDN';
                                
                                // Buat link pencarian ke Google Drive Arsip_KSP
                                // Format Arsip_KSP folder adalah: {no_anggota}_{nama}
                                const folderName = `${noAnggota}_${item.nama}`;
                                // Encode query search Google Drive
                                const driveQuery = `type:folder name:"${folderName}"`;
                                btnLihatArsip.href = `https://drive.google.com/drive/search?q=${encodeURIComponent(driveQuery)}`;
                                
                                // Tampilkan panel
                                resultPanel.classList.remove('d-none');
                            });
                            
                            suggestionsBox.appendChild(a);
                        });
                        suggestionsBox.classList.remove('d-none');
                    } else {
                        suggestionsBox.innerHTML = '<div class="list-group-item text-muted p-3 text-center">Tidak ada anggota yang ditemukan.</div>';
                        suggestionsBox.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    console.error('Search error:', err);
                });
        }, 300); // 300ms debounce
    });
    
    // Sembunyikan suggestion jika klik di luar
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add('d-none');
        }
    });
});
</script>

