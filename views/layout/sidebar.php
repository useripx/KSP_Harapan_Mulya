<?php
$currentUser = Auth::user();
$userRole = Auth::role();

// Ambil URL saat ini dengan aman untuk logika menu
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
?>

<!-- CSS Khusus untuk Sub-Menu Pinjaman biar Abu-abu ke Biru Tanpa Blok Background -->
<style>
    #menuPinjaman a.sub-menu-item {
        color: #6c757d; /* Warna abu-abu (default) */
        text-decoration: none;
        display: block;
        transition: all 0.3s ease;
        background-color: transparent !important;
    }
    #menuPinjaman a.sub-menu-item:hover {
        color: #0d6efd !important;
        background-color: transparent !important;
    }
    #menuPinjaman a.sub-menu-item.active {
        color: #0d6efd !important;
        font-weight: 600;
        background-color: transparent !important;
        box-shadow: none !important;
    }
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="<?= url('/assets/img/img.png') ?>" alt="Logo">
        </div>
        <h4>Koperasi Harapan Mulya</h4>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-label">Utama</div>
        <ul class="sidebar-menu">
            <li>
                <?php
                $dashboardPath = '/dashboard';
                if ($userRole === ROLE_ADMIN)
                    $dashboardPath = '/validator';
                elseif ($userRole === ROLE_TELLER)
                    $dashboardPath = '/bau';
                elseif ($userRole === ROLE_KETUA)
                    $dashboardPath = '/manager';
                elseif ($userRole === ROLE_ANGGOTA)
                    $dashboardPath = '/anggota/dashboard';
                ?>
                <a href="<?= url($dashboardPath) ?>" class="<?= View::isActive($dashboardPath) ?>">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if (in_array($userRole, [ROLE_ADMIN, ROLE_TELLER])): ?>
                <li>
                    <a href="<?= url('/anggota') ?>" class="<?= View::isActive('/anggota') ?>">
                        <i class="bi bi-people"></i>
                        <span>Anggota</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-label">Transaksi</div>
        <ul class="sidebar-menu">
            <?php if (in_array($userRole, [ROLE_ADMIN, ROLE_TELLER, ROLE_ANGGOTA])): ?>
                <li>
                    <a href="<?= url('/simpanan') ?>" class="<?= View::isActive('/simpanan') ?>">
                        <i class="bi bi-wallet2"></i>
                        <span>Simpanan</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- ========================================== -->
            <!-- 1. MENU DATA PINJAMAN (MASTER LIST)        -->
            <!-- ========================================== -->
            <?php if (in_array($userRole, [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA])): ?>
                <?php 
                // Aktif hanya di halaman index atau detail pinjaman, BUKAN di form pengajuan
                $isDataPinjamanActive = preg_match('#^/pinjaman(?!/(baru|topup|darurat|pernyataan|pelunasan|simulasi))#', $uri);
                ?>
                <li>
                    <a href="<?= url('/pinjaman') ?>" class="<?= $isDataPinjamanActive ? 'active' : '' ?>">
                        <i class="bi bi-card-list"></i>
                        <span>Data Pinjaman</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- ========================================== -->
            <!-- 2. MENU PENGAJUAN PINJAMAN (DROPDOWN)      -->
            <!-- ========================================== -->
            <!-- Disembunyikan dari ROLE_KETUA karena Ketua hanya memvalidasi/melihat data -->
            <?php if (in_array($userRole, [ROLE_ADMIN, ROLE_TELLER, ROLE_ANGGOTA])): ?>
                <?php 
                // Aktif hanya jika URL mengandung form pengajuan
                $isPengajuanActive = preg_match('#^/pinjaman/(baru|topup|darurat|pernyataan|pelunasan)#', $uri);
                ?>
                <li>
                    <a href="#menuPinjaman" data-bs-toggle="collapse" class="<?= $isPengajuanActive ? 'active' : '' ?>" aria-expanded="<?= $isPengajuanActive ? 'true' : 'false' ?>">
                        <i class="bi bi-cash-stack"></i>
                        <span>Pengajuan Pinjaman</span>
                        <i class="bi bi-chevron-down ms-auto" style="float: right; margin-top: 4px; font-size: 0.8rem;"></i>
                    </a>
                    
                    <ul class="collapse <?= $isPengajuanActive ? 'show' : '' ?> list-unstyled" id="menuPinjaman" style="background-color: transparent; border-radius: 0 0 8px 8px;">

                        <!-- Form Baru Pinjaman -->
                        <li style="padding-left: 15px;">
                            <a href="<?= url('/pinjaman/ajukan') ?>" class="sub-menu-item <?= View::isActive('/pinjaman/ajukan') ?>" style="padding: 8px 15px; font-size: 0.9em;">
                                <i class="bi bi-file-earmark-plus me-2"></i> <span>Form Baru Pinjaman</span>
                            </a>
                        </li>

                        <!-- Top Up Pinjaman -->
                        <li style="padding-left: 15px;">
                            <a href="<?= url('/pinjaman/topup') ?>" class="sub-menu-item <?= View::isActive('/pinjaman/topup') ?>" style="padding: 8px 15px; font-size: 0.9em;">
                                <i class="bi bi-arrow-up-circle me-2"></i> <span>Top Up Pinjaman</span>
                            </a>
                        </li>
                        
                        <!-- Pinjaman Darurat -->
                        <li style="padding-left: 15px;">
                            <a href="<?= url('/pinjaman/darurat') ?>" class="sub-menu-item <?= View::isActive('/pinjaman/darurat') ?>" style="padding: 8px 15px; font-size: 0.9em;">
                                <i class="bi bi-exclamation-triangle me-2"></i> <span>Pinjaman Darurat</span>
                            </a>
                        </li>
                        
                        <!-- Cetak Pernyataan -->
                        <li style="padding-left: 15px;">
                            <a href="<?= url('/pinjaman/pernyataan') ?>" class="sub-menu-item <?= View::isActive('/pinjaman/pernyataan') ?>" style="padding: 8px 15px; font-size: 0.9em;">
                                <i class="bi bi-printer me-2"></i> <span>Cetak Pernyataan</span>
                            </a>
                        </li>
                        
                        <!-- Pelunasan Dipercepat -->
                        <li style="padding-left: 15px;">
                            <a href="<?= url('/pinjaman/pelunasan') ?>" class="sub-menu-item <?= View::isActive('/pinjaman/pelunasan') ?>" style="padding: 8px 15px; font-size: 0.9em;">
                                <i class="bi bi-check2-all me-2"></i> <span>Pelunasan Dipercepat</span>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php endif; ?>

            <!-- ========================================== -->
            <!-- 3. MENU SIMULASI (KHUSUS ANGGOTA)          -->
            <!-- ========================================== -->
            <?php if ($userRole === ROLE_ANGGOTA): ?>
                <li>
                    <a href="<?= url('/pinjaman/simulasi') ?>" class="<?= View::isActive('/pinjaman/simulasi') ?>">
                        <i class="bi bi-calculator"></i>
                        <span>Simulasi Pinjaman</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (in_array($userRole, [ROLE_ADMIN, ROLE_TELLER])): ?>
                <li>
                    <a href="<?= url('/angsuran') ?>" class="<?= View::isActive('/angsuran') ?>">
                        <i class="bi bi-calendar-check"></i>
                        <span>Angsuran</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <?php if (in_array($userRole, [ROLE_ADMIN, ROLE_KETUA, ROLE_TELLER])): ?>
        <div class="sidebar-section">
            <div class="sidebar-label">Analitik & Cetak</div>
            <ul class="sidebar-menu">
                <li>
                    <a href="<?= url('/laporan') ?>" class="<?= View::isActive('/laporan') ?>">
                        <i class="bi bi-printer"></i>
                        <span>Laporan/Cetak</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <div class="sidebar-section">
        <div class="sidebar-label">Sistem</div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?= url('/settings') ?>" class="<?= View::isActive('/settings') ?>">
                    <i class="bi bi-gear"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
            <?php if ($userRole === ROLE_ADMIN): ?>
                <li>
                    <a href="<?= url('/users') ?>" class="<?= View::isActive('/users') ?>">
                        <i class="bi bi-people"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?= url('/logout') ?>" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>