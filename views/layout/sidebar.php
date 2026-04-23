<?php
$currentUser = Auth::user();
$userRole = Auth::role();
?>

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

            <?php if (in_array($userRole, [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA])): ?>
                <li>
                    <?php
                    // Trik agar menu Pinjaman mati saat berada di halaman Simulasi
                    $uri = $_SERVER['REQUEST_URI'] ?? '';
                    $isSimulasi = strpos($uri, '/pinjaman/simulasi') !== false;
                    $pinjamanClass = $isSimulasi ? View::isActive('/path-mati') : View::isActive('/pinjaman');
                    ?>
                    <a href="<?= url('/pinjaman') ?>" class="<?= $pinjamanClass ?>">
                        <i class="bi bi-cash-stack"></i>
                        <span>Pinjaman</span>
                    </a>
                </li>
            <?php endif; ?>

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