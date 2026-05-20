<?php
$currentUser = Auth::user();
$userName = $currentUser['name'] ?? 'User';
$userRole = getRoleLabel($currentUser['role'] ?? ROLE_ANGGOTA);
$userInitials = getInitials($userName);
?>

<div class="topbar">
    <div class="topbar-left">
        <button class="toggle-btn" id="toggleBtn" title="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>

        <h1 class="page-title"><?= $pageTitle ?? 'Dashboard' ?></h1>
    </div>

    <div class="topbar-right d-flex align-items-center">
        <!-- Theme Toggle -->
        <button class="btn btn-link text-decoration-none me-3 p-0" id="themeToggle" onclick="toggleTheme()"
            title="Toggle Theme">
            <i class="bi bi-moon-fill text-muted" style="font-size: 20px;"></i>
        </button>

        <!-- 1. Notifikasi (Glow Dot UX) -->
        <?php $notifData = getPendingNotifications(); ?>
        <style>
            .notif-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                border: 1px solid white;
            }
            .pulse-red {
                background-color: var(--destructive, #dc3545);
                box-shadow: 0 0 0 rgba(220, 53, 69, 0.4);
                animation: pulse 1.5s infinite;
            }
            .steady-green {
                background-color: #198754;
            }
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
                70% { box-shadow: 0 0 0 8px rgba(220, 53, 69, 0); }
                100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
            }
        </style>
        <div class="dropdown me-3">
            <button class="btn btn-link text-decoration-none position-relative p-0" type="button"
                data-bs-toggle="dropdown" id="notifBellButton">
                <i class="bi bi-bell text-muted" style="font-size: 20px;"></i>
                <span class="position-absolute top-0 start-100 translate-middle notif-dot <?= ($notifData['count'] > 0) ? 'pulse-red' : 'steady-green' ?>"
                    id="notifBadge">
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="width: 320px; max-height: 400px; overflow-y: auto;">
                <li class="dropdown-header fw-bold">Notifikasi Sistem (<span id="notifCountText"><?= $notifData['count'] ?></span>)</li>
                <li><hr class="dropdown-divider"></li>
                <?php if (empty($notifData['items'])): ?>
                    <li><a class="dropdown-item small text-muted text-center py-3 pointer-events-none" href="#">✅ Tidak ada notifikasi baru.</a></li>
                <?php else: ?>
                    <?php foreach ($notifData['items'] as $notif): ?>
                    <li class="<?= $notif['is_read'] ? 'bg-light' : 'bg-white' ?>">
                        <a class="dropdown-item small border-bottom py-2" href="<?= $notif['link'] ?>">
                            <div class="d-flex align-items-start">
                                <i class="bi <?= $notif['icon'] ?> text-<?= $notif['tipe'] ?> mt-1 me-2 fs-5"></i>
                                <div>
                                    <div class="fw-bold <?= $notif['is_read'] ? 'text-muted' : 'text-dark' ?>"><?= $notif['judul'] ?></div>
                                    <div class="<?= $notif['is_read'] ? 'text-muted' : 'text-secondary' ?> text-wrap mt-1" style="font-size: 0.75rem; line-height: 1.3; white-space: normal;">
                                        <?= $notif['pesan'] ?>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 0.65rem;">
                                        <?= date('d M Y H:i', strtotime($notif['created_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifBell = document.getElementById('notifBellButton');
    const notifBadge = document.getElementById('notifBadge');
    const notifCountText = document.getElementById('notifCountText');

    if (notifBell && notifBadge) {
        notifBell.addEventListener('click', function () {
            // Jika sedanga dalam kondisi pulse-red (ada unread)
            if (notifBadge.classList.contains('pulse-red')) {
                // Tembak AJAX ke server untuk set as read
                fetch('<?= url("/api/notifikasi/read") ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Ubah cahaya merah berdenyut menjadi hijau tenang
                        notifBadge.classList.remove('pulse-red');
                        notifBadge.classList.add('steady-green');
                        if(notifCountText) notifCountText.innerText = '0';
                    }
                })
                .catch(err => console.error(err));
            }
        });
    }
});
</script>

        <!-- 2 & 3. Logo Icon & Nama User -->
        <div class="dropdown">
            <div class="user-info d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false"
                style="cursor: pointer;">
                <div class="user-avatar me-2 d-flex align-items-center justify-content-center fw-bold"
                    style="width: 32px; height: 32px; background: var(--secondary); border-radius: 50%; font-size: 12px; color: var(--primary);">
                    <?= e($userInitials) ?>
                </div>
                <div class="user-name fw-semibold me-2 d-none d-md-block" style="font-size: 14px; color: var(--foreground);">
                    <?= e($userName) ?>
                </div>
                <i class="bi bi-chevron-down small text-muted d-none d-md-block"></i>
            </div>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li>
                    <div class="dropdown-item-text">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3 d-flex align-items-center justify-content-center fw-bold"
                                style="width: 32px; height: 32px; background: var(--secondary); border-radius: 50%; font-size: 12px; color: var(--primary);">
                                <?= e($userInitials) ?>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--foreground);"><?= e($userName) ?></div>
                                <div style="font-size: 12px; color: var(--muted-foreground);">
                                    <?= e($currentUser['email'] ?? '-') ?></div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="<?= url('/profile') ?>">
                        <i class="bi bi-person me-2"></i>
                        Profil Saya
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="<?= url('/settings') ?>">
                        <i class="bi bi-gear me-2"></i>
                        Pengaturan
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="#"
                        onclick="event.preventDefault(); showLogoutModal();">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>